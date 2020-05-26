
/* REMOVE PIC MODAL */

$(document).ready(function(){
    $(document).on('click', '#removePic', function(){
        // alert($(this).data('id'));
        var picId = $(this).data('id');

        $('.modal-footer #picId').val(picId);
        //$('#remove-pic-modal').modal('toggle');
    })
});


/* DELETE PROFILE MODAL */

$(document).ready(function(){
    $(document).on('click', '#delProfile', function(){

        var userId = $(this).data('id');

        $('.modal-footer #userId').val(userId);
        //$('#delete-profile-modal').modal('toggle');
    })
});

