<?php
    require '../../../components/service-variables.php';

    // if (!isset($noredirect) OR $noredirect!= true AND isset($_POST['action'])) {
    //     if ($_POST['action'] == 'logout') {
    //         unset($_SESSION['username']);
    //         unset($_SESSION['name']);
    //         unset($_SESSION['rcockpit']);
    //         unset($_SESSION['rfinance']);
    //         unset($_SESSION['rhures']);
    //         unset($_SESSION['rtrader']);
    //         unset($_SESSION['client']);
    //         header('Location: http://northware-cockpit.test/login.php?logout');
    //     } 
    //     elseif (!isset($_SESSION['username'])) {
    //         header('Location: http://northware-cockpit.test/login.php');
    //     }    
    // }
    // include 'clients.php';
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
    <link rel="shortcut icon" href="http://northware-cockpit.test/utilities/logos/favicon-<?php echo $service ?>.svg" type="image/x-icon">
    <link rel="stylesheet" href="http://northware-cockpit.test/css/main.css">
    <link rel="stylesheet" href="http://northware-cockpit.test/css/<?php echo $service ?>.css">
    
    <title><?php if (isset($siteTitle)) {echo $siteTitle.' | ';} echo $service_brand ?></title>
</head>