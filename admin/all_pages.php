<?php
require_once 'header.php';
require_once '../config.php';


$result = "" ;
$result_table="";

 $sql = "SELECT * FROM pages";
 $result = mysqli_query($link , $sql); 
 if(mysqli_num_rows($result)>0){

   $result_table.= '
   <table class="table table-striped table-bordered table-hover table-success text-center">
   <thead>
         <tr>
             <th>Page Title</th>
             <th>Page Slug</th>
             <th>Action1</th>
             <th>Action2</th>
         </tr>
        </thead>';
         
   while($row = mysqli_fetch_array($result)){
     
       $result_table .= '<tbody>
       <tr>
        <td>'.$row['title'].'</td>
        <td>'.$row['slug_title'].'</td>
        <td><a href="edit_page.php?page_id='.$row['id'].'">Edit</a></td>
        <td><a href="delete_page.php?page_id='.$row['id'].'">Delete</a></td>
       </tr>
       </tbody>';
   }
   $result_table .= '</table>';
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



<div class="row">
      <div class="col-lg-2">
 
      </div>
    
       <div class="col-lg-8">
           <h1>View Fields</h1>
           <?php echo $result_table; ?>
       </div>
  </div>


<?php
require_once 'footer.php';
?>
