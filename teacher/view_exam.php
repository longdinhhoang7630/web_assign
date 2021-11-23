<?php
require_once('../connection.php');
require_once('./authen_teacher.php');
if (isset($_GET['examid']) && isset($_SESSION['id'])) {
    $exid = $_GET['examid'];
    $userid = $_SESSION['id'];
} else {
    echo "Not found";
    exit;
}
$exam = $conn->query("SELECT * FROM exam WHERE examID = '$exid' AND teacherID ='$userid' ")->fetch_assoc();
if (!empty($exam)) {
?>

    <head>
        <title><?php echo $exam['exName'] ?> | Exam review</title>
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
        <div class="container-fluid admin">
            <div class="col-md-12 alert alert-primary"><?php echo $exam['exName'] ?></div>
            <br>
            <div class="card">
                <div class="card-body">
                    <form action="" id="answer-sheet">
                        <input type="hidden" name="user_id" value="<?php echo $userid ?>">
                        <input type="hidden" name="quiz_id" value="<?php echo $exid ?>">
                        <?php
                        $listQuestion = $conn->query("SELECT * FROM question join exam_content on (questID = questionID) WHERE exID = $exid");
                        $i = 1;
                        if (mysqli_num_rows($listQuestion) > 0) {
                            while ($data = mysqli_fetch_assoc($listQuestion)) {
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
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </form>
                </div>
            </div>
        </div>
    </body>
<?php

}
?>