<?php
namespace MyApp;

class EditPost extends \MyApp\Model {

  public function editPost() {
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
      try {
        validateToken();
        $message_id = (int)h($_POST['message_id']);
        $message_data['comment'] = h($_POST['comment']);
        $message_data['username'] = h($_POST['username']);
    
        if(empty($_POST['username'])) {
          $_SESSION['error'] = '名前を入力して下さい！';
          header("Location: " . HOME_DIR . "/edit.php?message_id=" . $_GET['message_id']);
        } else {
          $sql = "UPDATE post set username = '$message_data[username]', comment = '$message_data[comment]' WHERE id =  $message_id";
          $res = $this->db->query($sql);
          if($res) {
            $_SESSION['success'] = '投稿を編集しました';
            header("Location: " . HOME_DIR . "/admin.php?sort=" . $_SESSION['sort']);
            unset($_SESSION['error']);
          }
        }

      }catch( \Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        $message_data = null;
      }
    }
    return $message_data;  
  }
}
