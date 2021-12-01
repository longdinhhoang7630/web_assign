<?php
require_once '../connection.php';
$quizID = $_POST['id'];
$quiz = $conn->query("SELECT * FROM exam where examID =" . $quizID . " ")->fetch_array();
$duration = $quiz['duration'];
echo $duration;