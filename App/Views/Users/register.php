
<?php 

require '../App/Views/Layouts/header.php'; 

use App\Config;
use App\Helpers\Validation;

?>


<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-body bg-light mt-5">
        <h2>Create an account</h2>
        <p>Please fill out this form to register with us</p>
        <div class="media">
            <img class="rounded-circle" src="<?php echo Config::STORAGE; ?>profile_pics/default.jpg" width="200" height="200">
        </div><br>
        <form action="<?php echo Config::ROOTURL; ?>users/register" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <div class="form-group">
                <input type="file" class="form-control-file form-control-sm 
                <?php echo (!empty($data['profile_img_error'])) ? 'is-invalid' : ''; ?>" name="profile_pic" id="profile_pic">
                <span class="invalid-feedback"><?php echo $data['profile_img_error']; ?></span>
            </div>
            <div class="form-group">
                <label for="username">Userame: <sup>*</sup></label>
                <input type="text" name="username" class="form-control form-control-lg 
                <?php echo Validation::hasError('username') ? 'is-invalid' : '' ?>" value="<?php echo $data['username']; ?>" >
                <span class="invalid-feedback"><?php echo Validation::hasError('username'); ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg 
                <?php echo Validation::hasError('email') ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" >
                <span class="invalid-feedback"><?php echo Validation::hasError('email'); ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password: <sup>*</sup></label>
                <input type="password" name="password" class="form-control form-control-lg 
                <?php echo Validation::hasError('password') ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>" >
                <span class="invalid-feedback"><?php echo Validation::hasError('password'); ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm password: <sup>*</sup></label>
                <input type="password" name="confirm_password" class="form-control form-control-lg 
                <?php echo Validation::hasError('confirm_password') ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>" >
                <span class="invalid-feedback"><?php echo Validation::hasError('confirm_password'); ?></span>
            </div>

            <div class="row">
                <div class="col">
                    <input type="submit" name="submit" value="Register" class="btn btn-success">
                </div>
                <div class="col">
                    <a href="<?php echo Config::ROOTURL; ?>users/login" class="btn btn-light">Already have an account? Login!</a>
                </div>
            </div>
        </form>
    </div>
  </div>   
</div>  

<?php require '../app/views/layouts/footer.php'; ?>
