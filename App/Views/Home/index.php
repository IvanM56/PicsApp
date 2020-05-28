<?php

require '../App/Views/Layouts/header.php'; 
require '../App/Views/Pics/remove_pic_modal.php';

use App\Config; 

?>

<div class="row justify-content-center">
    <div class="jumbotron card card-image col-md-9 mt-3" style="background-image: url(https://mdbootstrap.com/img/Photos/Others/gradient1.jpg);">
        <div class="text-white text-center py-5 px-4">
            <div>
            <h2 class="card-title h1-responsive pt-3 mb-5 font-bold"><strong>Welcome to Pics&Docs</strong></h2>
            <p class="mx-5 mb-5">Feel free to register and post some great photos and documents or choose from below to lurk others and their work!
            </p>
            <a href="<?php echo Config::ROOTURL; ?>pics/index" class="btn btn-outline-white btn-md"><i class="fas fa-camera-retro left"></i> Pics</a>
            <a href="#" class="btn btn-outline-white btn-md"><i class="far fa-newspaper left"></i> Docs</a>
            <a href="<?php echo Config::ROOTURL; ?>users/index" class="btn btn-outline-white btn-md"><i class="fas fa-id-card left"></i> Users</a>
            </div>
        </div>
    </div>
</div>


<?php require '../app/views/layouts/footer.php'; ?>









