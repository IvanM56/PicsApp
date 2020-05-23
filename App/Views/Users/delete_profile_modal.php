<?php use App\Config; ?>

<!-- Modal -->
<div class="modal fade" id="delete-profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete profile?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="mt-2 ml-3">
                <p>You're about to delete your profile alongside with all uploaded pics! Do you really want to do it?</p>
            </div>
            <form action="<?php echo Config::ROOTURL; ?>users/delete-profile" method="POST">
                <div class="modal-footer">
                    <input type="hidden" name="userId" id="userId" value=''>
                    <input type="submit" name="submit" class="btn btn-danger" value="Delete">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Not yet</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

