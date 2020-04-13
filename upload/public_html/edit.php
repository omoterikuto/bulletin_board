<?php

require_once( '../config/config.php');

$editter = new \MyApp\EditPost();

if( empty($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true ) {
  header("Location: ./admin.php?sort=" . $_SESSION['sort']);
}
if(!empty($_POST['message_id'])) {
  $editter->editPost();
}

$message_data = $editter->editPost();

if (isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
}

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
      <div class="msg success"><?= h($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
      <div class="msg error"><?= h($error); ?></div>
    <?php endif; ?>
  </div>
  <div class="title">
    <h1>PicTolk</h1>
    <p>~編集ページ~</p>
  </div>
  <form action="" method="post" enctype="multipart/form-data" class="input-form">
    <div class="contents-wrapper">
      <div class="username">
        <label for="username">なまえ<span class="required">※必須</span></label>
        <input id="username" type="text" name="username" value="<?php if( !empty($message_data['username']) ){ echo $message_data['username']; } ?>" maxlength='20'>
      </div>
    </div>
      <div class="comment">
        <label for="comment">ひと言コメント</label>
        <textarea id="comment" name="comment" maxlength="120"><?php if( !empty($message_data['comment']) ){ echo $message_data['comment']; } ?></textarea>
      </div>
      <div class="btn-wrapper">
        <a class="cancel-btn" href="admin.php">キャンセル</a>
        <input type="submit" class="submit-btn" value="変更する" name="submit">
        <input type="hidden" name="message_id" value="<?= $message_data['id']; ?>">
        <input type="hidden" id="token" name="token" value="<?= h($_SESSION['token']);  ?>">
      </div>
  </form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="styles.js"></script>
</body>
</html>