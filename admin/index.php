<?php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <title>My first website</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
   <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
   <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
   <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
   <link href="sidebar.css" rel="stylesheet" type="text/css" media="all">
   <link href="myStyle.css" rel="stylesheet" type="text/css" media="all">
   <link href="profile.css" rel="stylesheet" type="text/css" media="all">
   <link rel="icon" href="../image/logo.svg" sizes="96x96" />
</head>

<body>
   <?php
   if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role'] !== 'admin') {
      header("location: ../index.php");
      exit;
   }
   ?>
   <div class="wrapper">
      <!-- Sidebar  -->
      <nav id="sidebar">
         <div class="sidebar-header">
            <h3>Menu</h3>
         </div>
         <ul class="list-unstyled components">
            <li>
               <a href="index.php?page=teacher">Teacher</a>
            </li>

            <li>
               <a href="index.php?page=student">Student</a>
            </li>
            <li>
               <a href="index.php?page=quiz">Quiz</a>
            </li>
         </ul>
      </nav>
      <!-- Page Content  -->
      <div id="content">

         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

               <button type="button" id="sidebarCollapse" class="btn btn-primary">
                  <i class="fas fa-align-left"></i>
               </button>

               <?php
               if (isset($_SESSION['loggedin']) && $_SESSION["loggedin"] === true) { ?>
                  <div class="myDropdown w3-right">
                     <button class="w3-bar-item w3-button">
                        Hi, <?php echo $_SESSION['username'] ?>
                        <i class="fa fa-chevron-down"></i>
                     </button>
                     <div class="myDropdown-content">
                        <a href="index.php?page=myProfile">
                           <i class="fa fa-user"></i> My profile
                        </a>
                        <a style="width:auto;" href="index.php?page=reset#id05" onclick="document.getElementById('id05').style.display='block'">
                           <i class="fa fa-key"></i> Reset password
                        </a>
                        <a href="#" data-toggle="modal" data-target="#logoutModal">
                           <i class="fa fa-power-off"></i> Logout
                        </a>
                     </div>
                  </div>
               <?php } ?>
            </div>
         </nav>
         <?php
         if (array_key_exists('page', $_GET)) {
            switch ($_GET['page']) {
               case 'myProfile':
                  include 'profile.php';
                  break;
               case 'teacher':
                  include 'teacher.php';
                  break;
               case 'student':
                  include 'student.php';
                  break;
               case 'quiz':
                  include 'quiz.php';
                  break;
               case 'reset':
                  include 'reset-password.php';
                  break;
            }
         } else {
            include 'profile.php';
         }

         ?>
      </div>
   </div>

   <!-- Logout Modal-->
   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-zoom" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
               <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
               <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
         </div>
      </div>
   </div>

   <a id="backtotop" onclick="topFunction()" title="Go to top"><i class="fa fa-fw fa-chevron-up"></i></a>
   <script src="myScript.js"></script>
</body>

</html>