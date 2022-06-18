<?php include 'service-variables.php';?>

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
    
    <title><?php if (isset($siteTitle)) {echo $siteTitle.' | ';} echo $service_brand ?></title>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-md mb-4 fixed-top bg-<?php echo $service ?>">
        <div class="container-fluid">
            <a href="http://northware-cockpit.test/" class="navbar-brand"><?php echo $service_brand ?></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Test</a>
                    </li>
                </ul>
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item dropdown text-end">
                        <a href="#" class="dropdown-toggle nav-link" id="toggle-account" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-right dropdown-menu-dark" aria-labelledby="toggle-account" data-popper-placement="bottom-end">
                            <form action="index.php?logout" method="post">
                                <input type="hidden" name="action" value="logmeout">
                                <button type="submit" class="btn btn-link">Abmelden</button>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>