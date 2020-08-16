<?php // sqltest.php
  session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
 $user_type =$_SESSION['user_type'];
//sign in
  if (
      isset($_POST['user_id'])   &&
      isset($_POST['user_name'])    &&
    //   isset($_POST['user_type']) &&
      isset($_POST['user_age'])     &&
      isset($_POST['user_dep'])  &&
      isset($_POST['user_password']))
  {
      
    $user_id   = get_post($conn, 'user_id');
    $user_name    = get_post($conn, 'user_name');
    // $user_type = get_post($conn, 'user_type');        # the usertype is still a string
    $user_age     = get_post($conn, 'user_age');
    $user_dep     = get_post($conn, 'user_dep');
    $user_password     = get_post($conn, 'user_password');

    $query2    = "INSERT INTO User VALUES" .
       "('$user_id', '$user_name', '$user_password','$user_age', '$user_type', '$user_dep',1)";
    $result   = $conn->query($query2);

   	if (!$result) echo "INSERT failed: $query<br>" .
      $conn->error . "<br><br>";
    else
        echo "account created successfully";
    
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
    <title>Sign up</title>

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
            <form class="form-signin" action="sign_in_new.php" method="post">
              <img class="mb-4" src="../img/login_logo.png" alt="" width="100" height="100">
              <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
              <label for="inputID" class="sr-only">User id</label>
              <input type="text" id="inputID" name="user_id" class="form-control" placeholder="User id" required autofocus>
              <label for="inputName" class="sr-only">User name</label>
              <input type="text" id="inputName" name="user_name" class="form-control" placeholder="User name" required autofocus>
              <label for="inputType" class="sr-only">User type</label>
              <!--<input type="text" id="inputType" name="user_type" class="form-control" placeholder="User type" required autofocus>-->
              <!--<label for="inputAge" class="sr-only">User age</label>-->
              <input type="text" id="inputAge" name="user_age" class="form-control" placeholder="User age" required autofocus>
              <label for="inputDep" class="sr-only">User department</label>
              <input type="text" id="inputDep" name="user_dep" class="form-control" placeholder="User dep" required autofocus>
              <label for="inputPassword" class="sr-only">Password</label>
              <input type="password" id="inputPassword" name="user_password" class="form-control" placeholder="Password" required>
              <button class="btn btn-outline-info btn-block" type="submit">Sign up</button>
            </form>
            <div class="text-center">
                    <p>Already have account ?
                        <a href="login_page_new.php">Sign in</a>
                    </p>
             </div>
    </div></div>
<?php
   //$usercode->close();
  $result->close();
  $conn->close();
?>
</body>
</html>