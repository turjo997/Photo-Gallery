<?php
require_once 'header.php';
require_once '../config.php';

$title = $id = $code = $description = $filename = $image = "";
$title_err = $description_err = $image_err = "";
$okay = "";

if(isset($_POST['submit'])){

    //echo 'inside';
     
    if (empty($_POST['id'])) {
        $title_err  = "Please select the title";
    } else {
        $id = $_POST['id'];

    }
    if (empty($_POST['description'])) {
        $description_err  = "Please write some description";
       
    } else {
        $description = $_POST['description'];
    }
  
    if (!isset($_FILES['image'])) {
        $image_err  = "Please Select Image";
    } else {
      $target_dir = "../images/";
      $img = $_FILES['image']['name'];
      $path = pathinfo($img);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $temp_name = $_FILES['image']['tmp_name'];
      $path_filename_ext = $target_dir.$filename.".".$ext;
      move_uploaded_file($temp_name,$path_filename_ext);
    }

    if (empty($title_err) && empty($description_err) && empty($image_err)) {

        $sql = "INSERT INTO images (gallery_id , description , image) 
        values('$id' , '$description' , '$path_filename_ext')";


        if (!$link) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (mysqli_query($link, $sql)) {
            $okay = '<div class="alert alert-success ">Successfully Added the image</div>';
        } else {
            $okay = '<div class="alert alert-danger ">Failed to Added</div>';
        }
      //  mysqli_close($link);
    }

}


?>
<section>

<div class="container-fluid">
    <div class=" text-center mt-5 ">
        <h1>Add Images</h1>
        <span><?php echo $okay;?></span>
    </div>

    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">

                    <div class="container">
                        <form action="" method = "post" enctype="multipart/form-data">

                            <div class="controls">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_title">Gallery</label>
                                        <?php
                                                
                                        $sql1 = "Select * from album";
                                        $res1 = mysqli_query($link , $sql1);
                                                //$count = mysqli_num_rows($res1);

                                        if (mysqli_num_rows($res1) > 0) {
                                            ?>
                                            <select id="selectOption" name="id" class=" form-control">
                                            <option value="">--Select A Gallery--</option>
                                            <?php

                                                foreach ($res1 as $item) {
                                                ?>
                                                <option id="title" value="<?= $item['id']; ?>"><?= $item['title']; ?></option>

                                                <?php

                                                }
                                                ?>
                                            </select>
                                            <?php

                                        }

                                    ?>
                                               
                                    </div> 
                                </div>
                            </div>
                      
                                <div class="row">

                                    <div class="col-md-12">
                                        <br>
                                        <div id="imgPreview"></div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input id = "imgInput" type="file" class="form-control" name="image">
                                        </div>

                                    </div>

                                    </div>

                                   


                                    <div class="row">

                                        <div class="col-md-12">
                                            <br>
                                            <div class="form-group">
                                                <label for="form_message">Description</label>
                                                <textarea  name="description" class="form-control" placeholder="Write your message here." rows="4"></textarea>
                                            </div>

                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <br>
                                            <input type="submit" name = "submit" class="btn btn-success btn-send  pt-2 btn-block
                        " value="Add Images">

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


</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>



    <script>
        const imgInput = document.getElementById('imgInput');
        const imgPreview = document.getElementById('imgPreview');

        imgInput.addEventListener('change', () => {
     //   imgPreview.innerHTML = ''; // Clear previous preview

        // Loop through each selected image and create a preview
        for (let i = 0; i < imgInput.files.length; i++) {
            const file = imgInput.files[i];
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            imgPreview.appendChild(img);
            
        }
        });

    </script>

<?php
require_once 'footer.php';
?>




