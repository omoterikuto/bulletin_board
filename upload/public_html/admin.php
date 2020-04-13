<?php

require_once( '../config/config.php');

$adminer = new \MyApp\GetPost();

$posts = $adminer->getPosts();

if( !empty($_GET['btn_logout']) ) {
  unset($_SESSION['admin_login']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if( !empty($_POST['btn_submit']) ) {
    if( !empty($_POST['admin_password']) && $_POST['admin_password'] === ADMIN_PASSWORD ) {
      $_SESSION['admin_login'] = true;
    } else {
      $_SESSION['error'] = 'パスワードが違います';
    }
  }
  
}

$downloader = new MyApp\Download();
if (isset($_GET['btn_download'])) {
  $downloader->downloadData();
}

if (isset($_SESSION['success'])) {
  $success = $_SESSION['success'];
  unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
  unset($_SESSION['error']);
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
      <div class="msg success"><?php echo h($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
      <div class="msg error"><?php echo h($error); ?></div>
    <?php endif; ?>
  </div>
  <div class="title">
    <h1>PicTolk</h1>
    <p>~管理ページ~</p>
  </div>
  <?php if( !empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true ): ?>
    <div class="admin-btn-wrapper">
      <form method="get" action="">
        <input class="logout-btn" type="submit" name="btn_logout" value="ログアウト">
      </form>
      <form method="get" action="">
        <select name="sort_download">
          <option value="asc">古い順</option>
          <option value="desc">新しい順</option>
          <option value="name_asc">なまえ順</option>
          <option value="name_desc">なまえ順逆</option>
        </select>
        <select name="limit">
          <option value="">全て</option>
          <option value="10">10件</option>
          <option value="30">30件</option>
        </select>
        <input class="download-btn" type="submit" name="btn_download" value="ダウンロード">
      </form>
    </div>
    <div class="admin-posts">
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
    <?php while($post = $posts->fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="post">
      <div class="image"><img src="../thumbs/<?= $post['imagefile'];?>" alt=""></div>
      <div class="user-text">
        <div class="user-meta">
          <div class="user-name"><?= $post['username'];?></div>
          <div class="post-date"><?= $post['postdate'];?></div>
        </div>
        <div class="user-comment"><?= $post['comment'];?></div>
        <div class="edit-btn"><a href="edit.php?message_id=<?= $post['id']; ?>">編集</a><a href="delete.php?message_id=<?= $post['id']; ?>">削除</a></div>
      </div>
    </div>
    <?php } ?>
  <?php else: ?>
    <div class="admin-login">
      <form method="post">
        <div>
          <label for="admin_password">パスワード</label>
          <input id="admin_password" type="password" name="admin_password" value="">
        </div>
        <input class="login-btn" type="submit" name="btn_submit" value="ログイン">
      </form>
    </div>
  <?php endif; ?>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="styles.js"></script>
</body>
</html>