async function get_posts(offset, limit) {
  const api_url = `${window.location.origin}/api/get_posts.php?offset=${offset}&limit=${limit}`;
  const response = await fetch(api_url);
  return await response.json();
}

async function get_latest_posts(timestamp) {
  const api_url = `${window.location.origin}/api/get_latest_posts.php?timestamp=${timestamp}`;
  const response = await fetch(api_url);
  return await response.json();
}

function decodeHTML(text) {
  return text.replace(/&amp;/g, '&').replace(/&quot;/g, '\"').replace(/&lt;/g, '<').replace(/&gt;/g, '>')
}

function make_post_element(post) {
  const template = document.getElementById('post');
  template.content.querySelector('form').id = post['id'];
  template.content.querySelector('img').src = `${window.location.origin}/avatars/${post['creator_avatar']}`;
  template.content.querySelector('img').alt = post['creator_avatar'];
  template.content.querySelector('.creator-name').innerText = post['creator_name'];
  template.content.querySelector('.modified-at').innerText = post['modified_at'];
  template.content.querySelector('p').innerText = decodeHTML(post['content']);
  template.content.querySelector('button').setAttribute('onClick', `show_more(${post['id']})`);
  return template.content.cloneNode(true);
}

function insert_posts(new_posts, append) {
  if(append) {
    for(post of new_posts) {
      const post_element = make_post_element(post);
      post_elements[post['id']] = post_element;
      posts.appendChild(post_element);
    }
  }
  else {
    const post_ids = Object.keys(post_elements);
    for(post of new_posts) {
      if(post_ids.includes(post['id'])) {
        const child = posts.querySelector(`[id="${post['id']}"]`);
        posts.removeChild(child);
      }
      const post_element = make_post_element(post);
      post_elements[post['id']] = post_element;
      if(posts.children.length > 0) {
        const first_post = posts.children[0];
        first_post.parentNode.insertBefore(post_element, first_post);
      }
      else {
        posts.appendChild(post_element);
      }
    }
  }
}

async function load_earlier_posts() {
  loading = true;
  const data = await get_posts(offset, limit);
  if(data.length == 0) stop_loading = true;
  offset += limit;
  insert_posts(data, true);
  loading = false;
}

async function load_latest_posts() {
  const data = await get_latest_posts(latest_post_time);
  if(data.length > 0) {
    latest_post_time = data[data.length - 1]['modified_at'];
    insert_posts(data, false);
  }
}

let offset = 0;
const limit = 5;
let loading = false;
let stop_loading = false;
const post_elements = {};

const posts = document.getElementById('posts');
const tzoffset = (new Date()).getTimezoneOffset() * 60000;
let latest_post_time = (new Date(Date.now() - tzoffset)).toISOString();
setInterval(load_latest_posts, 30000);

window.addEventListener('load', load_earlier_posts);
window.addEventListener('scroll', async () => {
  const scroll_to_bottom = window.scrollY + window.innerHeight >= document.body.scrollHeight;
  if(scroll_to_bottom && !loading && !stop_loading) {
    await load_earlier_posts();
  }
});
