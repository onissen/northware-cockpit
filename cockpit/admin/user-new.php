<?php
    $service = "cockpit";
    $siteTitle = 'Neuer Benutzer';
    require "../../components/header.php";
?>

<?php
    $sql_role_cp = "SELECT * FROM user_roles WHERE service = 'cockpit' ORDER BY id";
    $row_cp = $db_cockpit->query($sql_role_cp)->fetchAll();
    
    $sql_role_fin = "SELECT * FROM user_roles WHERE service = 'finance' ORDER BY id";
    $row_fin = $db_cockpit->query($sql_role_fin)->fetchAll();

    $sql_role_hr = "SELECT * FROM user_roles WHERE service = 'hures' ORDER BY id";
    $row_hr = $db_cockpit->query($sql_role_hr)->fetchAll();

    $sql_role_td = "SELECT * FROM user_roles WHERE service = 'trader' ORDER BY id";
    $row_td = $db_cockpit->query($sql_role_td)->fetchAll();



    if (isset($_POST['submit-btn'])) {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $password = PASSWORD_HASH($_POST['password'], PASSWORD_DEFAULT);
        $type = $_POST['type'];
        $role_cockpit = $_POST['role_cockpit'];
        $role_finance = $_POST['role_finance'];
        $role_hures = $_POST['role_hures'];
        $role_trader = $_POST['role_trader'];

        $stmt = $db_cockpit->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $userExists = $stmt->fetchColumn();

        function registerUser($username, $name, $password, $type, $role_cockpit, $role_finance, $role_hures, $role_trader){
            global $db_cockpit;
            $stmt_insert = $db_cockpit->prepare("INSERT INTO users(username, name, password, type, role_cockpit, role_finance, role_hures, role_trader) 
                VALUES (:username, :name, :password, :type, :role_cockpit, :role_finance, :role_hures, :role_trader)");

            $stmt_insert->bindParam(':username', $username);
            $stmt_insert->bindParam(':name', $name);
            $stmt_insert->bindParam(':password', $password);
            $stmt_insert->bindParam(':type', $type);
            $stmt_insert->bindParam(':role_cockpit', $role_cockpit);
            $stmt_insert->bindParam(':role_finance', $role_finance);
            $stmt_insert->bindParam(':role_hures', $role_hures);
            $stmt_insert->bindParam(':role_trader', $role_trader);
            $stmt_insert->execute();    
        }

        if (!$userExists) {
            // Registrieren
            registerUser($username, $name, $password, $type, $role_cockpit, $role_finance, $role_hures, $role_trader);
            $Alert = 'Der neue Benutzer wurde eingerichtet.';
            $AlertTheme = 'success';
        } else {
            $Alert = 'Dieser Benutzername existiert bereits.';
            $AlertTheme = 'danger';
        }
    }
?>

<h1>Benutzer anlegen</h1>
<?php if (isset($Alert)) { ?>
    <div class="alert alert-<?php echo $AlertTheme ?> alert-dismissible fade show" role="alert">
        <?php echo $Alert ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<form method="post">
    <div class="row mb-3">
        <label for="new-username" class="form-label col-form-label col-2">Benutzername</label>
        <div class="col-10">
            <input type="text" name="username" id="new-username" class="form-control" autocomplete="off" placeholder="Benutzername">
        </div>
    </div>

    <div class="row mb-3">
        <label for="new-name" class="form-label col-form-label col-2">Anzeigename</label>
        <div class="col-10">
            <input type="text" name="name" id="new-name" class="form-control" autocomplete="off" placeholder="Anzeigename">
        </div>
    </div>

    <div class="row mb-3">
        <label for="new-password" class="form-label col-form-label col-2">Password</label>
        <div class="col-10">
            <input type="password" name="password" id="new-password" class="form-control" autocomplete="off" placeholder="Passwort">
        </div>
    </div>

    <div class="row mb-3">
        <label for="new-type" class="form-label col-form-label col-2">Account-Typ</label>
        <div class="col-10">
            <select name="type" id="new-typ" class="form-select">
                <option>Abteilung</option>
                <option>Gruppen-Login</option>
                <option>Person</option>
            </select>
        </div>
    </div>

    <div class="roles my-4">
        <h3>Rollen</h3>

        <div class="row">
            <div class="col-4 mb-3">
                <label for="role-cockpit" class="form-label">Rolle im Cockpit</label>
                <select name="role_cockpit" id="role-cockpit" class="form-select">
                    <option value="" selected>- keine -</option>
                    <?php foreach ($row_cp as $roleopt_cockpit) { ?>
                        <option value="<?php echo $roleopt_cockpit['role'] ?>"><?php echo $roleopt_cockpit['display_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-4 mb-3">
                <label for="role-finance" class="form-label">Rolle im Finance</label>
                <select name="role_finance" id="role-finance" class="form-select">
                    <option value="" selected>- keine -</option>
                    <?php foreach ($row_fin as $roleopt_finance) { ?>
                        <option value="<?php echo $roleopt_finance['role'] ?>"><?php echo $roleopt_finance['display_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-4 mb-3">
                <label for="role-hures" class="form-label">Rolle im HuRes</label>
                <select name="role_hures" id="role-hures" class="form-select">
                    <option value="" selected>- keine -</option>
                    <?php foreach ($row_hr as $roleopt_hr) { ?>
                        <option value="<?php echo $roleopt_hr['role'] ?>"><?php echo $roleopt_hr['display_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-4 mb-3">
                <label for="role-trader" class="form-label">Rolle im Trader</label>
                <select name="role_trader" id="role-trader" class="form-select">
                    <option value="" selected>- keine -</option>
                    <?php foreach ($row_td as $roleopt_td) { ?>
                        <option value="<?php echo $roleopt_td['role'] ?>"><?php echo $roleopt_td['display_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" type="submit" name='submit-btn'>Benutzer anlegen</button>
</form>

<?php require "../../components/footer.php" ?>