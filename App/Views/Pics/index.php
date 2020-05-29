<?php

require '../App/Views/Layouts/header.php'; 
require '../App/Views/Pics/remove_pic_modal.php';

use App\Config;
use App\Controllers\Users;
use App\Helpers\Session;

?>

<div class="row">
    <?php foreach ($pics as $pic): ?>
    <div class="custompic col-md-4 mt-5">
        <figure class="figure">
        <a href="../img/<?php echo $pic->img_name ?>"><img src="../img/<?php echo $pic->img_name ?>" class="figure-img img-fluid z-depth-1"
            alt="..." style="width: 400px"></a>
        <figcaption class="figure-caption">Uploaded at: <?php echo date_format(new DateTime($pic->uploaded_at), 'd/m/Y'); ?> 
        by <a href="<?php echo Config::ROOTURL; ?>pics/user-pics/<?php echo $pic->user_id; ?>"><?php echo $pic->username; ?></a></figcaption>
        </figure>
        <div class="row">
            <?php if(Users::loggedIn() && $pic->user_id == Session::get('id')): ?>
            <div class="ml-3">
                <a href="#" id="removePic" class="btn btn-danger" data-id="<?php echo $pic->id; ?>" data-toggle="modal" data-target="#remove-pic-modal">Remove</a>
            </div>
            <?php else: ?>
            <div class="ml-3">
                <a href="#" class="btn btn-info">Can't remove</a>
            </div>
            <?php endif; ?>  
            <div class="ml-auto mr-5 pt-2 pr-5">
                <a href="<?php echo Config::ROOTURL; ?>users/profile/<?php echo $pic->user_id ?>">
                <img class="rounded-circle" style="float:right" src="../img/profile_pics/<?php echo $pic->profile_img; ?>" width="40" height="40"></a>
            </div>     
        </div>
    </div>
    <?php endforeach; ?> 
</div>


<?php require '../app/views/layouts/footer.php'; ?>









