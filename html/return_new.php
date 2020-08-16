<?php // sqltest.php
  session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  //$_SESSION['user_id'] = '1';
  $user_id=$_SESSION['user_id'];
//return book(with table)
if (isset($_POST['return']) && isset($_POST['isbn']))
  {
        foreach($_POST['isbn'] as $i) { 
            return_book($conn, $user_id,$i);
        }
  }
$query  = "SELECT Borrow.book_id,Book.book_title,Book.book_author,Book.book_publisher,Book.book_category,Borrow.borrow_date,adddate(Borrow.borrow_date,30) as expected_return_date FROM Borrow,Book WHERE Borrow.book_id = Book.book_id and Borrow.user_id=$user_id";
$result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  
//   $result->close();
//   $conn->close();
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
  function get_type($conn,$user_id)
  {
        
        $sql = "SELECT user_type from User WHERE User.user_id=$user_id";
        $type = $conn->query($sql);
        $row = $type->fetch_assoc();
        $user_type = $row["user_type"];
        return $user_type;
  }

  function get_borrow_date($conn,$user_id,$book_id){
        $sql = "select borrow_date from Borrow WHERE user_id=$user_id and book_id=$book_id";
        $borrow_date = $conn->query($sql);
        $row = $borrow_date->fetch_assoc();
        $borrowDate = $row["borrow_date"];
        return $borrowDate;
  }

  
  function return_book($conn,$user_id,$book_id){
        $borrow_date = get_borrow_date($conn,$user_id,$book_id);
        $query    = "INSERT INTO Return_table VALUES" .
          "('$user_id', '$book_id', '$borrow_date', now())";
        $result   = $conn->query($query);
    
      	if (!$result) echo "This book is not in your borrow list      : $query<br>" .
          $conn->error . "<br><br>";
          
        //trigger borrow
  	    $query="update Book set book_num = book_num + 1 WHERE book_id = '$book_id';";
          $result = $conn->query($query);
        $query= "DELETE FROM Borrow WHERE Borrow.book_id='$book_id' and Borrow.user_id='$user_id'";
          $result = $conn->query($query);
        // trigger_gen_ticket
        $user_type = get_type($conn,$user_id);
        if ($user_type == "student"){
            $query = "REPLACE INTO Ticket(user_id,book_id,return_date,overdue_date,fine) SELECT user_id,book_id,return_date,datediff(return_date,adddate(borrow_date1,30)),0.5*datediff(return_date,adddate(borrow_date1,30)) FROM Return_table WHERE return_date<adddate(borrow_date1,30) and Return_table.user_id='$user_id' and Return_table.borrow_date1='$borrow_date' and Return_table.book_id='$book_id'";
            $result   = $conn->query($query);
        }else{
            $query = "REPLACE INTO Ticket(user_id,book_id,return_date,overdue_date,fine) SELECT user_id,book_id,return_date,datediff(return_date,adddate(borrow_date1,120)),0.5*datediff(return_date,adddate(borrow_date1,120)) FROM Return_table WHERE return_date>adddate(borrow_date1,120) and Return_table.user_id='$user_id' and Return_table.borrow_date1='$borrow_date' and Return_table.book_id='$book_id'";
            $result   = $conn->query($query);
        }
        
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Book Return</title>

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
        <p class="navbar-brand py-2 d-md-inline-block">Book Return</p>
      </nav>

      <div class="container-fluid">
        <!-- return table -->
<div class="card card-cascade narrower">

<!--Form-->
<form action="return_new.php" method="post">
  <div class="px-4">
    <div class="table-wrapper">
      <table class="table table-responsive table-hover mb-0">
        <!--Table head-->
        <thead>
          <tr>
            <th>
              <input class="form-check-input" type="checkbox" id="checkbox" name="all" value="all" onclick="check_all()">
              <label class="form-check-label" for="checkbox" class="mr-2 label-table"></label>
            </th>
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
              <a href="">Expected Return Date
                <i class="fas fa-sort ml-1"></i>
              </a>
            </th>
          </tr>
        </thead>
        <!--Table head-->
        <!--Table body-->
        <tbody>
    <?php
        for ($j = 0 ; $j < $rows ; ++$j)
          {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_NUM);
            
    echo  <<<_END
    <tr>
        <input type="hidden" name="return" value="yes">
        <th scope="row">
          <input class="form-check-input" type="checkbox" id="checkbox1" name="isbn[]" value="$row[0]">
          <label class="form-check-label" for="checkbox1" class="label-table"></label>
        </th>
_END;
            for ($k = 0 ; $k < 7 ; ++$k)
                echo "<td>$row[$k]</td>";  
            echo "</tr>"; 
          }
    ?>
        </tbody>
        <!--Table body-->
      </table>
    </div>
  </div>
  <button class="btn btn-outline-info btn-sm py-2 px-3 d-md-inline-block" role="button" aria-pressed="true" type="submit" value="Return">Return</button>
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
    
    //check box select all
    function check_all(){
        var isbn = document.forms[0];
        var i;
        if (isbn[0].checked) 
        for (i = 0; i < isbn.length; i++) 
          isbn[i].checked=true;
        else
        for (i = 0; i < isbn.length; i++) 
          isbn[i].checked=false;
    }
// avoid reloading data    
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
</body>
</html>