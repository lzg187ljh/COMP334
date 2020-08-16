<?php 
    session_start();
    $user_id=$_SESSION['user_id'];
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
     
     // Query: which category of book is the most popular category for students
    $query    = "SELECT book_category,count(*) as cnt FROM Borrow_history group by book_category";
    $result  = $conn->query($query);
    
    // Query: which type of users borrow books more 
    $query2    = "SELECT user_type,count(*) as cnt FROM Borrow_history group by user_type";
    $result2  = $conn->query($query2);
    
    // Query: which book is borrowed most 
    $query3    = "SELECT book_title,COUNT(*) as cnt FROM Borrow_history GROUP BY book_title ORDER BY 2 DESC LIMIT 1;";
    $result3  = $conn->query($query3);
    
    $query4    = "SELECT book_category,COUNT(*) as cnt FROM Borrow_history where user_id='$user_id' GROUP BY book_category ORDER BY 2 DESC LIMIT 1;";
    $result4  = $conn->query($query4);
    
    if (isset($_POST['user_type']))
      {
        $user_type = get_post($conn, 'user_type');        # the usertype is still a string
        $query    = "SELECT book_category,count(*) as cnt FROM Borrow_history WHERE user_type='$user_type' group by book_category";
        $result  = $conn->query($query);
        
      }
   function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Report Page</title>

    <link rel="canonical" href="long12.myweb.cs.uwindsor.ca/60334/projects/html/index_new_t.php">

    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">




    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      
      .navbar.navbar-1 .navbar-toggler-icon {
        background-image: url('https://mdbootstrap.com/img/svg/hamburger6.svg?color=000');
        }

        /*return_new*/
      .container-fluid {
        margin-top: 20px;
      }
      form {
        display: contents;
      }
      
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../css/index_new.css" rel="stylesheet">
    <link href="../css/sidebar.css" rel="stylesheet">
    <link href="../css/report.css" rel="stylesheet">
    <link href="../css/demo.css" rel="stylesheet">
    
  </head>
  <body>
    <nav class="navbar navbar-1 site-header sticky-top py-1">
  <div class="py-2 container d-flex flex-column flex-md-row justify-content-between">
      <a class="navbar-brand py-2 d-md-inline-block" href="index_new.php"><img class="mb-4" src="../img/login_logo.png" alt="" width="65" height="65"></a>
    <button class="navbar-toggler d-lg-none d-md-none" type="button" data-toggle="collapse" data-target="#ham"
    aria-controls="ham" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <a class="py-2 d-none d-md-inline-block" href="index_new.php">Home</a>
    <a class="py-2 d-none d-md-inline-block" href="return_new.php">Return Book</a>
    <a class="py-2 d-none d-md-inline-block" href="pay_fine_new.php">Pay Fine</a>
    <a class="py-2 d-none d-md-inline-block" href="report_new.php">Report</a>
    <div class="justify-content-right">
    <a href="search.html" class="btn btn-outline-info btn-sm py-2 px-3 d-none d-md-inline-block" role="button" aria-pressed="true">Search</a>
    <button class="navbar-toggler d-none d-md-inline-block" type="button" data-toggle="collapse" data-target="#ham2"
    aria-controls="ham" aria-expanded="false" aria-label="Toggle navigation" style="margin-left:2rem;"><img src="https://img.icons8.com/ultraviolet/48/000000/gender-neutral-user.png"/></button>
    </div>
          <!-- Collapsible content -->
          
          <div style="text-align:center;" class="collapse navbar-collapse" id="ham2">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="user_profile_new.php">Profile <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="welcome_new_2.php">Logout</a>
              </li>
            </ul>
          </div>
          
  <!--</div>-->
  <!--  <a href="user_profile_new.php" class="py-2 px-3 ml-3 d-none d-md-inline-block"><img src="https://img.icons8.com/ultraviolet/48/000000/gender-neutral-user.png"/></a>-->
  <!--  </div>-->
          <!-- Collapsible content -->
          
          <div style="text-align:center;" class="collapse navbar-collapse" id="ham">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index_new.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="return_new.php">Return Book</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pay_fine_new.php">Pay Fine</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="report_new.php">Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user_profile_new.php">Profile</a>
              </li>
              <li class="nav-item">
                <a href="search.html" class="nav-link btn btn-outline-info btn-sm py-2 d-md-inline-block" role="button" aria-pressed="true">Search</a>
              </li>
            </ul>
          </div>
          
  </div>
</nav>

<div class="d-flex" id="wrapper">
    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <p class="navbar-brand py-2 d-md-inline-block">Report</p>
      </nav>

      <div class="container-fluid">
        <!-- return table -->
        <div class="card alert nestable-cart single-card">
                                <div class="card-header">
                                    <h4>The most popular book</h4> 
                                </div>
                                <div class="sparkline-box">
                                    <span id="sparklinedash"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></span>
                                </div>
                                <div class="visit-count">
                                    <?php
                                    while($row = $result3->fetch_assoc()){
                                      echo "[".$row['book_title']."]:".$row['cnt']."";
                                      echo " times";
                                    }
                                    ?>
                                </div>
                            </div>
                            
        <div class="card alert nestable-cart single-card">
                                <div class="card-header">
                                    <h4>The Category you may interested in </h4> 
                                </div>
                                <div class="sparkline-box">
                                    <span id="sparklinedash"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></span>
                                </div>
                                <div class="visit-count">
                                    <?php
                                    while($row = $result4->fetch_assoc()){
                                      echo "[".$row['book_category']."]: You have borrowed books in this category ".$row['cnt']."";
                                      echo " times";
                                    }
                                    ?>
                                </div>
                            </div>
        
        <div class="card">
            <div class="card-header">
                <h4>Popularity of book categories</h4>
            </div>
            <div class="sales-chart">
                <div id="piechart" style="width: 900px; height: 500px;"></div>
                <div class="dmenu">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Choose the type of User
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" onclick="changeType('student')">Student</a>
                    <a class="dropdown-item" onclick="changeType('teacher')">Teacher</a>
                  </div>
                </div>
            <form action="report_new.php" method="post"><pre>
                <input type="hidden" name="user_type" id="type">
            </pre></form>
            </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h4>which group of users borrow books more</h4>
            </div>
            <div class="sales-chart">
                <div id="barchart" style="width: 900px; height: 500px;"></div>
            </div>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>


<footer class="container py-5">
  <div class="row">
    <div class="col-12 col-md">
      <img class="mb-4" src="../img/login_logo.png" alt="" width="30" height="30">
    </div>
    <div class="col-6 col-md">
      <h5><a href="index_new.php">Home</a></h5>
    </div>
    <div class="col-6 col-md">
      <h5><a href="pay_fine_new.php">Pay Fine</a></h5>
    </div>
    <div class="col-6 col-md">
      <h5><a href="report_new.php">Report</a></h5>
    </div>
    <div class="col-6 col-md">
      <h5><a href="user_profile_new.php">Profile</a></h5>
    </div>
  </div>
</footer>
<!-- Bootstrap core JavaScript -->
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
<!--<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>-->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/bootstrap.bundle.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        // Pie  chart
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawBasic);
      function drawBasic() {
        var data = google.visualization.arrayToDataTable([
          ['category', 'count'],
          <?php
          while($row = $result->fetch_assoc()){
            echo "['".$row['book_category']."', ".$row['cnt']."],";
          }
          ?>
        ]);
        var options = {
                  title: 'Borrow History',
                  width: '50%',
                  height: '600px'
                };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
        
        //Bar chart
      google.charts.load("current", {packages: ["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['User type', 'count'],
            <?php
            while($row = $result2->fetch_assoc()){
              echo "['".$row['user_type']."', ".$row['cnt']."],";
            }
            ?>
          ]);
          var options = {
                  title: 'Num of books',
                  width: '50%',
                  height: '600px'
                };
          var chart = new google.visualization.BarChart(document.getElementById('barchart'));
            chart.draw(data, options);
      }
    //   change value in dropdown list
      function changeType(type){
        document.getElementById('type').value = type;
        document.forms[0].submit();
      }
         
// avoid reloading data  

    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
    </script>
    





</body>
</html>