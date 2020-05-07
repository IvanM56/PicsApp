<?php require '../app/views/layouts/header.php';  ?>

<div class='ml-4 mt-3'>
    <h4>Pics by <?php echo $data['pics'][0]->username; ?></h4>
</div>

<?php foreach ($data['pics'] as $key => $pic): ?>
   
    <div class="ml-4 mt-5">
        <div class="card" style="width: 18rem;">
        <a href="../../public/assets/img/<?php echo $pic->img_name; ?>"><img class="card-img-top" src="../../public/assets/img/<?php echo $pic->img_name; ?>" alt="Card image cap"></a>
            <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <?php 
                    if(logged_in() && $pic->user_id == $_SESSION['id']): 
                ?>
                    <a href="<?php echo home()?>pics/remove_pic/<?php echo $pic->id; ?>" class="btn btn-danger">Remove</a>
                <?php else: ?>
                    <a href="#" class="btn btn-info">Can't remove</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
        
   
<?php 

endforeach; 

require '../app/views/layouts/footer.php'; 

?>





