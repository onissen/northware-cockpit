<?php
    if (isset($_SESSION['client'])) {
        $mid = $_SESSION['client'];
        
        $sql_fullClient = "SELECT * FROM clients WHERE mid = $mid";
        $fullClient = $db_cockpit->query($sql_fullClient)->fetchObject();

        $sql_clist = "SELECT mid, cname FROM clients ORDER BY mid";
        $list_clients = $db_cockpit->query($sql_clist)->fetchAll();
    }
?>