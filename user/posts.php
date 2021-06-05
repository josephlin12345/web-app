<?php
  $title = 'Posts';
  $path = '../';
  require $path . 'templates/header.php';
?>

<script src="<?php echo $path; ?>js/posts.js" defer></script>
<script src="<?php echo $path; ?>js/load_user_posts.js" defer></script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    set_user_id(<?php if($_GET['id']) echo $_GET['id']; else echo $user['id']; ?>);
  });
</script>

<div id="posts">
  <?php require $path . 'templates/form/post.php'; ?>
</div>

<?php require $path . 'templates/footer.php'; ?>