<?php
require_once 'header.php';
require_once '../config.php';

$okay = "";
$title = "";
$description = "";
$status = "";

$page_id = $_GET['page_id'];

$record = mysqli_query($link, "SELECT * FROM pages WHERE id= '$page_id'");


while($item = mysqli_fetch_array($record)){
    $title = $item['title'];
    $description = $item['description'];
    $status = $item['status'];
}

// echo $description;
$data = array();

if (isset($_POST["submit"])) {

      $title = $_POST["title"];

     // echo $title;

      $titlequery = "select * from pages where title = '$title'";
      $query = mysqli_query($link , $titlequery);
    
      $count = mysqli_num_rows($query);
      if($count > 0 ){
        $title_err = "Already exists the title";
      }

      if(empty($title_err)){
        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST["title"])));

        $slugquery = "SELECT slug_title FROM pages WHERE slug_title LIKE '$slug%'";
  
  
        $query = mysqli_query($link, $slugquery);
  
        $slugcount = mysqli_num_rows($query);


      if ($slugcount > 0) {

        $result1 = mysqli_query($link, $slugquery);

        while ($row = mysqli_fetch_array($result1)) {
          $data[] = $row['slug_title'];
        }

        if (in_array($slug, $data)) {
          $count = 0;
          while (in_array(($slug . '-' . ++$count), $data));
          $slug = $slug . '-' . $count;
        }
      }

        $sql = "UPDATE pages set title = '$title',slug_title = '$slug' , description = '$description' 
        where id = '$page_id'";  

                
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
<section>

<div class="container-fluid">
    <div class=" text-center mt-5 ">

        <h1>Edit Page</h1>

        <span><?php echo $okay;?></span>
    </div>

    <div class="row ">
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">

                    <div class="container">
                        <form action="" method = "post" enctype="multipart/form-data">

                            <div class="controls">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_title">Page Title</label>

                                            <input id="slug" value="<?php echo $title; ?>" type="text" name="title" class="form-control">

                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="col-md-12">
                                            <br>
                                            <div class="form-group">
                                                <label for="form_message">Description</label>
                                                <textarea value="<?php echo $description; ?>" id="summernote" name="description" class="form-control" rows="4"></textarea>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                    <div class="col-md-12">
                                            <br>
                                            <label for="form_status">Status</label>
                                            <br>

                                            <select name="status">
                                                <br>
                                                <?php
                                                    if($status == 1){
                                                        echo '<option value="1">Active</option>';
                                                        echo '<option value="-1">Inactive</option>';
                                                    }else{
                                                        echo'<option value="-1">Inactive</option>';
                                                        echo '<option value="1">Active</option>';
                                                    }
                                                ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <br>
                                            <input type="submit" name = "submit" class="btn btn-success btn-send  pt-2 btn-block
                        " value="Edit Pages">

                                        </div>

                                    </div>

                                </div>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.8 -->

        </div>
        <!-- /.row-->

    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Summernote JS - CDN Link -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        // $("#summernote").summernote();

        $('#summernote').summernote({
           
            height: 220,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('.dropdown-toggle').dropdown();
    });
</script>
<!-- //Summernote JS - CDN Link -->


<?php
require_once 'footer.php';
?>