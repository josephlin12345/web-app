async function get_posts(user_id, offset, limit) {
  const url = `${api_url}/post/get_user.php?id=${user_id}&offset=${offset}&limit=${limit}`;
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

function insert_posts(posts) {
  for(post of posts) {
    const post_element = make_post_element(post);
    posts_element.appendChild(post_element);
    check_read_more_button(posts_element.lastElementChild);
  }
}

function set_user_id(id) {
  user_id = id;
}

async function load_user_posts() {
  loading = true;
  const posts = await get_posts(user_id, offset, limit);
  if(posts.length == 0) stop_loading = true;
  offset += limit;
  insert_posts(posts);
  loading = false;
}

const api_url = 'http://i4010.isrcttu.net:9651/api';
let offset = 0;
const limit = 5;
var user_id = null;
let loading = false;
let stop_loading = false;
const tzoffset = (new Date()).getTimezoneOffset();

const posts_element = document.getElementById('posts');
const template = document.getElementById('post');

window.addEventListener('load', async () => {
  if(user_id) await load_user_posts();
});
window.addEventListener('scroll', async () => {
  const scroll_to_bottom = window.scrollY + window.innerHeight >= document.body.scrollHeight;
  if(scroll_to_bottom && !loading && !stop_loading) {
    await load_user_posts();
  }
});
