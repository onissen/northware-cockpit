<?php
    $service = 'finance';
    require '../components/header.php';
    include 'sql/clients.php';
?>

<h1>Mandant:  <?php echo $data_client->mid.' / '.$data_client->cname ?></h1>



<?php require '../components/footer.php'; ?>