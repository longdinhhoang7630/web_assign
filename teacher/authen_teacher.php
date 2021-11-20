<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role'] !== 'teacher') {
  header("location: ../index.php");
  exit;
}
