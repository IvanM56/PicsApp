<?php 

require '../App/Views/Layouts/header.php'; 

use App\Config; 

?>


<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card card-body bg-light mt-5">
        <h2>Enter your new password</h2><br>
        <form action="<?php echo Config::ROOTURL; ?>users/reset-password" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <div class="form-group">
                <label for="password">Password: <sup>*</sup></label>
                <input type="password" name="password" class="form-control form-control-lg 
                <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
            </div><br>
            <div class="form-group">
                <label for="confirm_password">Confirm password: <sup>*</sup></label>
                <input type="password" name="confirm_password" class="form-control form-control-lg 
                <?php echo (!empty($data['confirm_password_error'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['confirm_password_error']; ?></span>
            </div><br>
            <div class="row">
                <div class="col">
                    <input type="submit" name="submit" value="Reset password" class="btn btn-success btn-block">
                </div>
                <div class="col">
                    <a href="<?php echo Config::ROOTURL; ?>users/login" class="btn btn-info btn-block">Go back</a>
                </div>
            </div><br>
        </form>   
    </div>
  </div>   
</div>  


<?php require '../app/views/layouts/footer.php'; ?>