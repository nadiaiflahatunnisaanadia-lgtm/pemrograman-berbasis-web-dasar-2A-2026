<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold text-primary" href="#">
            GlowTrack ✨
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item me-3">

                    <span class="fw-semibold">

                        Halo,
                        <?= htmlspecialchars($_SESSION['nama']); ?>

                    </span>

                </li>

                <li class="nav-item">

                    <a
                        href="../auth/logout.php"
                        class="btn btn-danger btn-sm"
                    >
                        Logout
                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>
