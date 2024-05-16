
<!DOCTYPE html>
<html lang="en">

<head>
 <!-- Required meta tags -->
 <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>CvSU ONLINE CANVASSING</title>
  <link rel="icon" href="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" type="image/gif" sizes="18x16">

  <!-- Bootstrap CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />

  <link rel="stylesheet" type="text/css" href="CSS\sidebar.css">

  <!-- CSS -->
  <style>



</style>
</head>

<body>
<?php

?>  

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../static/images/expenseic.png" sizes="16x16" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="../static/css/skeleton.css">
    <link rel="stylesheet" href="../static/css/11-changepass.css">
    <link rel="stylesheet" href="../static/css/7-Datewise.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../static/css/yearpicker.css">
    <link rel="stylesheet" href="../static/css/6-Manage-Expenses.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/yearpicker.js" async></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script async src="myScript.js"></script>
    <title>Expense Management</title>
    
</head>

<body class="overlay-scrollbar sidebar-expand">
    <!-- sidebar -->
    <div class="side-container">
        <div class="container">
    <div class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="cart.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span>
                        Dashboard
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="checkout.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-coins"></i>
                    </div>
                    <span>
                        Set Budget 
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item" id="Expense" onclick="open1()">
                <a href="#" class="sidebar-nav-link">
                    <div>
                        <i class="fa fa-plus-circle"></i>
                    </div>
                    <span>
                        Expenses
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item" style="display: none;">
                <a href="product.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <span>
                        Add Expenses
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item" style="display: none">
                <a href="6-Manage-Expense.php" class="sidebar-nav-link" style="display: none">
                    <div>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <span>
                        Manage Expenses
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item" id="ER" onclick="open2()">
                <a href="#" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <span>
                        Expense Report
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item" style="display:none;">
                <a href="7-Datewise.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <span>
                        Datewise Report
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item" style="display: none;">
                <a href="8-Monthly.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <span>
                        Monthly Report
                    </span>
                </a>
            </li>
            <li class="sidebar-nav-item" style="display:none;">
                <a href="9-Yearly.php" class="sidebar-nav-link">
                    <div>
                        <i class="fas fa-calendar"></i>
                    </div>
                    <span>
                        Yearly Report
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
</div>
    <!-- end sidebar-->
    <!-- Main Content -->
    <!-- end main content -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="../static/js/skeleton.js"></script>
</body>

</html>