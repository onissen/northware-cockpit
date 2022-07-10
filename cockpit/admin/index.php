<?php
    $service = "cockpit";
    $siteTitle = 'Administration';
    require "../../components/header.php";
?>

<a class="app-link" href="./pwstack" target="_blank">
    <div class="app-item tile-cockpit d-inline-block">
        <div class="title">PWStack</div>
    </div>
</a>

<a href="users.php">Alle Benutzer</a>
<a href="user-new.php">Neuer Benutzer</a>

<?php require "../../components/footer.php" ?>