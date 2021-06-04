<?php
  $title = 'Posts';
  $path = '../';
  require $path . 'templates/header.php';
?>

<script src="<?php echo $path; ?>js/show_more.js" defer></script>

<div id="posts">
  <?php require $path . 'templates/form/post.php'; ?>
  <script src="<?php echo $path; ?>js/load_user_posts.js"></script>
  <script>set_user_id(<?php if(isset($_GET['id'])) echo $_GET['id']; else echo $user['id']; ?>);</script>
</div>

<?php require $path . 'templates/footer.php'; ?>