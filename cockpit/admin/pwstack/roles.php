<?php 
    $service = 'cockpit';
    $siteTitle = 'Rollenverwaltung | PWStack';
    $no_body = true;
    $noredirect = true;
    require '../../../components/header.php';
?>
<?php
    if (isset($_REQUEST['new_user'])) {
        $Alert = 'Der neue Benutzer '.$_REQUEST['new_user'].' wurde gespeichert.<br>';
        $Alert .= 'Bitte wählen Sie nun die Rollen des Benutzers aus.';
        $AlertTheme = 'success';
    }
?>
<?php

    if (isset($_REQUEST['new_user'])) {
        $mode = 'new';
        $username = $_REQUEST['new_user'];
    };

    if (isset($_REQUEST['edit_user'])) {
        $mode = 'edit';
        $username = $_REQUEST['edit_user'];
    }
    $user = $db_pws->query("SELECT id FROM pws_users WHERE username = '{$username}'")->fetch_object();
    $uid = $user->id;

    if ($mode == 'edit') {
        $role = $db_pws->query("SELECT * FROM pws_userroles WHERE user_id = {$uid}")->fetch_array(MYSQLI_ASSOC);

        if (isset($_POST['submit_role'])) {
            $role_nwcockpit = $_POST['role_nwcockpit'];
            $role_nwtrader = $_POST['role_nwtrader'];

            $sql = $db_pws->prepare("UPDATE pws_userroles SET role_nwcockpit=?, role_nwtrader=? WHERE user_id = $uid");
            $sql->bind_param('ss', $role_nwcockpit, $role_nwtrader);

            if ($sql->execute()) {
                $Alert = 'Die Rollen vom Benutzer '.$username.' wurden verändert.';
                $AlertTheme = 'success';
            }
        }
    }
?>

<?php
    $item = array();

    function CreateList() {
        global $app;
        global $db_pws;
        global $item;
        $sql = "SELECT * FROM pws_roles WHERE service = '$app' ORDER BY id";
        $result = $db_pws->query($sql);

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $item[$app][] = $row;
        }
    }
?>

<?php 
    function PrintRoleList() { 
        global $app;
        global $appRow;
        global $AppTitle;
        global $item;
        global $mode;
        global $role;
    
        if ($mode == 'new') { ?>
            <label for="Select-<?php echo $app ?>" class="form-label label-role"><?php echo $AppTitle ?></label>
            <select name="<?php echo $appRow ?>" id="Select-<?php echo $app ?>" class="form-select">
                <option value="" selected>- keine -</option>
                <?php foreach ($item[$app] as $roleList) { ?>
                    <option value="<?php echo $roleList['role'] ?>"><?php echo $roleList['role_name'] ?></option>
                <?php } ?>
            </select>
        <?php }

        if ($mode == 'edit') { ?>
            <label for="Select-<?php echo $app ?>" class="form-label label-role"><?php echo $AppTitle ?></label>
            <select name="<?php echo $appRow ?>" id="Select-<?php echo $app ?>" class="form-select">
                <option value="">- keine -</option>
                <?php foreach ($item[$app] as $roleList) { ?>
                    <option <?php if ($role[$appRow] == $roleList['role']) {echo 'selected';} ?>
                    value="<?php echo $roleList['role'] ?>"><?php echo $roleList['role_name'] ?></option>
                <?php } ?>
            </select>
        <?php }
    
    } ?>

<body>
    <main class="container-lg wrapper">
        <h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">PWStack</a></li>
                <li class="breadcrumb-item text-primary">Rollenverwaltung</li>
                <?php if(isset($_REQUEST['new_user'])) { ?><li class="breadcrumb-item active">Benutzer <?php echo $_REQUEST['new_user'] ?></li>
                <?php } elseif(isset($_REQUEST['edit_user'])) { ?> <li class="breadcrumb-item active">Benutzer <?php echo $_REQUEST['edit_user'] ?> <?php } ?>
            </ol>
        </h2>
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?> alert-dismissible fade show" role="alert">
                <?php echo $Alert ?>
                <?php if(!isset($_POST)) { ?><button class="btn-close" type="button" aria-label="Schliessen" data-bs-dismiss="alert"></a> <?php } ?>
                <?php if (isset($_POST['submit_role'])) {
                    if ($mode == 'new') { ?> <a href="?new_user=<?php echo $username ?>" class="btn-close" role="button"></a> <?php }
                    if ($mode == 'edit') { ?> <a href="?edit_user=<?php echo $username ?>" class="btn-close" role="button" aria-label="close"></a> <?php }} ?>
            </div>
        <?php } ?>
        

        <form method="post" id="Form-UserRoles">
            <div class="row my-3">
                <div class="col-lg col-md">
                    <?php 
                        $app = 'nw_cockpit';
                        $appRow = 'role_nwcockpit';
                        $AppTitle = 'Northware Cockpit';
                        CreateList();
                        PrintRoleList();
                    ?>
                </div>

                <div class="col-lg col-md">
                    <?php 
                        $app = 'nw_trader';
                        $AppTitle = 'Northware Trader';
                        $appRow = 'role_nwtrader';
                        CreateList();
                        PrintRoleList();
                    ?>
                </div>

            </div>
            <button type="submit" class="btn btn-primary" name="submit_role"><i class="bi bi-check-lg"></i> Rollen vergeben</button>
        </form>
    </main>
</body>

<?php require '../../../components/footer.php'; ?>

