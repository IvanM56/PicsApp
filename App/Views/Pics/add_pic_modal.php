<?php use App\Config; ?>

<!-- Modal -->
<div class="modal fade" id="add-pic-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new pic</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <div class="mt-2 ml-3">
                <p>Only .jpg and .png. formats allowed!</p>
            </div>
            <form action="<?php echo Config::ROOTURL; ?>pics/add-pic" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <!-- <label for="upload">Upload new pic</label> -->
                <input type="file" class="form-control-file form-control-sm 
                <?php echo(!empty($data['pic_error'])) ? 'is-invalid' : ''; ?>" name="pic" id="pic">
                <span class="invalid-feedback"><?php echo $data['pic_error']; ?></span>
                <br>
                <input type="submit" class="form-control btn btn-info" name="upload" value="Upload">
            </div>
        </form>
        </div>
    </div>
    </div>
</div>