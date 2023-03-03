<?php
   require_once 'header.php';

   require_once 'config.php';

   $username = $password = "";
   $username_err = $password_err = $error = "";

    //session_start();
    $_SESSION['id'] = "";

    if(empty($_SESSION['id'])){
      
    if(isset($_POST['submit'])){

        if(empty($_POST['username'])){
        $username_err  = "Please Enter Username" ; 
        }else{
        $username = $_POST['username'];
        }
    
        if(empty($_POST['password'])){
        $password_err  = "Please Enter Password" ; 
        }else{
        $password= md5($_POST['password']);
        }
        if(empty($username_err) && empty($password_err)){
            
        $sql = "SELECT * FROM users where name = '$username' and  password = '$password'";
    
        $result = mysqli_query($link , $sql);


        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['id'];
            header('Location: profile.php');
        }

        else{
            $error = '<div class="alert alert-danger ">Invalid login credentials</div>';
        }
        
        }
        

    }
    }
?>

<section class="vh-40">
  <div class="container-fluid h-custom">
    
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="./images/gallery-1.png"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mt-5">
        <form method = "post" action = "">
        <span class="text-danger"> <?php echo $error;?></span>
        <br>
          <!-- User input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">User Name</label>
          <input type="text" placeholder="write your username" class="form-control" name="username">
          <span class="text-danger"> <?php echo $username_err ;?></span>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="form3Example4">Password</label>
            <input type="password" placeholder = "write your password" class="form-control" name="password">
            <span class="text-danger"> <?php echo $password_err ;?></span>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
          <input type="submit" name="submit" class="w-50 form-control bg-success" value="Login">
          </div>
        </form>
      </div>
    </div>
  </div>
  
</section>


<?php
   require_once 'footer.php';
?>