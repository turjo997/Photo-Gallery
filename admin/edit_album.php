<?php

require_once 'header.php';
require_once '../config.php';
include 'check_login.php';

$error ="";
$okay = "";
$title_id = $_GET['title_id'];
$title = $title_err = "";


$record = mysqli_query($link, "SELECT * FROM album WHERE id= '$title_id'");


while($item = mysqli_fetch_array($record)){
    $title = $item['title'];
}

$data = array();

if (isset($_POST["submit"])) {

      $title = $_POST["title"];

     // echo $title;

      $titlequery = "select * from album where title = '$title'";
      $query = mysqli_query($link , $titlequery);
    
      $count = mysqli_num_rows($query);
      if($count > 0 ){
        $title_err = "Already exists the title";
      }

      if(empty($title_err)){
        $slug = preg_replace('/[^a-z0-9]+/i', '_', trim(strtolower($_POST["title"])));
        $slug = '['.$slug.']';

        $slugquery = "SELECT short_code FROM album WHERE short_code LIKE '$slug%'";
  
  
        $query = mysqli_query($link, $slugquery);
  
        $slugcount = mysqli_num_rows($query);


      if ($slugcount > 0) {

        $result1 = mysqli_query($link, $slugquery);

        while ($row = mysqli_fetch_array($result1)) {
          $data[] = $row['short_code'];
        }

        if (in_array($slug, $data)) {
          $count = 0;
          while (in_array(($slug . '_' . ++$count), $data));
          $slug = $slug . '_' . $count;
        }
      }

        $sql = "UPDATE album set title = '$title'  , short_code = '$slug' where id = '$title_id'";  

                
        if (!$link) {
            die("Connection failed: " . mysqli_connect_error());
            }

            if (mysqli_query($link, $sql)) {
            $okay = '<div class="alert alert-success ">Successfully Updated</div>';
            } else {
            $okay = '<div class="alert alert-danger ">Failed to Updated</div>' ; 
        }
        mysqli_close($link);


      }
    }
?>
<section class="vh-10">
  <div class="container h-custom">

    <div class="row d-flex h-100">

      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mt-5">
        <h2>Update Gallery</h2>
        <form method="post" action="">
          <span class="text-danger"> <?php echo $okay; ?></span>
          <br>

          <div class="form-outline mb-4">
            <label class="form-label" for="form3Example3">Add Title</label>
            <input type="text" value="<?php echo $title; ?>" class="form-control" name="title">
            <span class="text-danger"> <?php echo $title_err ;?></span>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" name="submit" class="w-50 form-control bg-success" value="Update">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>





<?php
require_once 'footer.php';
?>