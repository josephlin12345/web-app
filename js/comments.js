function create_comment(post_id) {
  const content = document.getElementById(`textarea-${post_id}`).value;
  if(content.length) {
    const postdata = {
      creator_id: user_id,
      post_id: post_id,
      content: content,
      recaptcha_response: document.getElementById('recaptcha_response').value,
    };
    fetch(`${api_url}/comment/create.php`, {
      method: 'POST',
      body: JSON.stringify(postdata)
    })
    .then(response => response.json())
    .then(data => {
      if(data['error']) alert(data['error']['recaptcha_err']);
      else {
        document.getElementById(`textarea-${post_id}`).value = '';
        generate_token();
        load_comments(post_id, true);
      }
    });
  }
}

function make_comment_element(comment) {
  const clone = comment_template.content.cloneNode(true);
  clone.querySelector('.comment').id = `comment-${comment['id']}`;
  clone.querySelector('img').src = `${api_url}/user/get_avatar.php?id=${comment['creator_id']}`;
  // remove /app
  clone.querySelector('a').href = `${window.location.origin}/app/user/posts.php?id=${comment['creator_id']}`;
  clone.querySelector('.creator-name').innerText = comment['creator_name'];
  const modified_at = new Date(comment['modified_at']);
  modified_at.setMinutes(modified_at.getMinutes() - tzoffset);
  clone.querySelector('.modified-at').innerText = modified_at.toLocaleString();
  clone.querySelector('.content').innerText = decodeHTML(comment['content']);
  return clone;
}

function show_comments(post_id) {
  const post = document.getElementById(`post-${post_id}`);
  const comments = document.getElementById(`comments-${post_id}`);
  const button = post.querySelector('[name="comments"]');
  const hidden = comments.classList.toggle('hidden');
  if(!hidden) {
    button.innerText = 'Close Comments';
    const textarea = document.getElementById(`textarea-${post_id}`);
    if(textarea) textarea.focus();

    const post_ids = Object.keys(loaded_comments);
    if(!post_ids.includes(post_id.toString())) {
      loaded_comments[post_id] = {};

      // loaded_comments[post_id]['now'] = (new Date()).toISOString();
      // db faster around 50s P.S. WTF
      const date = new Date();
      date.setSeconds(date.getSeconds() + 50);
      loaded_comments[post_id]['now'] = date.toISOString();

      loaded_comments[post_id]['latest_comment_time'] = loaded_comments[post_id]['now'];
      loaded_comments[post_id]['offset'] = 0;
      load_comments(post_id, false);
    }
    loaded_comments[post_id]['interval'] = setInterval(() => load_comments(post_id, true), interval);
  }
  else {
    clearInterval(loaded_comments[post_id]['interval']);
    button.innerText = 'Show Comments';
  }
}

function insert_comments(comments, post_id, append) {
  const comments_element = document.getElementById(`comments-${post_id}`);
  for(comment of comments) {
    const comment_element = make_comment_element(comment);
    if(append) comments_element.insertBefore(comment_element, comments_element.lastElementChild);
    else {
      const exist_comment = document.getElementById(`comment-${comment['id']}`);
      if(exist_comment) comments_element.removeChild(exist_comment);
      const first_comment = comments_element.querySelector('.comment');
      if(first_comment) comments_element.insertBefore(comment_element, first_comment);
      else comments_element.insertBefore(comment_element, comments_element.lastElementChild);
    }
  }
}

async function load_comments(post_id, latest) {
  let url = `${api_url}/comment/`;
  if(latest) url += `get_latest.php?post_id=${post_id}&timestamp=${loaded_comments[post_id]['latest_comment_time']}&limit=${comment_limit}`;
  else url += `get.php?post_id=${post_id}&timestamp=${loaded_comments[post_id]['now']}&offset=${loaded_comments[post_id]['offset']}&limit=${comment_limit}`;
  const comments = await get(url);
  if(latest) {
    if(comments.length > 0) loaded_comments[post_id]['latest_comment_time'] = comments[comments.length - 1]['modified_at'];
    insert_comments(comments, post_id, false);
  }
  else {
    const comments_element = document.getElementById(`comments-${post_id}`);
    const load_more = comments_element.querySelector('[name="load_more_comments"]');
    if(comments.length == 0 || comments.length < comment_limit) load_more.classList.add('hidden');
    else load_more.classList.remove('hidden');
    loaded_comments[post_id]['offset'] += comments.length;
    insert_comments(comments, post_id, true);
  }
}

const comment_limit = 5;
const loaded_comments = {};
const comment_template = document.getElementById('comment');