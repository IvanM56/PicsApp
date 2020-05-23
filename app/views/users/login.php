<?php 

require '../app/views/layouts/header.php';

use App\Config; 

?>


<div class="row">
  <div class="col-md-12 ml-5">
    <div class="card card-body bg-light mt-5">
        <h2>Login</h2>
        <p>Please fill in your credentials to log in</p>
        <form action="<?php echo Config::ROOTURL; ?>users/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg 
                <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo (isset($_COOKIE['email'])) ? $_COOKIE['email'] : $data['email']; ?>" >
                <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password: <sup>*</sup></label>
                <input type="password" name="password" class="form-control form-control-lg 
                <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo (isset($_COOKIE['password'])) ? $_COOKIE['password'] : $data['password']; ?>">
                <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
            </div><br>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" <?php echo (isset($_COOKIE['password'])) ? 'checked' : ''; ?> >
                <label class="form-check-label" for="remember">Remember me</label>
            </div><br>
            <div class="row">
                <div class="col">
                    <input type="submit" name="submit" value="Login" class="btn btn-success btn-block">
                </div>
                <div class="col">
                    <a href="<?php echo Config::ROOTURL; ?>users/register" class="btn btn-light btn-block">Need an account? Well, register!</a>
                </div>
            </div><br>
        </form>   
            <div class="form-group">
                <small class="text-muted ml-2">
                    <a href="<?php echo Config::ROOTURL; ?>users/send-email" style="float:right">Forgot Password?</a>
                </small>
            </div>
    </div>
  </div>   
</div>  


<?php require '../app/views/layouts/footer.php'; ?>