<?php use App\Config; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <a class="navbar-brand ml-3" href="<?php echo Config::ROOTURL; ?>">PicsApp</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span> 
    </button>
    <!-- Left side of the navbar -->
    <div class="container">
    <div class="collapse navbar-collapse" id="navbarNav"> 
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Config::ROOTURL; ?>">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>
    <!-- Right side of the navbar -->
      <ul class="navbar-nav ml-auto">
      <?php if(!isset($_SESSION['id'])) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Config::ROOTURL; ?>users/register">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Config::ROOTURL; ?>users/login">Login</a>
        </li> 
      <?php else : ?>
        <li class="nav-item mr-3">
          <img class="rounded-circle" src="<?php echo Config::STORAGE; ?>profile_pics/<?php echo $_SESSION['profile_img']; ?>" width="40" height="40">
        </li>

        <li class="dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button">
            <span class="glyphicon glyphicon-user"><?php echo $_SESSION['username']; ?></span>
            <span class="carret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-item"> <a href="<?php echo Config::ROOTURL; ?>users/profile/<?php echo $_SESSION['id']; ?>">View profile</a> </li>
            <li class="dropdown-item"> <a href="<?php echo Config::ROOTURL; ?>pics/add-pic">Add new pic</a> </li>
            <li class="dropdown-item"> <a href="<?php echo Config::ROOTURL; ?>users/edit-profile/<?php echo $_SESSION['id']; ?>">Edit profile</a> </li>
            <li class="dropdown-item"> <a href="<?php echo Config::ROOTURL; ?>users/logout">Logout</a> </li>
          </ul>
        </li>

      <?php endif; ?>
      </ul>  
    </div>
  </div>
</nav>





