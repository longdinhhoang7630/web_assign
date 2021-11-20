<?php
session_start();
require_once('../connection.php');
$getID= $_SESSION['id'];
function test_input($data)
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
$testnameErr='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $textquestion = test_input($_POST['question']);
   $ansA = test_input($_POST['ansA']);
   $ansB = test_input($_POST['ansB']);
   $ansC = test_input($_POST['ansC']);
   $ansD = test_input($_POST['ansD']);
   $correctAns = $_POST['check'];
   if(!empty($textquestion) && !empty($ansA) 
   && !empty($ansB) && !empty($ansC)
   && !empty($ansD)&& !empty($correctAns)){
      $sql = "INSERT INTO question (question,answerA,answerB,answerC,answerD,correctAns) 
      VALUES ('$testquestion','$ansA','$ansB','$ansC','$ansD','$correctAns')";
      if (mysqli_query($conn, $sql)) {
         $query= "SELECT * FROM question WHERE question = '.$testquestion.'";
         $res = mysqli_query($conn, $query);
         $data = mysqli_fetch_assoc($res);
         $exid = $_SESSION['exid'];
         $questid = $data['questID'];
         $sql2 = "INSERT INTO exam_content(exID,questionID) VALUES ('$exid','$questid')";
         if(mysqli_query($conn, $sql2)){
            echo "<script language='javascript'>
                  alert('Add new question successfully');
                  window.location='index.php?page=newQuiz';
               </script>";
         } else {
            echo "<script language='javascript'>
                  alert('Failed to add new question');
                  window.location='index.php?page=newQuiz';
               </script>";
         }
      } else {
         echo "<script language='javascript'>
                  alert('Failed to add new question');
                  window.location='index.php?page=newQuiz';
               </script>";
      }
   }
}
