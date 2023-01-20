<?php
if (isset($_SESSION['user'])) {
    $nav_url = $base_url . "/../";
} else {
    $nav_url = $base_url . "/";
}
?>

<!-- navigation-bar -->
<ul class="col-md-12 nav p-2 d-flex justify-content-between align-items-center">
    <li class="nav-brand">
        <a href="./">
            <img src="<?= $nav_url ?>images/SRDC-Logo.png" alt="">
        </a>
    </li>
    <!-- <?php if (isset($_SESSION['user'])) { ?>
        <li class="nav-item">
            <a class="nav-link text-maroon" href="<?= $nav_url ?>">Lessen</a>
        </li>
    <?php } ?> -->
    <?php if (isset($_SESSION['user'])) { ?>
        <li class="nav-item dropdown">
            <a class="nav-link text-maroon dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Admin</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profiel</a></li>
                <li><a class="dropdown-item" href="<?= $nav_url ?>user/register.php">Registreer nieuwe gebruiker</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="post" action="<?= $nav_url ?>logout.php">
                        <input type="submit" name="submit" class="dropdown-item" value="Uitloggen">
                    </form>
                </li>
            </ul>
        </li>
    <?php } else { ?>
        <li class="nav-item">
            <a class="nav-link btn btn-maroon" href="<?= $nav_url ?>login.php">Inloggen</a>
        </li>
    <?php } ?>
</ul>