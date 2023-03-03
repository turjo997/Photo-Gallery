<?php

require_once 'layout/header.php';
require_once '../config.php';

$image_url = array();
$url=$_REQUEST['pageurl'];


$slug_url  = substr($url ,5);


$result_table = ""; 

$sql = "select * from pages where slug_title='$slug_url'";
$res = mysqli_query($link, $sql);

$data = mysqli_fetch_array($res);


$count = mysqli_num_rows($res);

if ($count > 0) {
  $record = mysqli_query($link, "select * from pages where slug_title = '$slug_url'");
  $description = "";
  while($item = mysqli_fetch_array($record)){
      $description = $item['description'];
  }
  $pattern = '/\\[.*?]/i';;

  $item = preg_match($pattern , $description , $matches);
//  echo $matches[0];

  $sql =  mysqli_query($link, "select * from album where short_code = '$matches[0]'");

  //echo $description;


  $foundItem = str_replace($matches[0] , "" , $description);

  $result_table = $foundItem;


  $id = "";
  while($item = mysqli_fetch_array($sql)){
      $id = $item['id'];
      //echo $description;
  }


  $sql1 = "SELECT * FROM images where gallery_id = '$id'";
  $result = mysqli_query($link , $sql1); 

  $count = mysqli_num_rows($result);

  
  if ($count > 0) {
//   while($row = mysqli_fetch_array($result)){          
//     $result_table .= '
//     <div>Description : '.$row["description"].'</div>';
//  }

}

$result = mysqli_query($link , $sql1); 

 if ($count > 0) {

  while($row = mysqli_fetch_array($result)){   
    array_push($image_url , $row);
  }

}


}else{
echo 'not found';
}

?>


 <!-- Slideshow container -->
 <div class="slideshow-container">

  <?php
     echo $result_table;
  ?>

<!-- Full-width images with number and caption text -->

<?php
    //$image_url=array_unique($image_url,SORT_REGULAR);
    foreach($image_url as $row)
    {
        //echo $row["image"];
        echo '<div class=mySlides fade>
        <img src="../images/'.$row["image"].'" style="width:100%">
        <div class="text">'.$row["description"].'</div>
        </div>';
    }

  ?>
        
<!-- Next and previous buttons -->
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
<span class="dot" onclick="currentSlide(1)"></span>
<span class="dot" onclick="currentSlide(2)"></span>
<span class="dot" onclick="currentSlide(3)"></span>
</div> 
    

<footer>

<div class="footer">

    <h3 style="font-size: 30px;"> <span class="orange-color">Photo</span> <span style="color: gray;"> Gallery</span>
    </h3>
    <p>The art of photography is all about directing the attention of the viewer.</p>


</div>
</footer>

<script>

setInterval(myFunction, 3000);
function myFunction() 
{
    plusSlides(1);
}
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) 
{
  showSlides(slideIndex += n);
}

function currentSlide(n) 
{
  showSlides(slideIndex = n);
}

function showSlides(n) 
{
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) 
  {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) 
  {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";

}
</script>