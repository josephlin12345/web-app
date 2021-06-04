async function get_posts(offset, limit) {
  const url = `${api_url}/post/get.php?offset=${offset}&limit=${limit}`;
  const response = await fetch(url);
  const data = await response.json();
  return data['data'];
}

async function get_latest_posts(timestamp) {
  const url = `${api_url}/post/get_latest.php?timestamp=${timestamp}`;
  const response = await fetch(url);
  const data = await response.json();
  return data['data'];
}

function decodeHTML(text) {
  return text.replace(/&amp;/g, '&').replace(/&quot;/g, '\"').replace(/&lt;/g, '<').replace(/&gt;/g, '>')
}

function make_post_element(post) {
  const clone = template.content.cloneNode(true);
  clone.querySelector('form').id = post['id'];
  clone.querySelector('img').src = `${api_url}/user/get_avatar.php?id=${post['creator_id']}`;
  clone.querySelector('a').href = `${window.location.origin}/user/posts.php?id=${post['creator_id']}`;
  clone.querySelector('.creator-name').innerText = post['creator_name'];
  const modified_at = new Date(post['modified_at']);
  modified_at.setMinutes(modified_at.getMinutes() - tzoffset);
  clone.querySelector('.modified-at').innerText = modified_at.toLocaleString();
  clone.querySelector('.post-content').innerText = decodeHTML(post['content']);
  clone.querySelector('button').setAttribute('onClick', `show_more(${post['id']})`);
  return clone;
}

function check_read_more_button(post_element) {
  const content = post_element.querySelector('.post-content');
  if(content.offsetHeight == content.scrollHeight) {
    const button = post_element.querySelector('button');
    post_element.removeChild(button);
  }
}

function insert_posts(posts, append) {
  const post_ids = Object.keys(post_elements);
  for(post of posts) {
    const post_element = make_post_element(post);
    post_elements[post['id']] = post_element;

    if(append) {
      posts_element.appendChild(post_element);
      check_read_more_button(posts_element.lastElementChild);
    }
    else {
      if(post_ids.includes(post['id'])) {
        const child = posts_element.querySelector(`[id="${post['id']}"]`);
        posts_element.removeChild(child);
      }
      posts_element.insertBefore(post_element, posts_element.firstElementChild);
      check_read_more_button(posts_element.firstElementChild);
    }
  }
}

async function load_posts() {
  loading = true;
  const posts = await get_posts(offset, limit);
  if(posts.length == 0) stop_loading = true;
  offset += limit;
  insert_posts(posts, true);
  loading = false;
}

async function load_latest_posts() {
  const posts = await get_latest_posts(latest_post_time);
  if(posts.length > 0) {
    latest_post_time = posts[posts.length - 1]['modified_at'];
    insert_posts(posts, false);
  }
}

const api_url = 'http://i4010.isrcttu.net:9651/api';
let offset = 0;
const limit = 5;
let loading = false;
let stop_loading = false;
const post_elements = {};
const tzoffset = (new Date()).getTimezoneOffset();
let latest_post_time = (new Date()).toISOString();

const posts_element = document.getElementById('posts');
const template = document.getElementById('post');

setInterval(load_latest_posts, 60000);

window.addEventListener('load', load_posts);
window.addEventListener('scroll', async () => {
  const scroll_to_bottom = window.scrollY + window.innerHeight >= document.body.scrollHeight;
  if(scroll_to_bottom && !loading && !stop_loading) {
    await load_posts();
  }
});
