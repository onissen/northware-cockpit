<?php
    require 'service-variables.php';
    require 'connection.php';

    if (!isset($noredirect) OR $noredirect!= true AND isset($_POST['action'])) {
        if ($_POST['action'] == 'logout') {
            unset($_SESSION['username']);
            unset($_SESSION['name']);
            header('Location: http://northware-cockpit.test/login.php?logout');
        } 
        elseif (!isset($_SESSION['username'])) {
            header('Location: http://northware-cockpit.test/login.php');
        }    
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="http://northware-cockpit.test/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://northware-cockpit.test/utilities/fontawesome/css/all.css">
    <link rel="stylesheet" href="http://northware-cockpit.test/utilities/bootstrap-icons/bootstrap-icons.css">
    <link rel="shortcut icon" href="http://northware-cockpit.test/utilities/favicon-<?php echo $service ?>.png" type="image/x-icon">
    <link rel="stylesheet" href="http://northware-cockpit.test/css/main.css">
    <link rel="stylesheet" href="http://northware-cockpit.test/css/<?php echo $service ?>.css">
    <script src="http://northware-cockpit.test/js/main.js"></script>
    
    <title><?php if (isset($siteTitle)) {echo $siteTitle.' | ';} echo $service_brand ?></title>
</head>
<?php if (!isset($no_body) OR $no_body != true) {?>
<body>
    <nav class="navbar <?php echo $service_navtheme ?> navbar-expand-md mb-4 fixed-top bg-<?php echo $service ?>">
        <div class="container-fluid shadow">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle nav-link" id="appbox-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-grid-fill"></i>
                </a>
                    <div id="appbox" class="dropdown-menu dropdow-align-left shadow-sm" aria-labelledby="dropdownMenuLink">
                        <a href="http://northware-cockpit.test/">
                            <div class="app-tile tile-cockpit">
                                <i class="fa-app fa-solid fa-briefcase"></i>
                                <div class="title">Northware Cockpit</div>
                            </div>
                        </a>
                        <a href="http://northware-cockpit.test/finance">
                            <div class="app-tile tile-finance">
                                <i class="fa-app fa-solid fa-file-invoice-dollar"></i>
                                <div class="title">Northware Finance</div>
                            </div>
                        </a>
                        <a href="http://northware-cockpit.test/hures">
                            <div class="app-tile tile-hures">
                                <i class="fa-app fa-solid fa-people-group"></i>
                                <div class="title">Northware HuRes</div>
                            </div>
                        </a>
                        <a href="http://northware-cockpit.test/trader">
                            <div class="app-tile tile-trader">
                                <i class="fa-app fa-solid fa-dolly"></i>
                                <div class="title">Northware Trader</div>
                            </div>
                        </a>
                    </div>
                </div>
                <a href="http://northware-cockpit.test/<?php if ($service!='cockpit') {echo $service;} ?>" class="navbar-brand"><?php echo $service_brand ?></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <?php include 'navbar-contents.php' ?>
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item"><span class="nav-link nav-timestamp"><?php echo $tage[$day].', '.date('d.m.Y H:i').' Uhr'?></span></li>

                    <li class="nav-item dropdown text-end">
                        <a href="#" class="dropdown-toggle nav-link" id="toggle-account" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user me-1"></i> <?php echo $_SESSION['name'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-align-right dropdown-menu-dark shadow-sm" aria-labelledby="toggle-account" data-popper-placement="bottom-end">
                            <li><a href="#" class="dropdown-item disabled"><?php echo $_SESSION['name'] ?></a>
                            </li>
                            <form method="post">
                                <input type="hidden" name="action" value="logout">
                                <button type="submit" class="dropdown-item"><i class="fa-solid fa-arrow-right-from-bracket"></i> Abmelden</button>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container-lg wrapper">
<?php } ?>