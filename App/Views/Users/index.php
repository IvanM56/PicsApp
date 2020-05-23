<?php 

require '../app/views/layouts/header.php'; 

use App\Config;

foreach ($users as $user):

?>

<div class="row">
  <div class="col-md-12 ml-5">
    <div class="card card-body bg-light mt-5">
        <div class="media">
            <img class="rounded-circle" src="<?php echo Config::STORAGE; ?>profile_pics/<?php echo $user->profile_img; ?>" width="200" height="200">
        </div><br><br>
        <label for="username">Userame: <?php echo $user->username; ?></label>
        <label for="username">Joined: <?php echo date_format(new DateTime($user->created_at), 'd/m/Y'); ?></label>
        <label for="email">Email: <?php echo $user->email; ?></label> 
        <label for="username">Nr. of pics: <?php echo $user->pic_count; ?></label>      
    </div><br>
  </div>   
</div> 
<br><br> 


<?php 

endforeach;

require '../app/views/layouts/footer.php'; 

?>


