<?php require '../app/views/layouts/header.php'; ?>


<div class="ml-5 mt-4"> 
    <div class="row">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="upload">Upload new pic</label>
                <input type="file" class="form-control-file form-control-sm 
                <?php echo(!empty($data['pic_error'])) ? 'is-invalid' : ''; ?>" name="pic" id="pic">
                <span class="invalid-feedback"><?php echo $data['pic_error']; ?></span>
                <br>
                <!-- <button name="upload" class="form-control btn btn-sm btn-primary">Upload</button> -->
                <input type="submit" class="form-control btn btn-info" name="upload" value="Upload">
            </div>
        </form>
    </div>      
</div>
    
<?php require '../app/views/layouts/footer.php'; ?>

