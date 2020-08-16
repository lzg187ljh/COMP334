<?php // sqltest.php
  session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  //$_SESSION['user_id'] = '1';
  $user_id=$_SESSION['user_id'];

//pay fine && user profile
//User can see the book he/she has borrowed

//Fine table
// pay fine
  if (isset($_POST['pay_fine']))
  {
    pay_fine($conn,$user_id);
  }
  
  $query  = "SELECT Ticket.book_id,Book.book_title,Book.book_author,Book.book_publisher,Book.book_category,Return_table.borrow_date1,Return_table.return_date,Ticket.fine FROM Return_table,Ticket,Book WHERE Return_table.book_id=Ticket.book_id and Return_table.user_id=Ticket.user_id and Return_table.return_date=Ticket.return_date and Book.book_id=Ticket.book_id and Ticket.user_id=$user_id";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  
//   $result->close();
//   $conn->close();
  
 function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
  
  function pay_fine($conn,$user_id){
        $sql = "update Ticket,User set fine=0,User.user_credit=1 WHERE User.user_id=Ticket.user_id and Ticket.user_id=$user_id";
        $result = $conn->query($sql);
  	            if (!$result) echo "reset fine failed: $query<br>" .
                    $conn->error . "<br><br>";
        $sql = "DELETE FROM Ticket WHERE 1";
        $result = $conn->query($sql);
  	            if (!$result) echo "delete Ticket failed: $query<br>" .
                    $conn->error . "<br><br>";
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pay Fine</title>

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
    <link href="../css/deck.css" rel="stylesheet">
    <link href="../css/index_new.css" rel="stylesheet">
    <link href="../css/sidebar.css" rel="stylesheet">
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
        <p class="navbar-brand py-2 d-md-inline-block">Pay Fine</p>
      </nav>

      <div class="container-fluid">
        <!-- return table -->
<div class="card card-cascade narrower">

<!--Form-->
  <div class="px-4">
    <div class="table-wrapper">
      <table class="table table-responsive table-hover mb-0">
        <!--Table head-->
        <thead>
          <tr>
            
            <th class="th-lg">
              <a>ISBN
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
            <th class="th-lg">
              <a href="">Title
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
            <th class="th-lg">
              <a href="">Author
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
            <th class="th-lg">
              <a href="">Publisher
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
            <th class="th-lg">
              <a href="">Category
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
            <th class="th-lg">
              <a href="">Borrow Date
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
            <th class="th-lg">
              <a href="">Return date
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
            <th class="th-lg">
              <a href="">Fine
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
          </tr>
        </thead>
        <!--Table head-->
        <!--Table body-->
        <tbody>
    <?php
        $sum = 0;
        for ($j = 0 ; $j < $rows ; ++$j)
          {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_NUM);
            
    echo  <<<_END
    <tr>
        <input type="hidden" name="return" value="yes">
_END;
            for ($k = 0 ; $k < 8 ; ++$k)
                echo "<td>$row[$k]</td>"; 
            $sum = $sum + $row[7];
            echo "</tr>"; 
          }
          echo  "<tr>Sum: $sum</tr>";
    ?>
        </tbody>
        <!--Table body-->
      </table>
    </div>
  </div>
<form action="pay_fine_new.php" method="post">
     <button class="btn btn-outline-info btn-sm py-2 px-3 d-md-inline-block" role="button" aria-pressed="true" type="submit" value="Pay fine" name="pay_fine">Pay fine</button>
</form>
<!--Form-->
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
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
// avoid reloading data    
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
</body>
</html>