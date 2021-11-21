<?php
require_once('../connection.php');
// require_once('./authen_teacher.php');
$questionid = $_GET['id'];
$sql = "SELECT * FROM question WHERE questID = '$questionid'";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);
echo json_encode($data);
?>