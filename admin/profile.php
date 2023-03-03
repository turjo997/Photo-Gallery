<?php
require_once 'header.php';

include 'check_login.php';

$error = $title = $title_err = $slug = $okay = "";

$data = array();

if (isset($_POST["submit"])) {

  if(empty($_POST["title"])){
    $title_err = "Please enter the title";
  }else{
      $title = $_POST["title"];

      // $albumquery = "select * from album where title = '$title'";
      // $query = mysqli_query($link , $albumquery);
    
      // $count = mysqli_num_rows($query);
      // if($count > 0 ){
      //   $title_err = "This title already exists";
      // }

    
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
  }    


  if(empty($title_err)){

      $insert_query = "INSERT INTO album (title, short_code) VALUES ('$title', '$slug')";

      if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
      }

      if (mysqli_query($link, $insert_query)) {

        $okay = '<div class="alert alert-success ">Successfully Added New Gallery</div>';
      } else {
        $okay = '<div class="alert alert-danger ">Failed to Added</div>';
      }
     // mysqli_close($link);
}else{

  $okay = '<div class="alert alert-danger ">Some error has occurred</div>';
}

}

   $result = "" ;
   $result_table="";

    $sql = "SELECT * FROM album";
    $result = mysqli_query($link , $sql); 
    if(mysqli_num_rows($result)>0){

      $result_table.= '
      <section class="intro">
      <div class="h-100">
        <div class="mask d-flex align-items-center h-100">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
                      <table class="table table-striped mb-0">
                        <thead style="background-color: #002d72;">
                        <tr>
                        <th>Title Name</th>
                        <th>Short Code</th>
                        <th>Action1</th>
                        <th>Action2</th>
                        </tr>
                        </thead>';
            
      while($row = mysqli_fetch_array($result)){
          $result_table .= '  
          <tbody>
          <tr>
          <td>'.$row['title'].'</td>
          <td>'.$row['short_code'].'</td>
          <td><a href="edit_album.php?title_id='.$row['id'].'">Edit</a></td>
          <td><a href="delete_album.php?title_id='.$row['id'].'">Delete</a></td>
         </tr>
          </tbody>';
    
      }
      $result_table .= " 
          </table>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </section>';";
  }
  else{    
    $result_table = '<div class="alert alert-danger ">No record found</div>';
  }
?>

<?php 
         if(isset($_SESSION['msg'])){
           echo "<h2>".$_SESSION['msg']."</h2>";
           unset($_SESSION['msg']);
         }
?>


<section class="vh-10">
  <div class="container h-custom">

    <div class="row d-flex h-100">

      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mt-5">
        <h2>Create New Gallery</h2>
        <form method="post" action="">
          <span class="text-danger"> <?php echo $okay; ?></span>
          <br>

          <div class="form-outline mb-4">
            <label class="form-label" for="form3Example3">Add Title</label>
            <input type="text" placeholder="write the title" class="form-control" name="title">
            <span class="text-danger"> <?php echo $title_err; ?></span>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" name="submit" class="w-50 form-control bg-success" value="Add new gallery">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


<?php echo $result_table; ?>


<?php
require_once 'footer.php';
?>