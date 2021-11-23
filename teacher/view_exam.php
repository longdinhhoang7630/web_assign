<?php
require_once('../connection.php');
require_once('./authen_teacher.php');
if (isset($_GET['examid']) && isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $exid = $_GET['examid'];
    $userid = $_SESSION['id'];
    $username = $_SESSION["username"];
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
            /* li.answer {
                cursor: pointer;
            }

            li.answer:hover {
                background: rgb(86 255 16 / 55%);
            }

            li.answer input:checked {
                background: #28a745;
            } */

            .true_ans {
                background: rgb(86 255 16 / 55%);
            }
        </style>

        <div class="container-fluid admin">
            <div class="col-md-12 alert alert-primary">
                <?php
                echo "Teacher: " . strtoupper($username) . " Exam: " . $exam['exName'] . " Topic: " . $exam['topic'] . " Difficulty: " . $exam['diff_level']
                ?>
            </div>
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
                                            <li class="answer list-group-item <?php echo ($data['correctAns'] == 'A' ? 'true_ans' : ''); ?>">
                                                <label>
                                                   A. <?php echo $data['answerA'] ?>
                                                </label>
                                            </li>
                                            <li class="answer list-group-item <?php echo ($data['correctAns'] == 'B' ? 'true_ans' : ''); ?> ">
                                                <label>
                                                   B. <?php echo $data['answerB'] ?>
                                                </label>
                                            </li>
                                            <li class="answer list-group-item <?php echo ($data['correctAns'] == 'C' ? 'true_ans' : ''); ?>">
                                                <label>
                                                   C. <?php echo $data['answerC'] ?>
                                                </label>
                                            </li>
                                            <li class="answer list-group-item <?php echo ($data['correctAns'] == 'D' ? 'true_ans' : ''); ?>">
                                                <label>
                                                   D. <?php echo $data['answerD'] ?>

                                                </label>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                        <?php

                            }
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
<script>
    // $(document).ready(function() {
    //     $('.answer').each(function() {
    //         $(this).click(function() {
    //             $(this).find('input[type="radio"]').prop('checked', true)
    //             $(this).css('background', '#28a745')
    //             $(this).siblings('li').css('background', 'white')
    //         })
    //     })
    // })
</script>