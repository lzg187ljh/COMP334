<?php // sqltest.php
  session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  //$_SESSION['user_id'] = '1';
  $user_id=$_SESSION['user_id'];
  
  $query  = "SELECT User.user_id,User.user_name,User.user_type,User.user_dep,User.user_age,User.user_credit FROM User WHERE User.user_id=$user_id";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  
//   *************
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
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User profile </title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
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

      .container-fluid {
        margin-top: 20px;
      }
      
       @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    /*user profile */
        #wrapper {
            background-image: linear-gradient(15deg, #13547a 0%, #80d0c7 100%);
            overflow-x: hidden;
        }
        html, body {
            /*background: #FCEEB5;*/
            font-family: Abel, Arial, Verdana, sans-serif;
        }

      

        .card {
            margin-bottom: 1.5rem;
            left: 50%;
            width: 500px;
            margin-left: -250px;
            height: 250px;
            background-color: #fff;
            background: linear-gradient(#f8f8f8, #fff);
            box-shadow: 0 8px 16px -8px rgba(0,0,0,0.4);
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }

            .card h1 {
                text-align: center;
            }

            .card .additional {
                position: absolute;
                width: 150px;
                height: 100%;
                background: linear-gradient(#dE685E, #EE786E);
                transition: width 0.4s;
                overflow: hidden;
                z-index: 2;
            }

            .card.green .additional {
                background: linear-gradient(#92bCa6, #A2CCB6);
            }


            .card:hover .additional {
                width: 100%;
                border-radius: 0 5px 5px 0;
            }

            .card .additional .user-card {
                width: 150px;
                height: 100%;
                position: relative;
                float: left;
            }

                .card .additional .user-card::after {
                    content: "";
                    display: block;
                    position: absolute;
                    top: 10%;
                    right: -2px;
                    height: 80%;
                    border-left: 2px solid rgba(0,0,0,0.025);
                    */;
                }

                .card .additional .user-card .level,
                .card .additional .user-card .points {
                    top: 15%;
                    color: #fff;
                    text-transform: uppercase;
                    font-size: 0.75em;
                    font-weight: bold;
                    background: rgba(0,0,0,0.15);
                    padding: 0.125rem 0.75rem;
                    border-radius: 100px;
                    white-space: nowrap;
                }

                .card .additional .user-card .points {
                    margin-left: -60px;
                    margin-top: 50px;
                    position: absolute;
                    width: 120px;
                    top: 50%;
                    left: 50%;
                }

                .card .additional .user-card svg {
                    top: 50%;
                }

            .card .additional .more-info {
                width: 300px;
                float: left;
                position: absolute;
                left: 150px;
                height: 100%;
            }

                .card .additional .more-info h1 {
                    color: #fff;
                    margin-bottom: 0;
                }

            .card.green .additional .more-info h1 {
                color: #224C36;
            }

            .card .additional .coords {
                margin: 0 1rem;
                color: #fff;
                font-size: 1rem;
            }

            .card.green .additional .coords {
                color: #325C46;
            }

            .card .additional .coords span + span {
                float: right;
            }

            .card .additional .stats {
                font-size: 2rem;
                display: flex;
                position: absolute;
                bottom: 1rem;
                left: 1rem;
                right: 1rem;
                top: auto;
                color: #fff;
            }

            .card.green .additional .stats {
                color: #325C46;
            }

            .card .additional .stats > div {
                flex: 1;
                text-align: center;
            }

            .card .additional .stats i {
                display: block;
            }

            .card .additional .stats div.title {
                font-size: 0.75rem;
                font-weight: bold;
                text-transform: uppercase;
            }

            .card .additional .stats div.value {
                font-size: 1.5rem;
                font-weight: bold;
                line-height: 1.5rem;
            }

                .card .additional .stats div.value.infinity {
                    font-size: 2.5rem;
                }

            .card .general {
                width: 300px;
                height: 100%;
                position: absolute;
                top: 0;
                right: 0;
                z-index: 1;
                box-sizing: border-box;
                padding: 1rem;
                padding-top: 0;
            }

                .card .general .more {
                    position: absolute;
                    bottom: 1rem;
                    right: 1rem;
                    font-size: 0.9em;
                }
                
            .icon{
                margin-top: 60px;
                width:100px;
                left: 50%;
                margin-left:20px;
            }
            
            /*responsive card*/
            @media only screen and (max-width: 990px) {
                .card {
                    margin-bottom: 1.5rem;
                    left: 63%;
                    width: 400px;
                    margin-left: -250px;
                    height: 250px;
                    background-color: #fff;
                    background: linear-gradient(#f8f8f8, #fff);
                    box-shadow: 0 8px 16px -8px rgba(0,0,0,0.4);
                    border-radius: 6px;
                    overflow: hidden;
                    position: relative;
                }
                
                .icon {
                    margin-left: 0;
                }
                
                .card .additional {
                    width: 100px;
                }
                .card .additional .user-card .points {
                    margin-left: -84px;
                }
                
                .card .additional .more-info {
                    width: 250px;
                    left: 150px;
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
        <p class="navbar-brand py-2 d-md-inline-block">Profile</p>
      </nav>
<?php
    for ($j = 0 ; $j < $rows ; ++$j)
    {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_NUM);
        $user_id = $row[0];
        $user_name = $row[1];
        $user_type = $row[2];
        $user_dep = $row[3];
        $user_age = $row[4];
        $user_credit = $row[5];
    }
?>
      <div class="container-fluid">
            <div>
                <div class="card green">
                    <div class="additional">
                        <div class="user-card">
                            <img class="icon" src="https://img.icons8.com/android/96/000000/user.png"/>
                            <!--<a href="https://icons8.com/icon/3225/user">User icon by Icons8</a>-->
                            <div class="points">
                                <?php
                                    echo "User credit: ".$user_credit;
                                ?>
                            </div>
                                <title id="title">Teacher</title>
                                <style>
                                    .skin {
                                        fill: #eab38f;
                                    }
        
                                    .eyes {
                                        fill: #1f1f1f;
                                    }
        
                                    .hair {
                                        fill: #2f1b0d;
                                    }
        
                                    .line {
                                        fill: none;
                                        stroke: #2f1b0d;
                                        stroke-width: 2px;
                                    }
                                </style>
                                <defs>
                                    <clipPath id="scene">
                                        <circle cx="125" cy="125" r="115" />
                                    </clipPath>
                                    <clipPath id="lips">
                                        <path d="M 106,132 C 113,127 125,128 125,132 125,128 137,127 144,132 141,142  134,146  125,146  116,146 109,142 106,132 Z" />
                                    </clipPath>
                                </defs>
                                <circle cx="125" cy="125" r="120" fill="rgba(0,0,0,0.15)" />
                                <g stroke="none" stroke-width="0" clip-path="url(#scene)">
                                    <rect x="0" y="0" width="250" height="250" fill="#b0d2e5" />
                                    <g id="head">
                                        <path fill="none" stroke="#111111" stroke-width="2" d="M 68,103 83,103.5" />
                                        <path class="hair" d="M 67,90 67,169 78,164 89,169 100,164 112,169 125,164 138,169 150,164 161,169 172,164 183,169 183,90 Z" />
                                        <circle cx="125" cy="100" r="55" class="skin" />
                                        <ellipse cx="102" cy="107" rx="5" ry="5" class="eyes" id="eye-left" />
                                        <ellipse cx="148" cy="107" rx="5" ry="5" class="eyes" id="eye-right" />
                                        <rect x="119" y="140" width="12" height="40" class="skin" />
                                        <path class="line eyebrow" d="M 90,98 C 93,90 103,89 110,94" id="eyebrow-left" />
                                        <path class="line eyebrow" d="M 160,98 C 157,90 147,89 140,94" id="eyebrow-right" />
                                        <path stroke="#111111" stroke-width="4" d="M 68,103 83,102.5" />
                                        <path stroke="#111111" stroke-width="4" d="M 182,103 167,102.5" />
                                        <path stroke="#050505" stroke-width="3" fill="none" d="M 119,102 C 123,99 127,99 131,102" />
                                        <path fill="#050505" d="M 92,97 C 85,97 79,98 80,101 81,104 84,104 85,102" />
                                        <path fill="#050505" d="M 158,97 C 165,97 171,98 170,101 169,104 166,104 165,102" />
                                        <path stroke="#050505" stroke-width="3" fill="rgba(240,240,255,0.4)" d="M 119,102 C 118,111 115,119 98,117 85,115 84,108 84,104 84,97 94,96 105,97 112,98 117,98 119,102 Z" />
                                        <path stroke="#050505" stroke-width="3" fill="rgba(240,240,255,0.4)" d="M 131,102 C 132,111 135,119 152,117 165,115 166,108 166,104 166,97 156,96 145,97 138,98 133,98 131,102 Z" />
                                        <path class="hair" d="M 60,109 C 59,39 118,40 129,40 139,40 187,43 189,99 135,98 115,67 115,67 115,67 108,90 80,109 86,101 91,92 92,87 85,99 65,108 60,109" />
                                        <path id="mouth" fill="#d73e3e" d="M 106,132 C 113,127 125,128 125,132 125,128 137,127 144,132 141,142  134,146  125,146  116,146 109,142 106,132 Z" />
                                        <path id="smile" fill="white" d="M125,141 C 140,141 143,132 143,132 143,132 125,133 125,133 125,133 106.5,132 106.5,132 106.5,132 110,141 125,141 Z" clip-path="url(#lips)" />
                                    </g>
                                    <g id="shirt">
                                        <path fill="#8665c2" d="M 132,170 C 146,170 154,200 154,200 154,200 158,250 158,250 158,250 92,250 92,250 92,250 96,200 96,200 96,200 104,170 118,170 118,170 125,172 125,172 125,172 132,170 132,170 Z" />
                                        <path id="arm-left" class="arm" stroke="#8665c2" fill="none" stroke-width="14" d="M 118,178 C 94,179 66,220 65,254" />
                                        <path id="arm-right" class="arm" stroke="#8665c2" fill="none" stroke-width="14" d="M 132,178 C 156,179 184,220 185,254" />
                                        <path fill="white" d="M 117,166 C 117,166 125,172 125,172 125,182 115,182 109,170 Z" />
                                        <path fill="white" d="M 133,166 C 133,166 125,172 125,172 125,182 135,182 141,170 Z" />
                                        <circle cx="125" cy="188" r="4" fill="#5a487b" />
                                        <circle cx="125" cy="202" r="4" fill="#5a487b" />
                                        <circle cx="125" cy="216" r="4" fill="#5a487b" />
                                        <circle cx="125" cy="230" r="4" fill="#5a487b" />
                                        <circle cx="125" cy="244" r="4" fill="#5a487b" />
                                        <path stroke="#daa37f" stroke-width="1" class="skin hand" id="hand-left" d="M 51,270 C 46,263 60,243 63,246 65,247 66,248 61,255 72,243 76,238 79,240 82,243 72,254 69,257 72,254 82,241 86,244 89,247 75,261 73,263 77,258 84,251 86,253 89,256 70,287 59,278" />
                                        <path stroke="#daa37f" stroke-width="1" class="skin hand" id="hand-right" d="M 199,270 C 204,263 190,243 187,246 185,247 184,248 189,255 178,243 174,238 171,240 168,243 178,254 181,257 178,254 168,241 164,244 161,247 175,261 177,263 173,258 166,251 164,253 161,256 180,287 191,278" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="more-info">
                            <h1>
                                <?php
                                    echo $user_name;
                                ?>
                            </h1>
                            <div class="coords">
                                <span>User ID</span>
                                <span>
                                    <?php
                                        echo $user_id;
                                    ?>
                                </span>
                            </div>
                            <div class="coords">
                                <span>User Type</span>
                                <span>
                                    <?php
                                        echo $user_type;
                                    ?>
                                </span>
                            </div>
                            <div class="coords">
                                <span>Department</span>
                                <span>
                                    <?php
                                        echo $user_dep;
                                    ?>
                                </span>
                            </div>
                            <div class="coords">
                                <span>Age</span>
                                <span>
                                    <?php
                                        echo $user_age;
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="general">
                        <h1>
                            <?php
                                    echo $user_name;
                            ?>
                        </h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce a volutpat mauris, at molestie lacus. Nam vestibulum sodales odio ut pulvinar.</p>
                        <span class="more">Mouse over the card for more info</span>
                    </div>
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
  </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>

</body>
</html>