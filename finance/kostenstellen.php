<?php
    $service = 'finance';
    
    if (isset($_REQUEST['id'])) {
        if ($_REQUEST['id'] == 'new') {$siteTitle = 'Neue Kostenstelle';}
        else {$siteTitle = 'Kostenstelle bearbeiten';}
    } else {$siteTitle = 'Kostenstellen';}

    require '../components/header.php';
    include 'sql/fun_kostenstellen.php';
?>



<div class="row">
    <div class="col-lg-7">
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
    <?php if (!isset($_REQUEST['id'])) {?>
        <div class="col-lg-5 text-end">
            <a href="?id=new" class="btn btn-primary" role="button">Kostenstelle anlegen</a>
            <a href="?deactivated" class="btn btn-secondary" role="button"><i class="fa-solid fa-lock"></i> Deaktivierte Kostenstellen</a>
        </div>
        <?php } ?>
</div>
<?php if (!isset($_REQUEST['id'])) {?>
    <form method="get" class="filter-list my-3">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-floating">
                    <select class="form-select" id="select-mid" aria-label="Mandant wählen" name="sq_mid">
                        <option value="" selected disabled>- wählen -</option>
                        <?php foreach ($list_clients as $clients) { ?>
                            <option value="<?php echo $clients['mid'] ?>"><?php echo $clients['mid'].' / '.$clients['cname'] ?></option>
                        <?php } ?>
                    </select>
                    <label for="select-mid">Mandanten</label>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-floating">
                    <input type="search" name="sq_pcenter" class="form-control" id="search-pcenter" placeholder="Profitcenter">
                    <label for="search-pcenter">Profitcenter</label>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-floating">
                    <input type="search" name="sq_kstid" class="form-control" id="search-kstid" placeholder="Kostenstelle">
                    <label for="search-kstid">Kostenstelle</label>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-floating">
                    <input type="search" name="sq_kstname" class="form-control" id="search-kstname" placeholder="Bezeichnung">
                    <label for="search-kstname">Bezeichnung</label>
                </div>
            </div>
            <div class="btn-group col-lg-2" role="group" aria-label="Basic example">
                <button type="submit" class=" btn btn-outline-primary" name="sub_search"><i class="bi bi-search"></i></button>
                <button type="submit" class="btn btn-outline-primary" name="clear"><i class="bi bi-x-circle"></i></button>
            </div>
        </div>
    </form>
    
    <p class="display-results">
       <?php 
            echo 'Die Suche ergab <b>'.count($data_list).'</b> Ergebinsse.';
        ?>
    </p>
    <table class="table table-striped" data-filter-control="true" data-show-search-clear-button="true" id="table-kst">
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
                    <td><?php echo $list['mid']?></td>
                    <td><?php echo $list['profitcenter'] ?></td>
                    <td><a href="?id=<?php echo $list['kstid'] ?>">
                        <?php 
                            echo $list['kstid'];
                            if (!is_null($list['deactivated'])) { ?><i class="text-muted ms-1 fa-solid fa-lock"></i><?php } ?>
                    </a></td>
                    <td><?php echo $list['kst_name'] ?></td>
                </tr>
            <?php } ?>

            <?php if(count($data_list) <=0){ ?>
                <tr>
                    <td colspan="4">Keine Einträge gefunden</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }
else { ?>
    <?php if (isset($Alert)) { ?>
        <div class="alert alert-<?php echo $AlertTheme ?> alert-dismissible fade show" role="alert">
            <?php echo $Alert ?>
            <a href="kostenstellen.php?id=<?php echo $_REQUEST['id']; ?>" class="btn-close" role="button" aria-label="Close"></a>
        </div>
    <?php } ?>

    <?php if($_REQUEST['id'] == 'new'){ // Neue Kostenstelle ?>
    <form method="post" class="mt-3">
        <div class="row mb-3">
            <label for="select-mid" class="col-form-label form-label col-lg-2">Mandant</label>
            <div class="col-lg-5">
                <select name="mid" id="select-mid" class="form-select" required>
                    <option value="" disabled selected>- auswählen -</option>
                    <?php foreach ($list_clients as $client) { ?>
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
                    <?php foreach ($list_clients as $client) { ?>
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
                <input type="text" id="input-kstid" class="form-control" value="<?php echo $kst->kstid ?>" disabled>
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
                <input type="date" name="deactivated" id="input-deactivated" class="form-control" value="<?php echo $kst->deactivated ?>" placeholder="TT.MM.JJJJ">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="submit-edit-kst">Kostenstelle speichern</button>
    </form>
<?php }} ?>

<?php require '../components/footer.php' ?>