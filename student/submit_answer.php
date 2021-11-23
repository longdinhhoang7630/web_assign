<?php
session_start();
require_once '../connection.php';
// require_once './authen_student.php';
$stID=$_SESSION['id'];
if (isset($_SESSION['studExID']) && isset($_SESSION['id'])) {
   $studExID = $_SESSION['studExID'];
} else {
   exit;
}
$array = array(); 
$i=0;
$qry = "SELECT takeExID FROM examination WHERE studentID = '$stID' and testID='$studExID' and result=-1";
$show = mysqli_query($conn, $qry);
$data = mysqli_fetch_assoc($show);
$takeExID= $data["takeExID"];
if (isset($_POST['submitAns'])) {
   echo "dsad";
   $query = "SELECT * FROM exam_content WHERE exID='$studExID' ";
   $res = mysqli_query($conn, $query);
   if (mysqli_num_rows($res) > 0) {
      echo "hhh";
      while ($fetch_data = mysqli_fetch_assoc($res)) {
         $quesID = $fetch_data["questionID"];
         array_push($array, $quesID);
      }
      foreach ($_POST['answer'] as $option_num => $option_val) {
         $sql = "INSERT INTO exhistory (takenExID,testExamID,testQuestID,studentAns) VALUES ('$takeExID','$studExID','$array[$i]','$option_val')";
         $i++;
         if (mysqli_query($conn, $sql)) {
            echo "Success";
            echo '<br>';
         } else {
            echo "fail";
            echo '<br>';
         }
      }
   }
}
mysqli_close($conn);
?>