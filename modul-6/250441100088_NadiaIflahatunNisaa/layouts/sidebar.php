<?php
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));
?>

<div class="sidebar">

    <h3 class="text-white fw-bold mb-4">
        GlowTrack
    </h3>

    <?php if($_SESSION['role'] == 'admin') : ?>

        <a
            href="../admin/dashboard.php"
            class="<?= ($currentFolder == 'admin') ? 'active-menu' : ''; ?>"
        >
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <a
            href="../admin/skincare.php"
            class="<?= ($currentFolder == 'admin') ? 'active-menu' : ''; ?>"
        >
            <i class="bi bi-droplet-fill"></i>
            Data Skincare
        </a>

        <a
            href="../admin/users.php"
            class="<?= ($currentFolder == 'admin') ? 'active-menu' : ''; ?>"
        >
            <i class="bi bi-people-fill"></i>
            Data User
        </a>

    <?php else : ?>

        <a
            href="../user/dashboard.php"
            class="<?= ($currentFolder == 'user') ? 'active-menu' : ''; ?>"
        >
            <i class="bi bi-house-fill"></i>
            Dashboard
        </a>

        <a
            href="../user/favorit.php"
            class="<?= ($currentFolder == 'user') ? 'active-menu' : ''; ?>"
        >
            <i class="bi bi-heart-fill"></i>
            Favorit
        </a>

    <?php endif; ?>

    <a href="../auth/logout.php">

        <i class="bi bi-box-arrow-right"></i>
        Logout

    </a>

</div>