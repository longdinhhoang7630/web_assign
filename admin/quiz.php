<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
             <tr>
                    <th>Exam ID</th>
                    <th>Teacher Name</th>
                    <th>Exam Name</th>
                    <th>Topic</th>
                    <th>Dificulty</th>
                    <th>Create Day</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require_once("../connection.php");
            $sql_select = "SELECT * FROM exam join account on (teacherID = accountID) order by accountID desc";
            $result = $conn->query($sql_select);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?= $row['examID'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['exName'] ?></td>
                        <td><?= $row['topic'] ?></td>
                        <td><?= $row['diff_level'] ?></td>
                        <td><?= $row['createDay'] ?></td>

                    </tr>
            <?php }
            } ?>
            </tbody>
        </table>
    </div>
</div>