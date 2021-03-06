<?php use App\Config; ?>

<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
    <ul class="nav flex-column">
        <li class="nav-item">
        <a class="nav-link mt-4" href="#">
            <span data-feather="home"></span>
            Dashboard <span class="sr-only">(current)</span>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">
            <span data-feather="file"></span>
            Orders
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">
            <span data-feather="shopping-cart"></span>
            Products
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">
            <span data-feather="users"></span>
            Customers
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">
            <span data-feather="bar-chart-2"></span>
            Reports
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">
            <span data-feather="layers"></span>
            Integrations
        </a>
        </li>
    </ul>
    <br>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo Config::ROOTURL; ?>users/index">Users</a>
        </li>
    </ul>
    </div>
</nav>