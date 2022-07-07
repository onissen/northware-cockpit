<?php if (!isset($_REQUEST['mainid'])) { ?>
    <form method="post">
        <div class="row">
            <label for="select_qclass" class="col-form-label form-label col-lg-2">Kontenklasse wählen</label>
            <div class="col-lg-7">
                <select name="qclass" id="select_qclass" class="form-select">
                    <option value="" selected disabled>- wählen -</option>
                    <?php foreach ($data_ktoclass as $key) { ?>
                        <option value="<?php echo $key['classid'] ?>">
                        <?php echo $key['classid'].' / '.$key['class_name'].' / '.$key['quant_mainkto'].' Hauptkonten' ?></span></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-primary col-3">Kontenklasse wählen</button>
        </div>
    </form>
    <div class="row my-2">
        <div class="col-3">Verfügbare Hauptkonten: <?php echo $number_ktomain ?></div>
        <div class="col-3"><?php if(isset($_REQUEST['qclass'])) {echo 'Angezeigte Hauptkonten: '.count($list_ktomain);} ?></div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bezeichnung</th>
                <th>Kontenklasse</th>
                <th>Bilanzauswirkung</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5"><a href="?type=main&mainid=new" class="text-muted"><i class="fa-solid fa-square-plus"></i> Neu anlegen...</a></td>
            </tr>
            <?php if (!isset($_REQUEST['qclass'])) { ?>
                <tr>
                    <td colspan="5">Bitte wähle eine Kontenklasse</td>
                </tr>
            <?php } else{
            if (count($list_ktomain) <= 0) { ?>
                <td colspan="5">Zu dieser Kontenklasse wurden keine Hauptkonten gefunden.</td>
            <?php }
            else{
                foreach ($list_ktomain as $main) { ?>
                    <tr>
                        <td><a href="?type=main&mainid=<?php echo $main['mainid'] ?>"><?php echo $main['mainid'] ?></a></td>
                        <td><?php echo $main['main_name'] ?></td>
                        <td><?php echo $main['kto_class'].' / '.$main['class_name'] ?></td>
                        <td>
                            <?php 
                                if ($main['impact'] == 'active') {echo 'Aktivkonto';} 
                                if ($main['impact'] == 'passive') {echo 'Passivkonto';} 
                                if ($main['impact'] == 'success') {echo 'Erfolgskonto';} 
                                if ($main['impact'] == 'outlay') {echo 'Aufwandskonto';} 
                            ?>
                        </td>
                        <?php if ($_SESSION['rfinance'] == 'admin') {?> 
                            <td class="actionbar">
                                <a class="link-btn-sm link-btn-danger cursor-pointer" onclick="deleteMainKto('<?php echo $main['mainid'] ?>')" id = "test" ><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php }
            }} ?>
        </tbody>
    </table>

    <form method="post" id="form-delete">
        <input type="hidden" name="mainid_delete" id="id-delete">
        <input type="hidden" name="sub-delmain" id="submit-delete">
    </form>
<?php } elseif ($_REQUEST['mainid'] == 'new') { ?>

    <form method="post" class="mt-3">
        <div class="row">
            <label for="input-mainid" class="form-label col-form-label col-2">Kontonummer</label>
            <div class="col-5 mb-3">
                <input type="text" name="mainid" id="input-mainid" class="form-control" autocomplete="off" placeholder="0000" required>
            </div>
        </div>

        <div class="row">
            <label for="input-mname" class="form-label col-form-label col-2">Konto Bezeichnung</label>
            <div class="col-8 mb-3">
                <input type="text" name="main_name" id="input-mname" class="form-control" autocomplete="off" placeholder="Bezeichnung" required>
            </div>
        </div>

        <div class="row">
            <label for="select-mname" class="form-label col-form-label col-2">Kontenklasse</label>
            <div class="col-8 mb-3">
                <select name="kto_class" id="select_kclass" class="form-select" required>
                    <option value="" selected disabled>- wählen -</option>

                    <?php foreach ($data_ktoclass as $class) { ?>
                        <option value="<?php echo $class['classid'] ?>"><?php echo $class['classid'].' / '.$class['class_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="select-impact" class="form-label col-form-label col-2">Bilanzauswirkung</label>
            <div class="col-8">
                <select name="impact" id="select_impact" class="form-select" required>
                    <option value="" selected disabled>- wählen -</option>
                    <option value="active">Aktivkonto</option>
                    <option value="passive">Passivkonto</option>
                    <option value="success">Erfolgskonto</option>
                    <option value="outlay">Aufwandskonto</option>
                </select>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="input_higherkto" class="form-label col-form-label col-2">Übergeornete Bilanzposition</label>
            <div class="col-5"><input type="text" name="higher_kto" id="input_higherkto" class="form-control" datalist="mainkto-list"></div>
        </div>

        <button type="submit" class="btn btn-primary" name="sub-newmain">Hauptkonto anlegen</button>
    </form>

<?php } else { ?>
    <form method="post" class="mt-3">
        <div class="row">
            <label for="input-mainid" class="form-label col-form-label col-2">Kontonummer</label>
            <div class="col-5 mb-3">
                <input type="text" id="input-mainid" class="form-control" value="<?php echo $this_ktomain->mainid ?>" disabled>
            </div>
        </div>

        <div class="row">
            <label for="input-mname" class="form-label col-form-label col-2">Konto Bezeichnung</label>
            <div class="col-8 mb-3">
                <input type="text" name="main_name" id="input-mname" class="form-control" autocomplete="off" placeholder="Bezeichnung" required value="<?php echo $this_ktomain->main_name ?>">
            </div>
        </div>

        <div class="row">
            <label for="select-mname" class="form-label col-form-label col-2">Kontenklasse</label>
            <div class="col-8 mb-3">
                <select name="kto_class" id="select_kclass" class="form-select" required>
                    <option value="" disabled>- wählen -</option>

                    <?php foreach ($data_ktoclass as $class) { ?>
                        <option value="<?php echo $class['classid'] ?>" <?php if ($this_ktomain->kto_class == $class['classid']) {echo 'selected'; } ?>>
                            <?php echo $class['classid'].' / '.$class['class_name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="select-impact" class="form-label col-form-label col-2">Bilanzauswirkung</label>
            <div class="col-8">
                <select name="impact" id="select_impact" class="form-select" required>
                    <option value="" disabled <?php if($this_ktomain->impact == NULL) {echo 'selected';} ?>>- wählen -</option>
                    <option value="active" <?php if($this_ktomain->impact == 'active') {echo 'selected';} ?>>Aktivkonto</option>
                    <option value="passive" <?php if($this_ktomain->impact == 'passive') {echo 'selected';} ?>>Passivkonto</option>
                    <option value="success" <?php if($this_ktomain->impact == 'success') {echo 'selected';} ?>>Erfolgskonto</option>
                    <option value="outlay" <?php if($this_ktomain->impact == 'outlay') {echo 'selected';} ?>>Aufwandskonto</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_higherkto" class="form-label col-form-label col-2">Übergeornetes Konto</label>
            <div class="col-5"><input type="text" name="higher_kto" id="input_higherkto" class="form-control" value="<?php $this_ktomain->higher_kto ?>"></div>
        </div>

        <button type="submit" class="btn btn-primary" name="sub-editmain">Hauptkonto speichern</button>
    </form>
<?php } ?>