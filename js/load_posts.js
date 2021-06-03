async function get_posts(offset, limit) {
  const api_url = `http://i4010.isrcttu.net:9651/api/post/get.php?offset=${offset}&limit=${limit}`;
  const response = await fetch(api_url);
  const data = await response.json();
  return data['data'];
}

async function get_latest_posts(timestamp) {
  const api_url = `http://i4010.isrcttu.net:9651/api/post/get_latest.php?timestamp=${timestamp}`;
  const response = await fetch(api_url);
  const data = await response.json();
  return data['data'];
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

function check_read_more_button(post_element) {
  const content = post_element.querySelector('p');
  if(content.offsetHeight == content.scrollHeight) {
    const button = post_element.querySelector('button');
    post_element.removeChild(button);
  }
}

function insert_posts(new_posts, append) {
  if(append) {
    for(post of new_posts) {
      const post_element = make_post_element(post);
      post_elements[post['id']] = post_element;
      posts.appendChild(post_element);
      check_read_more_button(posts.lastElementChild);
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
      if(posts.childElementCount > 0) {
        const first_post = posts.children[0];
        first_post.parentNode.insertBefore(post_element, first_post);
      }
      else {
        posts.appendChild(post_element);
      }
      check_read_more_button(posts.firstElementChild);
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
