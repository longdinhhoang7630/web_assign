<?php
session_start();
require_once('../connection.php');
require_once('./authen_teacher.php');
function test_input($data)
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
$testnameErr = '';
$testquestion = $ansA = $ansB = $ansC = $ansD = $correctAns = $examID = '';
$examName =  $_SESSION['testname'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $testquestion = test_input($_POST['questionContent']);

   $ansA = test_input($_POST['ansA']);
   $ansB = test_input($_POST['ansB']);
   $ansC = test_input($_POST['ansC']);
   $ansD = test_input($_POST['ansD']);
   $correctAns = test_input($_POST['check']);
   if (
      !empty($testquestion) && !empty($ansA)
      && !empty($ansB) && !empty($ansC)
      && !empty($ansD) && !empty($correctAns)
   ) {
      $sql = "INSERT INTO question (question,answerA,answerB,answerC,answerD,correctAns) 
      VALUES ('$testquestion','$ansA','$ansB','$ansC','$ansD','$correctAns')";
      if (mysqli_query($conn, $sql)) {
         // take questionID
         $query = "SELECT * FROM question WHERE question = '$testquestion'";
         $res = mysqli_query($conn, $query);
         $data = mysqli_fetch_assoc($res);
         $questid = $data['questID'];
         // take exam
         $query = "SELECT * FROM exam WHERE exName = '$examName'";
         $res = mysqli_query($conn, $query);
         $data = mysqli_fetch_assoc($res);
         $exid = $data['examID'];
         if (!empty($questid) && !empty($exid)) {
            $sql2 = "INSERT INTO exam_content(exID,questionID) VALUES ('$exid','$questid')";
            if (mysqli_query($conn, $sql2)) {
               echo "<script language='javascript'>
                  alert('Add new question successfully');
                  window.location='index.php?page=new_question';
               </script>";
            } else {
               echo "<script language='javascript'>
                  alert('Failed to add new question');
                  window.location='index.php?page=new_question';
               </script>";
            }
         }
      } else {
         echo "<script language='javascript'>
                  alert('Failed to add new question');
                  window.location='index.php?page=new_question';
               </script>";
      }
   }
}
