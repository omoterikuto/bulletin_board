<?php
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function getResults() {
  $success = null;
  $error = null;
  if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
  }
  if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
  }
  return [$success, $error];
}

function validateToken() {
  if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
    throw new \Exception('不正なアクセスです');
  }
}