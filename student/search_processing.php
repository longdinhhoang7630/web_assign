<?php
require_once '../connection.php';
require_once './authen_student.php';
$valueToSearch = $_POST['product'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($valueToSearch)) {
        //Binary CONCAT(UCASE(LEFT(product_name,1)),SUBSTRING(product_name,2)) 
        $query = "SELECT * FROM products WHERE LOWER(product_name) LIKE '%" . $valueToSearch . "%'";
        $records = mysqli_query($conn, $query); // fetch data from database
        if (mysqli_num_rows($records) > 0) { ?>
            <h3 id="showPro">Your result for "<?php echo $valueToSearch; ?>"</h3>
            <table class="w3-table-all w3-hoverable">
                <thead>
                    <tr class="w3-green">
                        <th>ProductID</th>
                        <th>Product_Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_assoc($records)) {
                    ?>
                        <tr>
                            <td><?= $data['productID'] ?></td>
                            <td><?= $data['product_name'] ?></td>
                            <td><?= $data['price'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
<?php } else {
            $err = "No result found for:" . ' "' . $valueToSearch . '"';
            $_SESSION["error"] = $err;
            header("location: index.php?page=search");
            exit;
        }
    } else {
        $_SESSION["error"] = "You need to enter this field";
        header("location: index.php?page=search");
        exit;
    }
} ?>
<?php mysqli_close($conn); ?>