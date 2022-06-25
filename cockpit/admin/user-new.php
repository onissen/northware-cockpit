<?php
    $service = "cockpit";
    $siteTitle = 'Neuer Benutzer';
    require "../../components/header.php";
?>

<?php
    if (isset($_POST['submit-btn'])) {
        $username = $_POST['username'];
        $name = $_POST['name'];
        // $initials = $_POST['initials'];
        $password = PASSWORD_HASH($_POST['password'], PASSWORD_DEFAULT);
        // $role_cockpit = $_POST['role_cockpit'];
        // $role_finance = $_POST['role_finance'];
        // $role_hures = $_POST['role_hures'];
        // $role_trader = $_POST['role_trader'];

        $stmt = $db_cockpit->prepare("SELECT * FROM users WHERE username=:username OR name=:name");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":name", $name);
        $stmt->execute();

        $userExists = $stmt->fetchColumn();

        function registerUser($username, $name, $password){
            global $db_cockpit;
            $stmt_insert = $db_cockpit->prepare("INSERT INTO users(username, name, password) VALUES (:username, :name, :password)");

            $stmt_insert->bindParam(':username', $username);
            $stmt_insert->bindParam(':name', $name);
            $stmt_insert->bindParam(':password', $password);
            $stmt_insert->execute();
        }

        if (!$userExists) {
            // Registrieren
            registerUser($username, $name, $password);
        } else {
            // User existiert bereits
        }
    }
?>

<main class="container wrapper">
    <h1>Benutzer anlegen</h1>
    <form action="user-new.php" method="post">
        <div class="row mb-3">
            <label for="new-username" class="form-label col-form-label col-2">Benutzername</label>
            <div class="col-10">
                <input type="text" name="username" id="new-username" class="form-control" autocomplete="off" placeholder="Benutzername">
            </div>
        </div>

        <div class="row mb-3">
            <label for="new-name" class="form-label col-form-label col-2">Anzeigename / Initialen</label>
            <div class="col-6">
                <input type="text" name="name" id="new-name" class="form-control" autocomplete="off" placeholder="Anzeigename">
            </div>
            <div class="col-4">
                <input type="text" name="initials" id="new-initials" class="form-control" autocomplete="off" placeholder="Initialen">
            </div>
        </div>

        <div class="row mb-3">
            <label for="new-password" class="form-label col-form-label col-2">Password</label>
            <div class="col-10">
                <input type="password" name="password" id="new-password" class="form-control" autocomplete="off" placeholder="Passwort">
            </div>
        </div>

        <div class="roles my-4">
            <h3>Rollen</h3>

            <div class="row">
                <div class="col-4 mb-3">
                    <label for="role-cockpit" class="form-label">Rolle im Cockpit</label>
                    <select name="role_cockpit" id="role-cockpit" class="form-select">
                        <option value="">- keine -</option>
                        <option value="admin">Administator</option>
                        <option value="member" selected>Mitarbeiter</option>
                    </select>
                </div>

                <div class="col-4 mb-3">
                    <label for="role-finance" class="form-label">Rolle im Finance</label>
                    <select name="role_finance" id="role-finance" class="form-select">
                        <option value="">- keine -</option>
                        <option value="value">Rolle</option>
                    </select>
                </div>

                <div class="col-4 mb-3">
                    <label for="role-hures" class="form-label">Rolle im HuRes</label>
                    <select name="role_hures" id="role-hures" class="form-select">
                        <option value="">- keine -</option>
                        <option value="value">Rolle</option>
                    </select>
                </div>

                <div class="col-4 mb-3">
                    <label for="role-trader" class="form-label">Rolle im Trader</label>
                    <select name="role_trader" id="role-trader" class="form-select">
                        <option value="">- keine -</option>
                        <option value="value">Rolle</option>
                    </select>
                </div>
            </div>
        </div>

        <button class="btn btn-primary" type="submit" name='submit-btn'>Benutzer anlegen</button>
    </form>

</main>

<?php require "../../components/footer.php" ?>