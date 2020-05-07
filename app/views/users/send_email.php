<?php require '../app/views/layouts/header.php'; ?>


<div class="row">
  <div class="col-md-12 ml-5">
    <div class="card card-body bg-light mt-5">
        <h2>Reset your password</h2><br>
        <form action="<?php echo home() ?>users/send_email" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg 
                <?php echo (!empty($data['email_msg'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['email_msg']; ?></span>
            </div><br>
            <div class="row">
                <div class="col">
                    <input type="submit" name="submit" value="Reset password" class="btn btn-success btn-block">
                </div>
                <div class="col">
                    <a href="<?php echo login(); ?>" class="btn btn-info btn-block">Go back</a>
                </div>
            </div><br>
        </form>   
    </div>
  </div>   
</div>  


<?php require '../app/views/layouts/footer.php'; ?>