<?php
    $service = 'finance';
    $siteTitle = 'Kostenstellen';
    require '../components/header.php';
?>

<?php
    $sql_list = "SELECT * FROM kostenstellen WHERE deactivated IS NULL OR deactivated='' ORDER BY kstid";
    $data_kst = $db_finance->query($sql_list)->fetchAll();

    $sql_clients = "SELECT mid, cname FROM clients ORDER BY mid";
    $data_clients = $db_cockpit->query($sql_clients)->fetchAll();

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

<?php if (!isset($_REQUEST['id']) OR $_REQUEST['id'] = '') {?>
    <div class="row">
        <div class="col-10"><h1>Kostenstellen</h1></div>
        <div class="col-2"><a href="?id=new" class="btn btn-primary" role="button">Kostenstelle anlegen</a></div>
    </div>

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
            <?php foreach ($data_kst as $kst) { ?>
                <tr>
                    <td><?php echo $kst['mid'] ?></td>
                    <td><?php echo $kst['profitcenter'] ?></td>
                    <td><a href="?id=<?php echo $kst['kstid'] ?>"><?php echo $kst['kstid'] ?></a></td>
                    <td><?php echo $kst['kst_name'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }
elseif ($_REQUEST['id'] = 'new') { ?>

    <h1>Kostenstellen</h1>
    <h3>Neue Kostenstelle anlegen</h3>

    <?php if (isset($Alert)) { ?>
        <div class="alert alert-<?php echo $AlertTheme ?> alert-dismissible fade show" role="alert">
            <?php echo $Alert ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <form class="mt-3 needs-validation" novalidate method="post">
        <div class="row mb-3">
            <label for="select-mid" class="col-form-label form-label col-2">Mandant</label>
            <div class="col-5">
                <select name="mid" id="select-mid" class="form-select" required>
                    <option value="" disabled selected>- auswählen -</option>
                    <?php foreach ($data_clients as $client) { ?>
                        <option value="<?php echo $client['mid'] ?>"><?php echo $client['mid'].' / '.$client['cname'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">Der Mandant ist ein Pflichtfeld</div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-kstid" class="form-label col-form-label col-2">Kst-ID</label>
            <div class="col-5">
                <input type="text" name="kstid" id="input-kstid" class="form-control" placeholder="00000" required>
                <div class="invalid-feedback">Bitte vergebe eine gültige Kostenstellen-ID</div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-kstname" class="form-label col-form-label col-2">Kst-Bezeichnung</label>
            <div class="col-5">
                <input type="text" name="kst_name" id="input-kstname" class="form-control" required>
                <div class="invalid-feedback">Bitte gebe der Kostenstelle einen Namen</div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input-activated" class="form-label col-form-label col-2">Aktiviert</label>
            <div class="col-5">
                <input type="date" name="activated" id="input-activated" class="form-control" value="<?php echo date('Y-m-d') ?>" placeholder="TT.MM.JJJJ" required>
                <div class="invalid-feedback">Das Datum der Aktivierung ist ein Pflichtfeld.</div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary" name="submit-new-kst">Neue Kostenstelle anlegen</button>
    </form>

<?php } ?>

<?php require '../components/footer.php' ?>