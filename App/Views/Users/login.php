<?php 

require '../App/Views/Layouts/Header.php';

use App\Config; 
use App\Helpers\Validation;

?>


<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-body bg-light mt-5">
        <h2>Login</h2>
        <p>Please fill in your credentials to log in</p><br>
        <form action="<?php echo Config::ROOTURL; ?>users/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
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
            <div>
                <p class="text-danger"><?php echo (!empty($data['login_error'])) ? $data['login_error'] : ''; ?></p>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" <?php echo $data['remember'] ? 'checked' : ''; ?> >
                <label class="form-check-label" for="remember">Remember me</label>
            </div><br>
            <div class="row">
                <div class="col">
                    <input type="submit" name="submit" value="Login" class="btn btn-success">
                </div>
                <div class="col">
                    <a href="<?php echo Config::ROOTURL; ?>users/register" class="btn btn-light">Need an account? Well, register!</a>
                </div>
            </div><br>
        </form>   
            <div class="form-group mr-4 pr-2">
                <small class="text-muted">
                    <a href="<?php echo Config::ROOTURL; ?>users/send-email" style="float:right">Forgot Password?</a>
                </small>
            </div>
    </div>
  </div>   
</div>  


<?php require '../app/views/layouts/footer.php'; ?>