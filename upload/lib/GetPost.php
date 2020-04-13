<?php

namespace MyApp;

class GetPost extends \MyApp\Model {
  public function getPosts() {
    if (!isset($_GET['sort'])) {
      $_GET['sort'] = 'desc';
    }
  
    switch($_GET['sort']) {
      case 'desc':
        $_SESSION['sort'] = 'desc';
        break;
      case 'asc':
        $_SESSION['sort'] = 'asc';
        break;
      case 'name_desc':
        $_SESSION['sort'] = 'name_desc';
        break;
      case 'name_asc':
        $_SESSION['sort'] = 'name_asc';
        break;
    }
  
    if (!isset($_SESSION['sort'])) {
      $_SESSION['sort'] = 'desc';
    }
    switch($_SESSION['sort']) {
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
  
    return $res;
  }
}
