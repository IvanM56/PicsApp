

<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <a class="navbar-brand ml-3" href="<?php echo home(); ?>">PicsApp</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Left side of the navbar -->
    <div class="container">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo home(); ?>">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>
    <!-- Right side of the navbar -->
      <ul class="navbar-nav ml-auto">
      <?php if(!isset($_SESSION['id'])) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo register(); ?>">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo login(); ?>">Login</a>
        </li> 
      <?php else : ?>
        <li class="nav-item mr-2">
          <img class="rounded-circle" src="<?php echo STORAGE; ?>img/profile_pics/<?php echo $_SESSION['profile_img']; ?>" width="40" height="40">
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo home(); ?>users/edit_profile/<?php echo $_SESSION['id']; ?>"><?php echo $_SESSION['username']; ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo home(); ?>pics/add_pic">Add new pic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo logout(); ?>">Logout</a>
        </li>
      <?php endif; ?>
      </ul>  
    </div>
  </div>
</nav>





