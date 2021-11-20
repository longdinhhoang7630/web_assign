<?php
// session_start();
require_once('../connection.php');
$quizname = $_SESSION['testname'];
?>

<head>
   <title>New Quiz</title>
</head>

<body>

   <div class="container-fluid admin">
      <a data-toggle="modal" data-target="#manage_question" class="btn btn-primary bt-sm" id="new_question">
         <i class="fa fa-plus"></i> Add Question
      </a>
      <br>
      <br>
      <div class="card col-md-12 mr-4">
         <div class="card-header">
            Questions
         </div>
         <div class="card-body">
            <ul class="list-group">
               <?php
               $sql= "SELECT examID FROM exam WHERE exName= '.$quizname.'";
               $query = "SELECT * FROM (question join exam_content on (questID = questionID)) 
               join exam on (examID = exID) WHERE exName= '.$quizname.' order by questID asc ";
               $records = mysqli_query($conn, $query);
               if (mysqli_num_rows($records) > 0) {
                  $data1 = mysqli_fetch_assoc($records);
                  $_SESSION['exid'] = $data1['exID'];
                  while ($data = mysqli_fetch_assoc($records)) { ?>
                     <li class="list-group-item"><?php echo $data['question'] ?><br>
                        <center>
                           <button class="btn btn-sm btn-outline-primary edit_question" data-id="<?php echo $data['questID'] ?>" type="button"><i class="fa fa-edit"></i></button>
                           <button class="btn btn-sm btn-outline-danger remove_question" data-id="<?php echo $data['questID'] ?>" type="button"><i class="fa fa-trash"></i></button>
                        </center>
                     </li>
               <?php  }
               } ?>
            </ul>
         </div>
      </div>

      <div class="modal fade" id="manage_question" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">

                  <h4 class="modal-title" id="myModallabel">Add New Question</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id='question-frm' method="post" action="./save_question.php">
                  <div class="modal-body">
                     <div id="msg"></div>
                     <div class="form-group">
                        <label>Question</label>
                        <textarea rows='3' name="question" required class="form-control"></textarea>
                     </div>
                     <label>Options:</label>
                     <div class="form-group">
                        <textarea rows="2" name="ansA" required class="form-control"></textarea>
                        <span>
                           <label><input type="radio" name="check" class="is_right" value="A"> <small>Question Answer</small></label>
                        </span>
                        <br>
                        <textarea rows="2" name="ansB" required class="form-control"></textarea>
                        <label><input type="radio" name="check" class="is_right" value="B"> <small>Question Answer</small></label>
                        <br>
                        <textarea rows="2" name="ansC" required class="form-control"></textarea>
                        <label><input type="radio" name="check" class="is_right" value="C"> <small>Question Answer</small></label>
                        <br>
                        <textarea rows="2" name="ansD" required class="form-control"></textarea>
                        <label><input type="radio" name="check" class="is_right" value="D"> <small>Question Answer</small></label>
                     </div>

                  </div>
                  <div class="modal-footer">
                     <input type="submit" class="btn btn-primary" name="save" value="Save">
                  </div>
               </form>
            </div>
         </div>
      </div>
</body>
<script>
   $(document).ready(function() {
      $(".select2").select2({
         placeholder: "Select here",
         width: 'resolve'
      });
      $('#table').DataTable();
      $('#new_question').click(function() {
         $('#msg').html('')
         $('#manage_question .modal-title').html('Add New Question')
         $('#manage_question #question-frm').get(0).reset()
         $('#manage_question').modal('show')
      })
      $('.edit_question').click(function() {
         var id = $(this).attr('data-id')
         $.ajax({
            url: './get_question.php?id=' + id,
            error: err => console.log(err),
            success: function(resp) {
               if (typeof resp != undefined) {
                  resp = JSON.parse(resp)
                  $('[name="id"]').val(resp.qdata.id)
                  $('[name="question"]').val(resp.qdata.question)
                  Object.keys(resp.odata).map(k => {
                     var data = resp.odata[k]
                     $('[name="question_opt[' + k + ']"]').val(data.option_txt);
                     if (data.is_right == 1)
                        $('[name="is_right[' + k + ']"]').prop('checked', true);
                  })
                  $('#manage_question .modal-title').html('Edit Question')
                  $('#manage_question').modal('show')

               }
            }
         })

      })
      $('.is_right').each(function() {
         $(this).click(function() {
            $('.is_right').prop('checked', false);
            $(this).prop('checked', true);
         })
      })
      $('.remove_question').click(function() {
         var id = $(this).attr('data-id')
         var conf = confirm('Are you sure to delete this data.');
         if (conf == true) {
            $.ajax({
               url: './delete_question.php?id=' + id,
               error: err => console.log(err),
               success: function(resp) {
                  if (resp == true)
                     location.reload()
               }
            })
         }
      })
      $('#question-frm').submit(function(e) {
         e.preventDefault();
         $.ajax({
            url: './save_question.php',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
               console.log(err)
               alert('An error occured')
               $('#quiz-frm [name="submit"]').removeAttr('disabled')
               $('#quiz-frm [name="submit"]').html('Save')
            },
            success: function(resp) {
               if (resp == 1) {
                  alert('Data successfully saved');
                  location.reload()
               }
            }
         })
      })
   })
</script>