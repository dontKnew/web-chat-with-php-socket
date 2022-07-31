
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Chat-Aplication </title>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./public/css/style.css">
  <link rel="stylesheet" href="./public/css/font-awesome.min.css">
</head>
<style>
  html,
  body {
    height: auto;
    width: 100%;
    margin: 0;
  }
</style>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container">
      <!-- Navbar brand -->
      <a class="navbar-brand me-2" href="./">
        <img src="./public/image/chat-logo.jpg" height="50" alt="MDB Logo" loading="lazy" style="margin-top: -1px;" />
      </a>

      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarButtonsExample">
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="./">Global Chat</a>
          </li>
        </ul>
        <!-- Left links -->

        <div class="d-flex align-items-center">
          <?php if(isset($_SESSION["isLogged"])){
              echo '<button type="button" class="btn btn-secondary me-3"> Welcome '.$_SESSION['user_data']['user_name'].'<a href="logout.php" class="text-danger"> | Logout</a></button>';
          }else{
              echo '<button type="button" class="btn btn-link px-3 me-2">
              <a href="./"> Login</a>
            </button>
            <a href="register"> <button type="button" class="btn btn-outline-success me-3">
                Sign up for free
              </button> </a>';
          }
            ?>
          <a class="btn btn-dark px-3" href="https://github.com/dontKnew" role="button"><i class="fab fa-github"></i></a>
        </div>
      </div>
      <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
  