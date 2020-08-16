<?php // sqltest.php
  session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
 $user_type =$_SESSION['user_type'];
  //echo $user_type;
//sign in
  if (isset($_POST['user_id'])   &&
      isset($_POST['user_password']))
  {
     
    $user_id   = get_post($conn, 'user_id');
    $user_password     = get_post($conn, 'user_password');
    
    $sql = "SELECT * FROM User WHERE User.user_id=$user_id and User.user_password='$user_password' and User.user_type='$user_type'";
     $result   = $conn->query($sql);
    $row = $result->fetch_assoc();
        $uid = $row["user_id"];
        //echo $uid;
   	 if (!$uid) echo "Login failed";
      
     else{
         echo "Welcome! user";
         $_SESSION['user_id']=$uid;
         header("Location: index_new.php");
		    exit();
     }
         
    
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
    <title>Sign In</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../css/login_page_new.css" rel="stylesheet">
    <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
    </script>
  </head>
  
  <body class="text-center">
    <div class="container">
        <div class="panel">
            <form class="form-signin" action="login_page_new.php" method="post">
              <img class="mb-4" src="../img/login_logo.png" alt="" width="100" height="100">
              <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
              <label for="inputID" class="sr-only">User id</label>
              <input type="text" id="inputID" name="user_id" class="form-control" placeholder="User id" required autofocus>
              <label for="inputPassword" class="sr-only">Password</label>
              <input type="password" id="inputPassword" name="user_password" class="form-control" placeholder="Password" required>
              <button class="btn btn-outline-info btn-block" type="submit">Sign in</button>
              <div class="text-center">
                    <p>Not a member?
                        <a href="sign_in_new.php">Register</a>
                    </p>
             </div>
            </form>
    </div></div>
<?php
    //echo "close sql connection";
    $result->close();
   $conn->close();
?>
</body>
</html>