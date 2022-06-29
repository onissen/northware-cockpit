<?php
    $mid = $_SESSION['client'];
    
    $sql_client = "SELECT * FROM clients WHERE mid = $mid";
    $data_client = $db_cockpit->query($sql_client)->fetchObject();
?>