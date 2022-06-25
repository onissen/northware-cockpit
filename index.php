<?php 
    $service = 'cockpit';
    require 'components/header.php';
?>

<div class="my-5">
    <?php
        if (isset($_SESSION['username'])) {
            echo 'gesetzt';
        } else {
            echo 'nicht gesetzt';
        }
    ?>
</div>

<?php require 'components/footer.php' ?>