<?php use App\Config; ?>

<!-- Modal -->
<div class="modal fade" id="remove-pic-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete pic?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="mt-2 ml-3">
                <p>Do you really want to delete this pic?</p>
            </div>
            <form action="<?php echo Config::ROOTURL; ?>pics/remove-pic" method="POST">
                <div class="modal-footer">
                    <input type="hidden" name="picId" id="picId" value=''>
                    <input type="submit" name="submit" class="btn btn-danger" value="Remove">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Not yet</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

