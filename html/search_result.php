<?php // sqltest.php
  session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  //$_SESSION['user_id'] = '1';
  $user_id=$_SESSION['user_id'];

// borrow book
  if (isset($_POST['borrow']) && isset($_POST['isbn']))
  {
        // foreach($_POST['isbn'] as $i) { 
        //     borrow($conn,$user_id,$i);
        // }
        borrow($conn,$user_id,$_POST['isbn']);
  }
  
// get search query from search.html
 
      $keyword = $_POST['search'];
      $query  = "SELECT * FROM Book WHERE CONCAT(book_title, '', book_author, '', book_category) LIKE '%$keyword%'";
    //   $query  = "SELECT * FROM Book";
      $result = $conn->query($query);
      if (!$result) die ("Database access failed: " . $conn->error);
    
      $rows = $result->num_rows;
 
  
//   $result->close();
//   $conn->close();
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
  function get_credit($conn,$user_id)
  {
        
        $sql = "SELECT user_credit from User WHERE User.user_id=$user_id";
        $credit = $conn->query($sql);
        $row = $credit->fetch_assoc();
        $user_credit = $row["user_credit"];
        return $user_credit;
  }
  
  function get_dep($conn,$user_id)
  {
        
        $sql = "SELECT user_dep from User WHERE User.user_id=$user_id";
        $dep = $conn->query($sql);
        $row = $dep->fetch_assoc();
        $user_dep = $row["user_dep"];
        return $user_dep;
  }
  
  function get_type($conn,$user_id)
  {
        
        $sql = "SELECT user_type from User WHERE User.user_id=$user_id";
        $type = $conn->query($sql);
        $row = $type->fetch_assoc();
        $user_type = $row["user_type"];
        return $user_type;
  }
 
  function get_book_num($conn,$book_id){
        $sql = "select book_num from Book WHERE book_id=$book_id";
        $credit = $conn->query($sql);
        $row = $credit->fetch_assoc();
        $book_num = $row["book_num"];
        return $book_num;
  }
  
  function get_book_info($conn,$book_id){
        $sql = "select book_title,book_author,book_publisher,book_category from Book WHERE book_id=$book_id";
        $credit = $conn->query($sql);
        $row = $credit->fetch_assoc();
        return $row;
  }

  
  function borrow($conn,$user_id,$book_id)
  {
      if(get_credit($conn,$user_id)>0 and get_book_num($conn,$book_id)>0){
          //$query = "INSERT INTO Borrow VALUES" . "('$user_id', '$book_id', now())";
          $query="INSERT INTO `Borrow` (`user_id`,`book_id`,`borrow_date`)values('$user_id', '$book_id', now())";
            $result = $conn->query($query);
  	            if (!$result) echo "You already borrowed this book";
            
          $book_title=get_book_info($conn,$book_id)["book_title"];
          $book_author=get_book_info($conn,$book_id)["book_author"];
          $book_publisher=get_book_info($conn,$book_id)["book_publisher"];
          $book_category=get_book_info($conn,$book_id)["book_category"];
          $user_dep=get_dep($conn,$user_id);
          $user_type=get_type($conn,$user_id);
          $query="INSERT INTO `Borrow_history` (`user_id`,`book_id`,`user_dep`,`user_type`,`book_title`,`book_author`,`book_publisher`,`book_category`,`borrow_date`)values('$user_id','$book_id','$user_dep','$user_type','$book_title', '$book_author','$book_publisher','$book_category',now())";
            $result = $conn->query($query);
  	            
          
      }elseif(get_book_num($conn,$book_id)<=0){
        
          echo "No this book in inventory";
      }else{
          echo "User lacks privileges!";
      }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Search Result</title>

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
    <link href="../css/album.css" rel="stylesheet">
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

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Category </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light" onclick="changeCat('Sci-fi')">Sci-Fi</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" onclick="changeCat('Math')">Math</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" onclick="changeCat('Computer')">Computer Science</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" onclick="changeCat('History')">History</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" onclick="changeCat('Philosophy')">Philosophy</a>
        <a href="#" class="list-group-item list-group-item-action bg-light" onclick="changeCat('Literature')">Literature</a>
      </div>
      <form action="search_result.php" method="post"><pre>
                <input type="hidden" name="search" id="search">
      </pre></form>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-outline-info" id="menu-toggle">Toggle Menu</button>
      </nav>

      <div class="container-fluid">
        <div class="deck_container" style="display:flex">
        <div class="row">
        <form action="index_new.php" method="post">
            <?php
                for ($j = 0 ; $j < $rows ; ++$j)
              {
                $result->data_seek($j);
                $row = $result->fetch_array(MYSQLI_NUM);
                echo  <<<_END
                <div class="col-md-4 col-sm-6">
                <div class="box">
                      <img src="../img/$row[7].jpg"/>
                      <div class="box-content">
						<h3 class="title">$row[1]</h3>
						<span class="post">Author: $row[2]</span>
						<ul class="icon">
							<li><button type="submit" name="isbn" value="$row[0]" class="btn btn-outline-info btn-sm">Borrow</button></li>
							<li><input type="hidden" name="borrow" value="yes"></li>
						</ul>
					  </div>
                </div>
                </div>
_END;
              }
            ?>
        </form>
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
    
    //   Category list
      function changeCat(Cat){
        document.getElementById('search').value = Cat;
        document.forms[0].submit();
      }
  </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
</body>
</html>