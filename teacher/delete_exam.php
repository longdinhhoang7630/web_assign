<?php
require_once('../connection.php');
require_once('./authen_teacher.php');
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$exid = $_SESSION['examID'];
$userid = $_SESSION["id"];
//check if delete quiz is valid
$sql = "SELECT * FROM exam WHERE examID='$exid' AND teacherID ='$userid' ";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);
if (!empty($data)) {
    $query1 = "SELECT questionID FROM exam_content WHERE exID='$exid' "; // select all question of an exam
    $query2 = "DELETE FROM exam_content WHERE exID='$exid' ";
    $query4 = "DELETE FROM exam WHERE examID='$exid' ";
    $listQuestion = mysqli_query($conn, $query1);
    $result1 = mysqli_query($conn, $query2);
    if (mysqli_num_rows($listQuestion) > 0) {
        while ($fetch_data = mysqli_fetch_assoc($listQuestion)) {
            $quesID = $fetch_data["questionID"];
            $query3 = "DELETE FROM question WHERE questID='$quesID' ";
            $result2 = mysqli_query($conn, $query3);
        }
    }
    $result3 = mysqli_query($conn, $query4);
    if ($result1 && $result2 && $result3) {
        // unset($_SESSION['examID']);
        // unset($_SESSION['testname']);
        echo 1;
    } else {
        echo 0;
    }
}
