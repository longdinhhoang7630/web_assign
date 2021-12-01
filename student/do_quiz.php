<?php
// session_start();
// include 'header.php';
require_once '../connection.php';
require_once './authen_student.php';
if (isset($_GET['id']) && isset($_SESSION['id'])) {
   $_SESSION['studExID'] = $quizID = $_GET['id'];
   $studID = $_SESSION['id'];
} else {
   echo "Not found";
   exit;
}
// Check if the user is logged in, otherwise redirect to login page
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role']!=='student') {
//    header("location: ../index.php");
//    exit;
// }
$sql = "INSERT INTO examination (studentID,testID,result) VALUES('$studID','$quizID',-1)";
$res = mysqli_query($conn, $sql);
if ($res) {
   $qry = "SELECT takeExID FROM examination WHERE studentID = '$studID' and testID='$quizID' and result=-1";
   $show = mysqli_query($conn, $qry);
   $data = mysqli_fetch_assoc($show);
   $_SESSION['takingExamID'] = $data["takeExID"];
   $takeExID = $data["takeExID"];
   if ($show) {
      $updateResult1 = "UPDATE examination SET result=0 WHERE takeExID='$takeExID'";
      mysqli_query($conn, $updateResult1);
   }
}
$quiz = $conn->query("SELECT * FROM exam where examID =" . $quizID . " ")->fetch_array();
$duration = $quiz['duration'];
// echo $duration;
?>

<head>
   <title><?php echo $quiz['exName'] ?> | Answer Sheet</title>
</head>

<style>
   li.answer {
      cursor: pointer;
   }

   li.answer:hover {
      background: #00c4ff3d;
   }

   li.answer input:checked {
      background: #00c4ff3d;
   }
</style>

<body onload="f2()">
   <form id="form1" runat="server">
      <div>
         <table width="100%" align="center">
            <tr>
               <td colspan="2">
               </td>
            </tr>
            <tr>
               <td>
                  <div id="showtime">hello</div>
               </td>
            </tr>
            <tr>
               <td>
                  <br>
               </td>
            </tr>
         </table>
         <br>
      </div>
   </form>
</body>
<div class="container-fluid admin">
   <div class="col-md-12 alert alert-primary"><?php echo $quiz['exName'] ?></div>
   <br>
   <div class="card">
      <div class="card-body">
         <form action="index.php?page=sub" id="answer-sheet" method="post">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>">
            <input type="hidden" name="quiz_id" value="<?php echo $quizID ?>">
            <?php
            $question = "SELECT * FROM question join exam_content on (questID = questionID) WHERE exID = $quizID";
            $records = mysqli_query($conn, $question);
            $i = 1;
            if (mysqli_num_rows($records) > 0) {
               while ($data = mysqli_fetch_assoc($records)) {
            ?>
                  <ul class="q-items list-group mt-4 mb-4">
                     <li class="q-field list-group-item">
                        <strong><?php echo ($i) . '. '; ?> <?php echo $data['question'] ?></strong>
                        <input type="hidden" name="question_id[<?php echo $data['questID'] ?>]" value="<?php echo $data['questID'] ?>">
                        <br>
                        <ul class='list-group mt-4 mb-4'>
                           <li class="answer list-group-item">
                              <label><input type="radio" name="answer[<?php echo $i; ?>]" value="<?php echo $data['answerA'] ?>" > <?php echo $data['answerA'] ?></label>
                           </li>
                           <li class="answer list-group-item">
                              <label><input type="radio" name="answer[<?php echo $i; ?>]" value="<?php echo $data['answerB'] ?>" > <?php echo $data['answerB'] ?></label>
                           </li>
                           <li class="answer list-group-item">
                              <label><input type="radio" name="answer[<?php echo $i; ?>]" value="<?php echo $data['answerC'] ?>" > <?php echo $data['answerC'] ?></label>
                           </li>
                           <li class="answer list-group-item">
                              <label><input type="radio" name="answer[<?php echo $i++; ?>]" value="<?php echo $data['answerD'] ?>" > <?php echo $data['answerD'] ?></label>
                           </li>
                        </ul>
                     </li>
                  </ul>
            <?php }
            } else {
               echo "No questions for this exam";
            } ?>
            <input type="submit" name="submitAns" class="btn btn-primary" value="Submit">
         </form>
      </div>
   </div>
</div>

<script>
   $(document).ready(function() {
      $('.answer').each(function() {
         $(this).click(function() {
            $(this).find('input[type="radio"]').prop('checked', true)
            $(this).css('background', '#00c4ff3d')
            $(this).siblings('li').css('background', 'white')
         })
      })
   })

   var min;
   $(document).on('click', '.startNow', function() {
      const urlString = window.location.search;
      const paramSearch = new URLSearchParams(urlString);
      const pid = paramSearch.get('id');
      console.log(id)
      $.ajax({
         url: "duration.php",
         method: "POST",
         data: {
            id: pid
         },
         success: function(res) {
            f2(res);
            var min = res;
            console.log(res)
         }
      });
   });

   var tim;
   var sec = 01;

   function f2(min) {
      if (parseInt(sec) > 0) {
         sec = parseInt(sec) - 1;
         document.getElementById("showtime").innerHTML = "Your Left Time  is :" + min + " Minutes :" + sec + " Seconds";
         tim = setTimeout("f2(min)", 1000);
      } else {
         if (parseInt(sec) == 0) {
            min = parseInt(min) - 1;
            if (parseInt(min) == 0) {
               clearTimeout(tim);
               location.href = "index.php";
            } else {
               sec = 59;
               document.getElementById("showtime").innerHTML = "Your Left Time  is :" + min + " Minutes ," + sec + " Seconds";
               tim = setTimeout("f2(min)", 1000);
            }
         }

      }
   }
</script>