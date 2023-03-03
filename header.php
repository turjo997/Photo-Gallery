<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/style_post.css">
  <link rel="stylesheet" href="./styles/style_table.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


  <title>Photo Gallery</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="login.php">

        <img src="./images/logo.jpg" alt="logo">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>

      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">

        <ul class="navbar-nav">

          <?php
          require_once 'config.php';
          session_start();
         // $_SESSION['id'] = "";

          if (empty($_SESSION['id'])) {
          

                     $gallery = "select * from pages where status=1";
                     $query_run = mysqli_query($link, $gallery);
         
         
                     if (mysqli_num_rows($query_run) > 0) {
                       foreach ($query_run as $items) {
                     ?>
         
                         <li class="nav-item">
                           <a class="nav-link active" href="page/<?=$items['slug_title']?>"><?=$items['title']?></a>
                           
                         </li>
                     <?php
                       }
                     }

                     echo '
                     <li class="nav-item">
                     <a class="nav-link active" href="login.php">Login</a>
                     </li>
                
                     <li class="nav-item">
                     <a class="nav-link active" href="signup.php">Signup</a>
                     </li>
                     ';
          } else {

            echo '
            <li class="nav-item">
             <a class="nav-link active" href="profile.php">Profile</a>
             </li>
             ';

            $gallery = "select * from pages where status=1";
            $query_run = mysqli_query($link, $gallery);


            if (mysqli_num_rows($query_run) > 0) {
              foreach ($query_run as $items) {
            ?>

                <li class="nav-item">
                  <a class="nav-link active" href="page/<?=$items['slug_title']?>"><?=$items['title']?></a>
                  
                </li>
            <?php
              }
            }

            echo '<li class="nav-item">
                  <a class="nav-link active" href="logout.php">Logout</a>
                 </li>';        
          }
          ?>

        
        </ul>

      </div>

    </div>
  </nav>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://kit.fontawesome.com/4b66e2d851.js" crossorigin="anonymous"></script>

</body>

</html>