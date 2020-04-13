<?php

namespace MyApp;

class DeletePost extends \MyApp\Model {
  public function deletePost() {
    if( !empty($_GET['message_id']) && empty($_POST['message_id'])) {
      $message_id = (int)h($_GET['message_id']);
    
      $sql = "SELECT * FROM post WHERE id = $message_id";
      $res = $this->db->query($sql);
      
      if( $res ) {
        $message_data = $res->fetch(\PDO::FETCH_ASSOC);
      } else {
        header("Location: " . HOME_DIR . "/admin.php?sort=" . $_SESSION['sort']);
      }
    } elseif(!empty($_POST['message_id'])) {
      $message_id = (int)h($_GET['message_id']);
      $sql = "DELETE FROM post WHERE id = $message_id";
      $res = $this->db->query($sql);
      $_SESSION['success'] = '投稿を削除しました';
      if( $res ) {
        header("Location: " . HOME_DIR . "/admin.php?sort=" . $_SESSION['sort']);
      }
    } else {
      $_SESSION['error'] = '投稿を削除できませんでした';
      header("Location: " . HOME_DIR . "/admin.php?sort=" . $_SESSION['sort']);
    }
    return $message_data;
  }
}