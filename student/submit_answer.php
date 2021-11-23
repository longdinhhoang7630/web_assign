<?php
session_start();
require_once '../connection.php';
// require_once './authen_student.php';
$stID = $_SESSION['id'];
$takeExID = $_SESSION['takingExamID'];
$array = array();
$arrayQuestions=array();
$arrayCorrectAns = array();
$arrayStudentAns = array();
$score = 0;
$i = 0;
if (isset($_SESSION['studExID']) && isset($_SESSION['id'])) {
   $studExID = $_SESSION['studExID'];
} else {
   exit;
}

// $qry = "SELECT takeExID FROM examination WHERE studentID = '$stID' and testID='$studExID' and result=-1";
// $show = mysqli_query($conn, $qry);
// $data = mysqli_fetch_assoc($show);

if (isset($_POST['submitAns'])) { 
   $query = "SELECT * FROM exam_content WHERE exID='$studExID' ";
   $res = mysqli_query($conn, $query);
   if (mysqli_num_rows($res) > 0) {
      while ($fetch_data = mysqli_fetch_assoc($res)) {
         $quesID = $fetch_data["questionID"];
         array_push($array, $quesID);
      }
      foreach ($_POST['answer'] as $option_num => $option_val) {
         $sql = "INSERT INTO exhistory (takenExID,testExamID,testQuestID,studentAns) VALUES ('$takeExID','$studExID','$array[$i]','$option_val')";
         $i++;
         mysqli_query($conn, $sql);
      }

      $question = "SELECT * FROM question join exam_content on (questID = questionID) WHERE exID = $studExID";
      $records = mysqli_query($conn, $question);
      if (mysqli_num_rows($records) > 0) {
         while ($data = mysqli_fetch_assoc($records)) {
            $correctAns = $data['correctAns'];
            $questions = $data['question'];
            array_push($arrayQuestions,$questions);
            array_push($arrayCorrectAns, $correctAns);
         }
         $totalQuestion = count($arrayCorrectAns);
      }

      $queryAns = "SELECT * FROM exhistory WHERE testExamID=$studExID ";
      $result = mysqli_query($conn, $queryAns);
      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            $studentAns = $row['studentAns'];
            array_push($arrayStudentAns, $studentAns);
         }
         $totalAnswer=count($arrayStudentAns);
      }

      $queryName = "SELECT exName FROM exam WHERE examID=$studExID";
      $show = mysqli_query($conn, $queryName);
      $getName = mysqli_fetch_assoc($show);
      $examName = $getName['exName'];
   }?>
   <div class="col-md-12 alert alert-primary"><?php echo $examName ?></div>
  <?php for ($x = 0; $x < $totalQuestion; $x++) { ?>
      <div class="container-fluid admin">
         <br>
         <div class="card">
            <div class="card-body">
               <form id="answer-sheet">
                  <ul class="q-items list-group mt-4 mb-4">
                     <li class="q-field list-group-item">
                        <?php echo ($x + 1) . ' ' .$arrayQuestions[$x] ?></strong>
                        <?php if ($arrayStudentAns[$x]!=$arrayCorrectAns[$x]) { ?>
                           <p><span style="background-color: #FF9C9E"><?=$arrayStudentAns[$x]?></span></p>
                           <p><span style="background-color: #ADFFB4"><?=$arrayCorrectAns[$x]?></span></p>
                        <?php } else { ?>
                           <p><span style="background-color: #ADFFB4"><?=$arrayStudentAns[$x]?></span></p>
                           <?php $score = $score + 1; ?>
                        <?php  } ?>
               </form>
            </div>
         </div>
      </div>
   <?php  } 
}
mysqli_close($conn);
?>