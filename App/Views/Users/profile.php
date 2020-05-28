<?php 

require '../App/Views/Layouts/header.php'; 

use App\Config;

?>

<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card card-body bg-light mt-5">
        <div class="media">
            <img class="rounded-circle" src="<?php echo Config::STORAGE; ?>profile_pics/<?php echo $data['profile_img']; ?>" width="200" height="200">
        </div><br><br>
        <label for="username">Userame: <?php echo $data['username']; ?></label>
        <label for="email">Email: <?php echo $data['email']; ?></label> 
        <label for="username">Nr. of pics: <?php echo $data['pic_count']; ?></label>  
        <label for="username">Nr. of docs: <?php  ?></label>     
    </div><br>
    <a href="<?php echo Config::ROOTURL; ?>pics/index" class="btn btn-outline-info btn-block">Go to pics</a>
  </div>   
</div>  


<?php require '../app/views/layouts/footer.php'; ?>








