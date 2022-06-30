<?php
    $service = 'finance';
    
    if (isset($_REQUEST['id'])) {
        if ($_REQUEST['id'] == 'new') {$siteTitle = 'Neue Kostenstelle';}
        else {$siteTitle = 'Kostenstelle bearbeiten';}
    } else {$siteTitle = 'Kostenstellen';}

    require '../components/header.php';
?>

<?php
    // Liste Kostenstellen
    $sql_list = "SELECT * FROM kostenstellen WHERE deactivated IS NULL OR deactivated='' ORDER BY kstid";
    $data_list = $db_finance->query($sql_list)->fetchAll();

    // Mandanten
    $sql_clients = "SELECT mid, cname FROM clients ORDER BY mid";
    $data_clients = $db_cockpit->query($sql_clients)->fetchAll();

    if (isset($_REQUEST['id']) AND $_REQUEST['id'] != 'new') {
        $id = $_REQUEST['id'];
        $sql = "SELECT * FROM kostenstellen WHERE kstid = $id";
        $kst = $db_finance->query($sql)->fetchObject();
    }

    // Neue Kostenstelle
    if (isset($_POST['submit-new-kst'])) {
        $mid = $_POST['mid'];
        $kstid = intval($_POST['kstid']);
        $kst_name = $_POST['kst_name'];
        $activated = $_POST['activated'];

        $stmt = $db_finance->prepare("SELECT * FROM kostenstellen WHERE kstid = :kstid");
        $stmt->bindParam(":kstid", $kstid);
        $stmt->execute();

        $rowExists = $stmt->fetchColumn();

        if (!$rowExists) {
            $sql = $db_finance->prepare("INSERT INTO kostenstellen (mid, kstid, kst_name, activated) VALUES (:mid, :kstid, :kst_name, :activated)");
            $sql->bindParam(':mid', $mid);
            $sql->bindParam(':kstid', $kstid);
            $sql->bindParam(':kst_name', $kst_name);
            $sql->bindParam(':activated', $activated);
            if ($sql->execute()) {
                $Alert = 'Die Kostenstelle '.$kstid.' (M'.$mid.': '.$kst_name.')'.' wurde angelegt';
                $AlertTheme = 'success';
            }
        } else {
            $Alert = 'Diese Kostenstelle existiert bereits.';
            $AlertTheme = 'danger';
        }
    }
?>


<div class="row">
    <div class="col-lg-10">
        <h2>
            <ol class="breadcrumb">
                <?php if (!isset($_REQUEST['id'])) { ?> <li class="breadcrumb-item active">Kostenstellen</li> <?php }
                else { ?><li class="breadcrumb-item"><a href="kostenstellen.php">Kostenstellen</a></li><?php } ?>

                <?php if (isset($_REQUEST['id'])) {
                    if ($_REQUEST['id'] == 'new') { ?> <li class="breadcrumb-item active">Neue Kostenstelle</li> <?php }
                    else { ?> <li class="breadcrumb-item active">Kostenstelle <?php echo $_REQUEST['id'] ?></li> <?php } } ?>
            </ol>
        </h2>
    </div>
    <?php if (!isset($_REQUEST['id'])) {?><div class="col-lg-2"><a href="?id=new" class="btn btn-primary" role="button">Kostenstelle anlegen</a></div><?php } ?>
</div>
<?php if (!isset($_REQUEST['id'])) {?>
    <form method="get" class="filter-list my-3 mx-auto">
        <div class="row">
            <div class="col-lg-2 px-1">
                <select name="search" id="scolumn" class="form-select">
                    <option value="client" class="selopt" id="sclient">Mandant</option>
                    <option value="profitcenter" class="selopt" id="spcenter">Profitcenter</option>
                    <option value="kstid" class="selopt" id="skstid" selected>Kostenstelle</option>
                    <option value="kst_name" class="selopt" id="kst_name">Bezeichnung</option>
                </select>
            </div>
            <div class="col-lg-5 px-1">
                <input type="text" class="form-control" id="input-query" name="squery" placeholder="Suchbegriff">
            </div>
            <button type="submit" class="col-lg-2 btn btn-outline-primary me-1" id="send-squery">Suchen</button>
            <a href="kostenstellen.php" class="col-lg-2 btn btn-outline-secondary" role="button">Filter zurücksetzen</a>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mandant</th>
                <th>Profitcenter</th>
                <th>Kostenstelle</th>
                <th>Bezeichnung</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_list as $list) { ?>
                <tr>
                    <td><?php echo $list['mid'] ?></td>
                    <td><?php echo $list['profitcenter'] ?></td>
                    <td><a href="?id=<?php echo $list['kstid'] ?>"><?php echo $list['kstid'] ?></a></td>
                    <td><?php echo $list['kst_name'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }
else {
    if($_REQUEST['id'] == 'new'){ // Neue Kostenstelle ?>
    <?php if (isset($Alert)) { ?>
        <div class="alert alert-<?php echo $AlertTheme ?> alert-dismissible fade show" role="alert">
            <?php echo $Alert ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <form method="post" class="mt-3">
        <div class="row mb-3">
            <label for="select-mid" class="col-form-label form-label col-lg-2">Mandant</label>
            <div class="col-lg-5">
                <select name="mid" id="select-mid" class="form-select" required>
                    <option value="" disabled selected>- auswählen -</option>
                    <?php foreach ($data_clients as $client) { ?>
                        <option value="<?php echo $client['mid'] ?>"><?php echo $client['mid'].' / '.$client['cname'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-kstid" class="form-label col-form-label col-lg-2">Kst-ID</label>
            <div class="col-lg-5">
                <input type="text" name="kstid" id="input-kstid" class="form-control" placeholder="00000" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-kstname" class="form-label col-form-label col-lg-2">Kst-Bezeichnung</label>
            <div class="col-lg-5">
                <input type="text" name="kst_name" id="input-kstname" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-activated" class="form-label col-form-label col-lg-2">Aktiviert</label>
            <div class="col-lg-5">
                <input type="date" name="activated" id="input-activated" class="form-control" value="<?php echo date('Y-m-d') ?>" placeholder="TT.MM.JJJJ" required>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit-new-kst">Neue Kostenstelle anlegen</button>
    </form>

<?php }  else { // Kostenstelle bearbeiten ?>
    <form method="post" class="mt-3">
        <div class="row mb-3">
            <label for="select-mid" class="col-form-label form-label col-lg-2">Mandant</label>
            <div class="col-lg-5">
                <select name="mid" id="select-mid" class="form-select" required>
                    <option value="" disabled>- auswählen -</option>
                    <?php foreach ($data_clients as $client) { ?>
                        <option value="<?php echo $client['mid'] ?>"<?php if($kst->mid == $client['mid']){echo 'selected';} ?>>
                            <?php echo $client['mid'].' / '.$client['cname'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-kstid" class="form-label col-form-label col-lg-2">Kst-ID</label>
            <div class="col-lg-5">
                <input type="text" name="kstid" id="input-kstid" class="form-control" placeholder="00000" required value="<?php echo $kst->kstid ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-kstname" class="form-label col-form-label col-lg-2">Kst-Bezeichnung</label>
            <div class="col-lg-5">
                <input type="text" name="kst_name" id="input-kstname" class="form-control" required value="<?php echo $kst->kst_name ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-activated" class="form-label col-form-label col-lg-2">Aktiviert</label>
            <div class="col-lg-5">
                <input type="date" name="activated" id="input-activated" class="form-control" value="<?php echo $kst->activated ?>" placeholder="TT.MM.JJJJ" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-deactivated" class="form-label col-form-label col-lg-2">Deaktiviert</label>
            <div class="col-lg-5">
                <input type="date" name="deactivated" id="input-deactivated" class="form-control" value="<?php echo $kst->deactivated ?>" placeholder="TT.MM.JJJJ" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="submit-new-kst">Kostenstelle speichern</button>
    </form>
<?php }} ?>

<?php require '../components/footer.php' ?>