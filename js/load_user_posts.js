async function get_posts(user_id, offset, limit) {
  const url = `${api_url}/post/get_user.php?user_id=${user_id}&offset=${offset}&limit=${limit}`;
  const response = await fetch(url);
  const data = await response.json();
  return data['data'];
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

var user_id = null;

window.addEventListener('load', async () => {
  if(user_id) await load_user_posts();
});
window.addEventListener('scroll', async () => {
  const scroll_to_bottom = window.scrollY + window.innerHeight >= document.body.scrollHeight;
  if(scroll_to_bottom && !loading && !stop_loading) {
    await load_user_posts();
  }
});