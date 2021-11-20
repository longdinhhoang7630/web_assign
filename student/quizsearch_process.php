<?php
require_once '../connection.php';
require_once './authen_student.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (!empty($valueToSearch)) {
      $query = "SELECT examID,exName,username,topic,diff_level,exam.createDay FROM exam join account on (accountID = teacherID) WHERE LOWER(exName) LIKE '%" . $valueToSearch . "%' or LOWER(username) LIKE '%" . $valueToSearch . "%' 
               or LOWER(topic) LIKE '%" . $valueToSearch . "%' 
               or LOWER(diff_level) LIKE '%" . $valueToSearch . "%' ";
      $records = mysqli_query($conn, $query); // fetch data from database
      if (mysqli_num_rows($records) > 0) { ?>
         <!-- DataTales Example -->
         <h1 class="h3 mb-2 text-gray-800">Tables</h1>
         <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>
         <div class="card shadow mb-4">
            <div class="card-header py-3">
               <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                        <tr>
                           <th>Exam</th>
                           <th>Teacher</th>
                           <th>Topic</th>
                           <th>Difficulty</th>
                           <th>Create day</th>
                           <th>Do the exam</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        while ($data = mysqli_fetch_assoc($records)) {
                        ?>
                           <tr>
                              <td><?= $data['exName'] ?></td>
                              <td><?= $data['username'] ?></td>
                              <td><?= $data['topic'] ?></td>
                              <td><?= $data['diff_level'] ?></td>
                              <td><?= $data['createDay'] ?></td>
                              <td><a href="index.php?page=do_quiz&id=<?php echo $data['examID'] ?>" class="btn btn-primary">Start now</a></td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
<?php } else {
         echo "<br>";
         $_SESSION["error"] = "No result found for:" . ' "' . $valueToSearch . '"';
         echo '<p class="mb-4">' . $_SESSION["error"] . '</p>';
      }
   }
}
?>