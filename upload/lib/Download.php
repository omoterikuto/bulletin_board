<?php

namespace MyApp;

class Download extends \MyApp\Model {
  public function downloadData() {
    if(!empty($_GET['limit'])) {
      $limit = (int)$_GET['limit'];
      switch($_GET['sort_download']) {
        case 'desc':
          $sql = ("SELECT * FROM post ORDER BY postdate DESC LIMIT $limit");
        break;
        case 'asc':
          $sql = ("SELECT * FROM post ORDER BY postdate ASC LIMIT $limit");
        break;
        case 'name_desc':
          $sql = ("SELECT * FROM post ORDER BY username DESC LIMIT $limit");
        break;
        case 'name_asc':
          $sql = ("SELECT * FROM post ORDER BY username ASC LIMIT $limit");
        break;
      }
      $res = $this->db->query($sql);
    } else {
      switch($_GET['sort_download']) {
        case 'desc':
          $res = $this->db->query("SELECT * FROM post ORDER BY postdate DESC");
        break;
        case 'asc':
          $res = $this->db->query("SELECT * FROM post ORDER BY postdate ASC");
        break;
        case 'name_desc':
          $res = $this->db->query("SELECT * FROM post ORDER BY username DESC");
        break;
        case 'name_asc':
          $res = $this->db->query("SELECT * FROM post ORDER BY username ASC");
        break;
      }
    }
    if ($res === false) {
      echo 'データベースエラー';
    }
    $csv_data = null;
    if( !empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true ) {
      header("Content-Type: application/octet-stream");
      header("Content-Disposition: attachment; filename=メッセージデータ.csv");
      header("Content-Transfer-Encoding: binary");
      if( $res ) {
        $message_array = $res->fetchAll(\PDO::FETCH_ASSOC );
      }
      if(!empty($message_array) ) {
        $csv_data .= '"ID","なまえ","ひとことコメント","投稿日時","画像ファイル"'."\n";
        foreach( $message_array as $value ) {
          $csv_data .= '"' . $value['id'] . '","' . $value['username'] . '","' . $value['comment'] . '","' . $value['postdate'] . $value['imagefile'] . '","' . "\"\n";
        }
      }
      echo mb_convert_encoding($csv_data,"SJIS", "UTF-8");
    } else {
        header("Location: " . HOME_DIR . "/admin.php?sort=" . $_SESSION['sort']);
    }
    exit;

  }
}