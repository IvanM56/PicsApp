<?php 

require '../app/views/layouts/header.php'; 

foreach ($data['pics'] as $key => $pic) : 

?>



<div class="ml-4 mt-3">
    <div class="card" style="width: 18rem;">
    <a href="assets/img/<?php echo $pic->img_name; ?>"><img class="card-img-top" src="assets/img/<?php echo $pic->img_name; ?>" alt="Card image cap" width="" height=""></a>
        <div class="card-body">
            <h5 class="card-title"><a href="<?php echo home() ?>pics/user_pics/<?php echo $pic->user_id; ?>"><?php echo $pic->username; ?></a></h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>      
            <?php 
                if(logged_in() && $pic->user_id == $_SESSION['id']): 
            ?>
                <a href="<?php echo home()?>pics/remove_pic/<?php echo $pic->id; ?>" class="btn btn-danger">Remove</a>
            <?php else: ?>
                <a href="" class="btn btn-info">Can't remove</a>
            <?php endif; ?>   
                <a href="<?php echo home() ?>users/profile/<?php echo $pic->user_id ?>"><img class="rounded-circle" style="float:right" src="<?php echo STORAGE; ?>img/profile_pics/<?php echo $pic->profile_img; ?>" width="40" height="40"></a>
        </div>
    </div>
</div>



<?php 

endforeach; 

require '../app/views/layouts/footer.php'; 

?>







