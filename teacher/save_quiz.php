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
   $testname = test_input($_POST['testname']);
   $topic = test_input($_POST['topic']);
   $diff = test_input($_POST['diff_level']);
   $sql = "SELECT exName FROM exam WHERE exName = '$testname'";
   $res = mysqli_query($conn, $sql);
   if (mysqli_num_rows($res) > 0) {
      $testnameErr = "Sorry the exam name already exists. Please try again";
      $_SESSION["error"] = $testnameErr;
      header("location: index.php?page=listQuiz");
      exit;
   }
   if(empty($testnameErr)){
      $sql = "INSERT INTO exam (teacherID,exName,topic,diff_level) VALUES ('$getID','$testname','$topic','$diff')";
      if (mysqli_query($conn, $sql)) {
         $_SESSION['testname'] = $testname;
         header("location: index.php?page=newQuiz");
      }else{
         echo "<script language='javascript'>
                  alert('Failed to add new quiz');
                  window.location='index.php?page=listQuiz';
               </script>";
         // $_SESSION["error"] = "Failed to add new quiz";
         // header("location: index.php?page=listQuiz");
         // exit;
      }
   }
}

?>