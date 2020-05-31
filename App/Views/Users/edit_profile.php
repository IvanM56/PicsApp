<?php 

require '../App/Views/Layouts/header.php'; 
require '../App/Views/Users/delete_profile_modal.php';

use App\Config;
use App\Helpers\Validation;

?>

<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card card-body bg-light mt-5">
        <h2>Change your data</h2><br>
        <div class="media">
            <img class="rounded-circle" src="<?php echo Config::STORAGE; ?>profile_pics/<?php echo ($data['profile_img'] != 'default.jpg') ? $data['profile_img'] : 'default.jpg'; ?>" width="200" height="200">
        </div><br>
        <form action="<?php echo Config::ROOTURL; ?>users/edit-profile/<?php echo $data['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <div class="form-group">
                <input type="file" class="form-control-file form-control-sm 
                <?php echo(!empty($data['profile_img_error'])) ? 'is-invalid' : ''; ?>" name="upd_profile_pic" id="upd_profile_pic">
                <span class="invalid-feedback"><?php echo $data['profile_img_error']; ?></span>
            </div>
            <div class="form-group">
                <label for="username">Userame: <sup>*</sup></label>
                <input type="text" name="username" class="form-control form-control-lg 
                <?php echo Validation::hasError('username') ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                <span class="invalid-feedback"><?php echo Validation::hasError('username'); ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg 
                <?php echo Validation::hasError('email') ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo Validation::hasError('email'); ?></span>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <input type="submit" name="submit" value="Update" class="btn btn-success">
                </div>
                <div class="col">
                    <a href="#" id="delProfile" class="btn btn-danger float-right" data-id="<?php echo $data['id']; ?>" 
                    data-toggle="modal" data-target="#delete-profile-modal">Delete profile?</a>
                    <!-- <a href="<?php echo Config::ROOTURL; ?>users/delete-profile/<?php ?>" class="btn btn-danger btn-block">Delete profile?</a> -->
                </div>
            </div>
        </form>
    </div>
  </div>   
</div>  

<?php 

require '../app/views/layouts/footer.php'; 

?>

