<?php
    $service = 'cockpit';
    $siteTitle = 'Benutzer';
    require('../../components/header.php');
?>

<?php
    $sql = 'SELECT * FROM users ORDER BY id';
    $data = $db_cockpit->query($sql)->fetchAll();
?>

<div class="row">
    <div class="col-10"><h1>Benutzer</h1></div>
    <div class="col-2">
        <a href="user-new.php" class="btn btn-primary" role="button">Neuer Benutzer</a>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Benutzername</th>
            <th>Typ</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user) { ?>
            <tr>
                <td><a href="user-edit.php?id=<?php echo $user['id'] ?>"><?php echo $user['name'] ?></a></td>
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['type'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php require('../../components/footer.php'); ?>