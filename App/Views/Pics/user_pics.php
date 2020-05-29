<?php 

require '../app/views/layouts/header.php'; 
require '../App/Views/Pics/remove_pic_modal.php';

use App\Config;
use App\Controllers\Users;
use App\Helpers\Session;

?>

<div class='ml-4 mt-5'>
    <h4>Pics by <?php echo $data['pics'][0]->username; ?></h4>
</div>

<!-- <div class="row">
    <?php foreach ($data['pics'] as $key => $pic): ?>
    <div class="ml-4 mt-5">
        <div class="card" style="width: 18rem;">
        <a href="../../public/img/<?php echo $pic->img_name; ?>"><img class="card-img-top" src="../../public/img/<?php echo $pic->img_name; ?>" alt="Card image cap"></a>
            <div class="card-body">
                <small>Uploaded at: <?php echo date_format(new DateTime($pic->uploaded_at), 'd/m/Y'); ?></small><br>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <?php 
                    if(Users::loggedIn() && $pic->user_id == Session::get('id')): 
                ?>
                    <a href="#" id="removePic" class="btn btn-danger" data-id="<?php echo $pic->id; ?>" data-toggle="modal" data-target="#remove-pic-modal">Remove</a>
                <?php else: ?>
                    <a href="#" class="btn btn-info">Can't remove</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>  -->

<div class="row">
    <?php foreach ($data['pics'] as $key => $pic): ?>
    <div class="custompic col-md-4 mt-5">
        <figure class="figure">
        <a href="../../public/img/<?php echo $pic->img_name ?>"><img src="../../public/img/<?php echo $pic->img_name ?>" class="figure-img img-fluid z-depth-1"
            alt="..." style="width: 400px"></a>
        <figcaption class="figure-caption">Uploaded at: <?php echo date_format(new DateTime($pic->uploaded_at), 'd/m/Y'); ?> </figcaption>
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
        </div>
    </div>
    <?php endforeach; ?>
</div>

   
<?php require '../app/views/layouts/footer.php'; ?>





