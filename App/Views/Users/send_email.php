<?php 

require '../app/views/layouts/header.php'; 

use App\Config; 

?>


<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card card-body bg-light mt-5">
        <h2>Reset your password</h2><br>
        <form action="<?php echo Config::ROOTURL; ?>users/send-email" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg 
                <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="" >
                <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
            </div>
            <div>
                <p class="text-danger"><?php echo (!empty($data['email_msg'])) ? $data['email_msg'] : ''; ?></p>
            </div>
            <div class="row">
                <div class="col mt-3">
                    <input type="submit" name="submit" value="Reset password" class="btn btn-success btn-block">
                </div>
                <div class="col mt-2">
                    <a href="<?php echo Config::ROOTURL; ?>users/login" class="btn btn-info btn-block">Go back</a>
                </div>
            </div><br>
        </form>   
    </div> 
  </div>   
</div>  


<?php require '../app/views/layouts/footer.php'; ?>