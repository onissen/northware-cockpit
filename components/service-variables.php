<?php
    $tage = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
    $day = date('w');

    if ($service == 'cockpit') {
        $service_brand = 'Northware Cockpit';
        $service_navtheme = 'navbar-dark';
    }

    if ($service == 'financials') {
        $service_brand = 'Northware Financials';
    }

?>