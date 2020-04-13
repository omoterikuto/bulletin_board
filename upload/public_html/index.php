<?php

require_once( '../config/config.php');


if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

$uploader = new \MyApp\Uploader();
$poster = new \MyApp\GetPost();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uploader->upload();
}

list($success, $error) = getResults();

$posts = $poster->getPosts();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Uploader</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="message-bar">
    <?php if (isset($success)) : ?>
      <div class="msg success"><?php echo h($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
      <div class="msg error"><?php echo h($error); ?></div>
    <?php endif; ?>
  </div>
  <div class="title">
    <h1>PicTolk</h1>
    <p>~写真でおしゃべり！~</p>
  </div>
  <form action="" method="post" enctype="multipart/form-data" class="input-form">
    <div class="contents-wrapper">
      <div class="username">
        <label for="username">なまえ<span class="required">※必須</span></label>
        <input id="username" type="text" name="username" value="" maxlength='20'>
      </div>
      <div>
        <label for="my_file">
          画像を選択してください<span class="required">※必須</span>
        </label>
        <input type="file" name="image" id="my_file">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
      </div>
    </div>
      <div class="comment">
        <label for="comment">ひと言コメント</label>
        <textarea id="comment" name="comment" maxlength='100'></textarea>
      </div>
      <div class="btn-wrapper">
        <input type="hidden" id="token" name="token" value="<?= h($_SESSION['token']);  ?>">
        <input type="submit" class="submit-btn" value="投稿" name="submit">
      </div>
  </form>
  <div class="posts">
    <div class="sort">
      <form id="sort_desc" action="" method="get"><input name="sort" type="hidden" value="desc"></form>
      <form id="sort_asc" action="" method="get"><input name="sort" type="hidden" value="asc"></form>
      <form id="sort_name-desc" action="" method="get"><input name="sort" type="hidden" value="name_desc"></form>
      <form id="sort_name-asc" action="" method="get"><input name="sort" type="hidden" value="name_asc"></form>
      <div class="sort-btn"> 
        <div id="desc" href="">新しい順</div>
        <div id="asc" href="">古い順</div>
        <div id="name-asc" href="">A - Z</div>
        <div id="name-desc" href="">Z - A</div>
      </div>
    </div>
    <?php while($post = $posts->fetch( PDO::FETCH_ASSOC ) ) { ?>
    <div class="post">
      <div class="image"><img src="../thumbs/<?= $post['imagefile'];?>" alt=""></div>
      <div class="user-text">
        <div class="user-meta">
          <div class="user-name"><?= $post['username'];?></div>
          <div class="post-date"><?= $post['postdate'];?></div>
        </div>
        <div class="user-comment"><?= $post['comment'];?></div>
      </div>
    </div>
    <?php } ?>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="styles.js"></script>
</body>
</html>