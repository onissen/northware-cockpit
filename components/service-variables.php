<?php
    $tage = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
    $day = date('w');

    if ($service == 'cockpit') {
        $service_brand = 'Northware Cockpit';
        $service_navtheme = 'navbar-dark';
    }
    
    
    if ($service == 'errors') {
        $service_brand = 'Northware Suite';
        $service_navtheme = 'navbar-dark';
    }
    
    if ($service == 'finance') {
        $service_brand = 'Northware Finance';
        $service_navtheme = 'navbar-dark';
        
        if (!isset($noredirect) OR $noredirect!=true) {
            if (!isset($_SESSION['client'])) {
                header('Location: index.php');
            }
        }
    }

?>