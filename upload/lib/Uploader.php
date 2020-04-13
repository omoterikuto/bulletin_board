<?php

namespace MyApp;

class Uploader extends \MyApp\Model {

  private $_imageFileName;
  private $_imageType;

  public function upload() {
      try {

        $this->_validateUpload();

        $ext = $this->_validateImageType();

        $savePath = $this->_save($ext);

        $this->_createThumbnail($savePath);

        $this->_saveDatebase();

        $_SESSION['success'] = 'アップロードしました！';
      } catch (\Exception $e) {
        $_SESSION['error'] = $e->getMessage();
      }
    // redirect
    header("Location: ?sort=" . $_SESSION['sort']);    
    exit;
  }

  private function _validateUpload() {
    validateToken();
    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('アップロードエラー');
    }
    if (empty($_POST['username'])) {
      throw new \Exception('名前を入力してください！');
    }
    switch($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception('画像サイズが大きすぎます！');
      case UPLOAD_ERR_NO_FILE:
        throw new \Exception('画像を選択してください！');
      default:
        throw new \Exception('Err: ' . $_FILES['image']['error']);
    }
  }

  public function _saveDatebase() {
    $stmt = $this->db->prepare("insert into post (username, comment, imagefile, postdate) values (:username, :comment, :imagefile, now())");
    $res = $stmt->execute([
      ':comment' => $_POST['comment'],
      ':username' => $_POST['username'],
      ':imagefile' => $this->_imageFileName
    ]);
    if ($res === false) {
      echo 'database err';
    }
  }

  
  private function _validateImageType() {
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        return 'gif';
      case IMAGETYPE_JPEG:
        return 'jpg';
      case IMAGETYPE_PNG:
        return 'png';
      default:
        throw new \Exception('PNG/JPEG/GIF のみです');
    }
  }
  private function _save($ext) {
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if ($res === false) {
      throw new \Exception('アップロードできませんでした！');
    }
    return $savePath;
  }

  private function _createThumbnail($savePath) {
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];
    $height = $imageSize[1];
    if ($width > THUMBNAIL_WIDTH) {
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

  private function _createThumbnailMain($savePath, $width, $height) {
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath);
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath);
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath);
        break;
    }
    $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
    $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);

    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
    }

  }

}