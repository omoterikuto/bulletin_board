<?php
namespace MyApp;

class Token {
  static public function create() {
    if (!isset($_SESSION['tokens'])) {
      $_SESSION['tokens'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }

  static public function validate($tokenKey) {
    if (
      !isset($_SESSION['tokens']) ||
      !isset($_POST[$tokenKey]) ||
      $_SESSION['tokens'] !== $_POST[$tokenKey]
    ) {
      throw new \Exception('invalid token!');
    }
  }
}
