<?php

require '../App/Views/Layouts/header.php'; 
require '../App/Views/Pics/remove_pic_modal.php';

use App\Config;
use App\Controllers\Pics;

foreach ($pics as $pic) : 

?>


<div class="ml-4 mt-3">
    <div class="card" style="width: 18rem;">
    <a href="img/<?php echo $pic->img_name ?>"><img class="card-img-top" src="img/<?php echo $pic->img_name ?>" alt="Card image cap" width="" height=""></a>
        <div class="card-body">
            <small>Uploaded at: <?php echo date_format(new DateTime($pic->uploaded_at), 'd/m/Y'); ?>, by <h6><a href="<?php echo Config::ROOTURL; ?>pics/user-pics/<?php echo $pic->user_id; ?>"><?php echo $pic->username; ?></a></h6></small>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>      
            <?php 
                if(logged_in() && $pic->user_id == $_SESSION['id']): 
            ?>
            <a href="#" id="removePic" class="btn btn-danger" data-id="<?php echo $pic->id; ?>" data-toggle="modal" data-target="#remove-pic-modal">Remove</a>
            <?php else: ?>
                <a href="" class="btn btn-info">Can't remove</a>
            <?php endif; ?>   
                <a href="<?php echo Config::ROOTURL; ?>users/profile/<?php echo $pic->user_id ?>"><img class="rounded-circle" style="float:right" src="img/profile_pics/<?php echo $pic->profile_img; ?>" width="40" height="40"></a>
        </div>
    </div>
</div>


<?php 

endforeach;

require '../app/views/layouts/footer.php';

?>









