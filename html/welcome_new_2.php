<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php // sqltest.php
  session_start();
 //$_SESSION['user_type']="None"

  
  if (isset($_POST['type']))
  {
    $_SESSION['user_type'] = $_POST['type'];
    
    header("Location: login_page_new.php");
		    exit();
  }

function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="../css/welcome.css">
    
    <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
    
    function submitOnClick(formName){
        document.forms[formName].submit();
    }
    </script>
</head>
<body>
    <!-- partial:index.partial.html -->
    <form id="student" action="welcome_new_2.php" method="post"><pre>
        <div onclick="submitOnClick('student')" class="btn style-1">
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <input type="hidden" name="type" value="student">
            <span>Student</span>
        </div>
    </pre></form>    
    <form id="teacher" action="welcome_new_2.php" method="post"><pre>
        <div onclick="submitOnClick('teacher')" class="btn style-1">
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <i></i>
            <input type="hidden" name="type" value="teacher">
            <span>Teacher</span>
        </div>
    </pre></form>
    <!-- partial -->

</body>
</html>