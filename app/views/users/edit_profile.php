<?php 

require '../app/views/layouts/header.php'; 


?>

<div class="row">
  <div class="col-md-12 ml-5">
    <div class="card card-body bg-light mt-5">
        <h2>Change your data</h2><br>
        <div class="media">
            <img class="rounded-circle" src="<?php echo STORAGE; ?>img/profile_pics/<?php echo ($data['profile_img'] != 'default.jpg') ? $data['profile_img'] : 'default.jpg'; ?>" width="200" height="200">
        </div><br>
        <form action="<?php echo home() ?>users/edit_profile/<?php echo $data['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">
            <div class="form-group">
                <input type="file" class="form-control-file form-control-sm 
                <?php echo(!empty($data['profile_img_error'])) ? 'is-invalid' : ''; ?>" name="upd_profile_pic" id="upd_profile_pic">
                <span class="invalid-feedback"><?php echo $data['profile_img_error']; ?></span>
            </div>
            <div class="form-group">
                <label for="username">Userame: <sup>*</sup></label>
                <input type="text" name="username" class="form-control form-control-lg 
                <?php echo(!empty($data['username_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                <span class="invalid-feedback"><?php echo $data['username_error']; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg 
                <?php echo(!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
            </div>
            <div class="row">
                <div class="col">
                    <input type="submit" name="submit" value="Update" class="btn btn-success btn-block">
                </div>
                <div class="col">
                    <a href="<?php echo home(); ?>users/delete_profile/<?php echo $data['id']; ?>" class="btn btn-danger btn-block">Delete profile?</a>
                </div>
            </div>
        </form>
    </div>
  </div>   
</div>  

<?php 

require '../app/views/layouts/footer.php'; 

?>

