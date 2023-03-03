<?php

  require_once 'header.php';
  require_once './config.php';

   $email_err = $pass_err = $conpass_err = $name_err = $phn_error = "";
   $email = $pass = $confirmpass = $name= $phn = $status = $okay = "" ;

   if(isset($_POST['submit'])){

    $pass = $_POST['password'];
    $confirmpass = $_POST['conpass'];

 
    if(empty($_POST['email'])){
      $email_err  = "Please enter your email" ; 
    }else{
      $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_err  = "Please Enter Valid Email"; 
        }else{
          $emailquery = "select * from users where email = '$email'";
          $query = mysqli_query($link , $emailquery);
        
          $emailcount = mysqli_num_rows($query);
          if($emailcount > 0 ){
            $email_err = "email already exist";
          }
        }
    }
    if(empty($_POST['password'])){
        $pass_err  = "Please enter the password" ; 
    }
    
    if(strlen($pass)< 5 ){
        $pass_err  = "Your password length must be greater than 5 character" ; 
    }
    
    if(empty($_POST['conpass'])){
        $conpass_err  = "Please enter the confirm password" ; 
    }else{
        if($pass != $confirmpass){
            $conpass_err = "password not matched";
        }
    }


    if(empty($_POST['name'])){
      $name_err = "Please enter your name" ; 
    }else{
      $name= $_POST['name'];
      $name_pattern = '/^[a-zA-Z ]+$/';
        if(!preg_match($name_pattern ,  $name)){
          $name_err  = "Please enter valid naming" ; 
        }
    }
   

      if(empty($email_err) && empty($pass_err) && empty($conpass_err) && empty($name_error)){
        $pass= md5($_POST['password']);
           $sql = "INSERT INTO users(name , email , password) 
           values('$name' , '$email' , '$pass')";
         
         if (mysqli_query($link, $sql)) {
            $okay = '<div class="alert alert-success ">Successfully Register</div>';
          } else {
            $okay = '<div class="alert alert-danger ">Failed to Register</div>' ; 
         }
         mysqli_close($link);
          

    }

    }

?>


<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
  <span><?php echo $okay;?></span>
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form action = "" method = "post" class="mx-1 mx-md-4">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example1c">Your Name</label>
                      <input type="text" name="name" class="form-control" />
                      <span class="text-danger"> <?php echo $name_err ;?></span>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example3c">Your Email</label>
                      <input type="email" name="email" class="form-control"/>
                      <span class="text-danger"> <?php echo $email_err ;?></span>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4c">Password</label>
                      <input type="password" name="password" class="form-control" />
                      <span class="text-danger"> <?php echo $pass_err ;?></span>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="form3Example4cd">Repeat your password</label>
                      <input type="password" name = "conpass" class="form-control" />
                      <span class="text-danger"> <?php echo $conpass_err ;?></span>
                    </div>
                  </div>

              
                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    
                    <input type="submit" name="submit" class="btn btn-primary form-control" value="Register">
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="./images/register.jpeg"
                  class="img-fluid w-75" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php
   require_once 'footer.php';
?>