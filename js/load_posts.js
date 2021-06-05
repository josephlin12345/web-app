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

const post_elements = {};
let latest_post_time = (new Date()).toISOString();

setInterval(load_latest_posts, 60000);

window.addEventListener('load', load_posts);
window.addEventListener('scroll', async () => {
  const scroll_to_bottom = window.scrollY + window.innerHeight >= document.body.scrollHeight;
  if(scroll_to_bottom && !loading && !stop_loading) {
    await load_posts();
  }
});