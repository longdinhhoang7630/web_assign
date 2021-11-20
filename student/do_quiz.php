<?php
session_start();
include 'header.php';
require_once '../connection.php';
$quizID = $_GET['id'];
// Check if the user is logged in, otherwise redirect to login page
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role']!=='student') {
//    header("location: ../index.php");
//    exit;
// }

$quiz = $conn->query("SELECT * FROM exam where examID =" . $quizID . " ")->fetch_array();
?>

<head>
   <title><?php echo $quiz['exName'] ?> | Answer Sheet</title>
</head>

<body>
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
   <div class="wrapper">
      <!-- Page Content  -->
      <div id="content">
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
               <?php
               if (isset($_SESSION['loggedin']) && $_SESSION["loggedin"] === true) { ?>
                  <div class="myDropdown w3-right">
                     <button class="dropbtn w3-bar-item w3-button">
                        Hi, <?php echo $_SESSION['role'] . ' ' . $_SESSION['username'] . ' ' ?>
                     </button>
                  </div>
               <?php } ?>
            </div>
         </nav>
      </div>
   </div>
   <div class="container-fluid admin">
      <div class="col-md-12 alert alert-primary"><?php echo $quiz['exName'] ?></div>
      <br>
      <div class="card">
         <div class="card-body">
            <form action="" id="answer-sheet">
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
                           <strong><?php echo ($i++) . '. '; ?> <?php echo $data['question'] ?></strong>
                           <input type="hidden" name="question_id[<?php echo $data['questID'] ?>]" value="<?php echo $data['questID'] ?>">
                           <br>
                           <ul class='list-group mt-4 mb-4'>
                              <li class="answer list-group-item">
                                 <label><input type="radio" name="<?php echo $data['questID'] ?>:answer" value="<?php echo $data['answerA'] ?>"> <?php echo $data['answerA'] ?></label>
                              </li>
                              <li class="answer list-group-item">
                                 <label><input type="radio" name="<?php echo $data['questID'] ?>:answer" value="<?php echo $data['answerB'] ?>"> <?php echo $data['answerB'] ?></label>
                              </li>
                              <li class="answer list-group-item">
                                 <label><input type="radio" name="<?php echo $data['questID'] ?>:answer" value="<?php echo $data['answerC'] ?>"> <?php echo $data['answerC'] ?></label>
                              </li>
                              <li class="answer list-group-item">
                                 <label><input type="radio" name="<?php echo $data['questID'] ?>:answer" value="<?php echo $data['answerD'] ?>"> <?php echo $data['answerD'] ?></label>
                              </li>
                           </ul>
                        </li>
                     </ul>
               <?php }
               } else {
                  echo "No questions for this exam";
               } ?>
               <button type="submit" class="btn btn-primary">Submit</button>
            </form>
         </div>
      </div>
   </div>
</body>
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
</script>