<?php
require_once('../connection.php');
require_once('./authen_teacher.php');
$exid = $_SESSION['examID'];
$questionid = $_GET['id'];
$sql = "SELECT * FROM (question join exam_content on (questID = questionID)) 
WHERE questID = '$questionid' and exID = '$exid'";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);
echo json_encode($data);
