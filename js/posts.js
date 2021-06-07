function create_post(user_id) {
  const content = document.querySelector('.create-post').value;
  if(content.length) {
    const postdata = {
      creator_id: user_id,
      content: content,
      recaptcha_response: document.getElementById('recaptcha_response').value,
      lang: lang
    };
    fetch(`${api_url}/post/create.php`, {
      method: 'POST',
      body: JSON.stringify(postdata)
    })
    .then(response => response.json())
    .then(data => {
      if(data['error']) alert(data['error']['recaptcha_err']);
      else {
        document.querySelector('.create-post').value = '';
        generate_token();
        load_posts('latest');
      }
    });
  }
}

async function get(url) {
  const response = await fetch(url);
  return await response.json();
}

function show_more(post_id) {
  const post = document.getElementById(`post-${post_id}`);
  const content = post.querySelector('.content');
  const button = post.querySelector('[name="show_more"]');
  const show = content.classList.toggle('show-all-content');
  if(show) button.innerText = 'Show Less';
  else button.innerText = 'Show More';
}

function decodeHTML(text) {
  return text.replace(/&amp;/g, '&').replace(/&quot;/g, '\"').replace(/&lt;/g, '<').replace(/&gt;/g, '>')
}

function make_post_element(post) {
  const clone = post_template.content.cloneNode(true);
  clone.querySelector('.post').id = `post-${post['id']}`;
  clone.querySelector('.comments').id = `comments-${post['id']}`;
  clone.querySelector('img').src = `${api_url}/user/get_avatar.php?id=${post['creator_id']}`;
  // remove /app
  clone.querySelector('a').href = `${window.location.origin}/app/user/posts.php?id=${post['creator_id']}`;
  clone.querySelector('.creator-name').innerText = post['creator_name'];
  const modified_at = new Date(post['modified_at']);
  modified_at.setMinutes(modified_at.getMinutes() - tzoffset);
  clone.querySelector('.modified-at').innerText = modified_at.toLocaleString();
  clone.querySelector('.content').innerText = decodeHTML(post['content']);
  clone.querySelector('[name="show_more"]').setAttribute('onClick', `show_more(${post['id']})`);
  clone.querySelector('[name="comments"]').setAttribute('onClick', `show_comments(${post['id']})`);
  clone.querySelector('[name="load_more_comments"]').setAttribute('onClick', `load_comments(${post['id']}, false)`);
  if(user_id) {
    clone.querySelector('.create-comment').id = `textarea-${post['id']}`;
    clone.querySelector('[name="create_comment"]').setAttribute('onClick', `create_comment(${post['id']})`);
  }
  return clone;
}

function check_show_button(post_element) {
  const content = post_element.querySelector('.content');
  if(content.offsetHeight == content.scrollHeight) {
    const button = post_element.querySelector('[name="show_more"]');
    post_element.removeChild(button);
  }
}

function insert_posts(posts, append) {
  for(post of posts) {
    const post_element = make_post_element(post);
    if(append) {
      posts_element.appendChild(post_element);
      check_show_button(posts_element.lastElementChild);
    }
    else {
      const exist_post = document.getElementById(`post-${post['id']}`);
      if(exist_post) posts_element.removeChild(exist_post);
      posts_element.insertBefore(post_element, posts_element.firstElementChild);
      check_show_button(posts_element.firstElementChild);
    }
  }
}

async function load_posts(load_type) {
  loading = true;
  let url = `${api_url}/post/`;
  switch(load_type) {
    case 'user':
      url += `get_user.php?user_id=${user_id}&offset=${offset}&limit=${post_limit}`;
      break;
    case 'latest':
      url += `get_latest.php?timestamp=${latest_post_time}&limit=${post_limit}`;
      break;
    case 'all':
      url += `get.php?timestamp=${now}&offset=${offset}&limit=${post_limit}`;
      break;
  }
  const posts = (await get(url))['data'];
  switch(load_type) {
    case 'user':
    case 'all':
      if(posts.length == 0) stop_loading = true;
      offset += posts.length;
      insert_posts(posts, true);
      break;
    case 'latest':
      if(posts.length > 0) latest_post_time = posts[posts.length - 1]['modified_at'];
      insert_posts(posts, false);
      break;
  }
  loading = false;
}

function set_load_options(id, type) {
  user_id = id;
  load_type = type;
}

const api_url = 'http://i4010.isrcttu.net:9651/api';
const tzoffset = (new Date()).getTimezoneOffset();
const posts_element = document.getElementById('posts');
const post_template = document.getElementById('post');
const post_limit = 5;
const interval = 30000;
// const now = (new Date()).toISOString();

// db faster around 50s P.S. WTF
const date = new Date();
date.setSeconds(date.getSeconds() + 50);
const now = date.toISOString();

let user_id = null;
let load_type = null;
let offset = 0;
let loading = false;
let stop_loading = false;
let latest_post_time = now;

window.addEventListener('load', async () => {
  if(load_type == 'all') setInterval(() => load_posts('latest'), interval);
  await load_posts(load_type);
});

window.addEventListener('scroll', async () => {
  const scroll_to_bottom = window.scrollY + window.innerHeight >= document.body.scrollHeight;
  if(scroll_to_bottom && !loading && !stop_loading) await load_posts(load_type);
});