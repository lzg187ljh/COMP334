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
        foreach($_POST['isbn'] as $i) { 
            borrow($conn,$user_id,$i);
        }
  }
  
  $query  = "SELECT * FROM Book";
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
  	            if (!$result) echo "borrow failed0: $query<br>" .
                    $conn->error . "<br><br>";
            
          $book_title=get_book_info($conn,$book_id)["book_title"];
          $book_author=get_book_info($conn,$book_id)["book_author"];
          $book_publisher=get_book_info($conn,$book_id)["book_publisher"];
          $book_category=get_book_info($conn,$book_id)["book_category"];
          $user_dep=get_dep($conn,$user_id);
          $user_type=get_type($conn,$user_id);
          $query="INSERT INTO `Borrow_history` (`user_id`,`book_id`,`user_dep`,`user_type`,`book_title`,`book_author`,`book_publisher`,`book_category`,`borrow_date`)values('$user_id','$book_id','$user_dep','$user_type','$book_title', '$book_author','$book_publisher','$book_category',now())";
            $result = $conn->query($query);
  	            if (!$result) echo "insert borrow history failed: $query<br>" .
                    $conn->error . "<br><br>";        
          
      }elseif(get_book_num($conn,$book_id)<=0){
        
          echo "No this book in inventory: $query<br>" .
                    $conn->error . "<br><br>";
      }else{
          echo "User lacks privileges!";
      }
  }
?>
<html>
<head>
<link rel="stylesheet" href="../css/table.css">
<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<body>
<form action="borrow_new.php" method="post">
  <table>
  <thead>
    <tr>   
      <th>ISBN</th>   
      <th>Title</th>     
      <th>Author</th>   
      <th>Publisher</th>  
      <th>Category</th> 
      <th>Num</th>  
      <th>Record</th> 
    </tr>
  </thead>

<?php
    for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    
    echo "<tr>";
    for ($k = 0 ; $k < 7 ; ++$k)
        echo "<td>$row[$k]</td>";
    echo  <<<_END
    <input type="hidden" name="borrow" value="yes">
    <td><input type="checkbox" name="isbn[]" value="$row[0]"></td>
_END;
    echo "</tr>"; 
  }
?>
</table>
<input type="submit" value="Borrow">
</form>
</body>
</html>