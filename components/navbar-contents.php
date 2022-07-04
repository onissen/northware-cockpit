<?php if ($service == 'cockpit') { ?>
    <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
            <a href="http://northware-cockpit.test/" class="nav-link">Cockpit Home</a>
        </li>
        <li class="nav-item">
            <a href="http://northware-cockpit.test/cockpit/admin" class="nav-link">Administration</a>
        </li>
    </ul>
<?php } ?>

<?php if ($service == 'finance') { ?>
    <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
        </li>
        <?php if ($_SESSION['rfinance'] == 'admin') { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="stammdatenDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Stammdaten
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-align-inherit" aria-labelledby="stammdatenDropdown">
                    <li><a class="dropdown-item" href="konten.php">Kontenverwaltung</a></li>
                    <li><a class="dropdown-item" href="kostenstellen.php">Verwaltung Kostenstellen</a></li>
                </ul>
            </li>
        <?php } ?>

        <li class="nav-item">
            <a href="index.php?changeclient" class="nav-link">Mandanten wechseln</a>
        </li>
    </ul>
<?php } ?>