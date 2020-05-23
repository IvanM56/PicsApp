<?php 

require '../app/views/layouts/header.php'; 

use App\Config;

?>


<div class="row">
  <div class="col-md-12 ml-5">
    <div class="card card-body bg-light mt-5">
        <div class="media">
            <img class="rounded-circle" src="<?php echo Config::STORAGE; ?>profile_pics/<?php echo $data['profile_img']; ?>" width="200" height="200">
        </div><br><br>
        <label for="username">Userame: <?php echo $data['username']; ?></label>
        <label for="email">Email: <?php echo $data['email']; ?></label> 
        <label for="username">Nr. of pics: <?php echo $data['pic_count']; ?></label>      
    </div><br>
    <a href="<?php echo Config::ROOTURL; ?>" class="btn btn-outline-info btn-block">Home</a>
  </div>   
</div>  


<?php require '../app/views/layouts/footer.php'; ?>








