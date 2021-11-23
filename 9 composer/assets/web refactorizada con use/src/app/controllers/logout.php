<?php
  session_unset();
  session_destroy();
  if (isset($_GET['returnToUrl'])) {
    header('location: ' . $_GET['returnToUrl']);
  } else {
    header('location: /');
  }