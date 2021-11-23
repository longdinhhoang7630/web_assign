<?php
require_once('../connection.php');
require_once('./authen_teacher.php');
?>

<head>
   <title>Quiz List</title>
</head>

<body>
   <div class="container-fluid admin">
      <div class="col-md-12 alert alert-primary">Quiz List</div>
      <a data-toggle="modal" data-target="#manage_quiz" class="btn btn-primary bt-sm" id="new_quiz">
         <i class="fa fa-plus"></i> Add New
      </a>
      <br>
      <br>
      <div class="card">
         <div class="card-body shadow p-3 mb-5">
            <h3 style="margin-bottom:10px" class="card-header bg-primary text-light rounded-top">Quiz list</h3>
            <div class="table-responsive">
               <table class="table table-bordered table-striped" id='table' width="100%" cellspacing="0">
                  <thead class="text-dark bg-light">
                     <tr>
                        <th class="th-sm">ExamID</th>
                        <th class="th-sm">Exam</th>
                        <th class="th-sm">Topic</th>
                        <th class="th-sm">Difficulty</th>
                        <th class="th-sm">Create day</th>
                        <th class="th-sm">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $i = 1;
                     $query = "SELECT * FROM exam WHERE teacherID = " . $_SESSION['id'] . " order by examID desc";
                     $records = mysqli_query($conn, $query);
                     if (mysqli_num_rows($records) > 0) {
                        while ($data = mysqli_fetch_assoc($records)) { ?>
                           <tr>
                              <td><?= $data['examID'] ?></td>
                              <td><?= $data['exName'] ?></td>
                              <td><?= $data['topic'] ?></td>
                              <td><?= $data['diff_level'] ?></td>
                              <td><?= $data['createDay'] ?></td>
                              <td>
                                 <a href="index.php?page=view_quiz&examid=<?php echo $data['examID'] ?>" class="btn btn-primary view_exam" type="button">
                                    Review &nbsp; <i class="fa fa-file-alt"></i>
                                 </a>
                              </td>
                           </tr>
                     <?php }
                     }
                     ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="manage_quiz" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">

               <h4 class="modal-title" id="myModallabel">Add New quiz</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method='post' id='quiz-frm' action='./save_quiz.php'>
               <div class="modal-body">
                  <div id="msg"></div>
                  <div class="form-group">
                     <label>Test name</label>
                     <!-- <input type="hidden" name="id" /> -->
                     <input type="text" name="testname" required class="form-control" />
                  </div>
                  <div class="form-group">
                     <label>Topic</label>
                     <input type="text" name="topic" required class="form-control" />
                  </div>
                  <div class="form-group">
                     <label>Difficulty</label>
                     <input type="text" name="diff_level" required class="form-control" />
                  </div>
               </div>
               <div class="modal-footer">
                  <input class="btn btn-primary" name="save" type="submit" value="Save">
               </div>
            </form>
         </div>
      </div>
   </div>
</body>
<script>
   $(document).ready(function() {
      // $('#table').DataTable();
      $('#new_quiz').click(function() {
         $('#msg').html('')
         $('#manage_quiz .modal-title').html('Add New quiz')
         $('#manage_quiz #quiz-frm').get(0).reset()
         $('#manage_quiz').modal('show')
      })
      // $('.view_exam').click(function() {
      //    var id = $(this).attr('data-id')
      //    console.log(id)
      //    $.ajax({
      //       url: './view_exam.php?examid=' + id,
      //       error: err => console.log(err),
      //       success: function(resp) {
      //          console.log(resp)
      //          window.location.assign("view_exam.php?examid=" + id);
      //       }
      //    })

      // })
      $('#table').dataTable({
         "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
         ],
         "aaSorting": [],
         columnDefs: [{
            orderable: false,
            targets: 5
         }]
      })
   })
</script>