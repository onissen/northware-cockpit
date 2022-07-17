<?php
    $service = 'cockpit';
    $siteTitle = 'Login';
    $no_body = true;
    $noredirect = true;
    require 'components/header.php';
?>

<?php

    if (isset($_POST['submit-btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $db_pws->query("SELECT pws_users.username, pws_users.password, pws_users.name, pws_userroles.role_nwcockpit, pws_userroles.role_nwfinance, pws_userroles.role_nwhures, pws_userroles.role_nwtrader 
        FROM pws_users LEFT JOIN pws_userroles ON pws_users.id = pws_userroles.user_id WHERE pws_users.username = '$username'");

        $userExists = $stmt->fetch_assoc();

        $passwordDehashed = openssl_decrypt($userExists['password'], 'AES-128-ECB', SECRETKEY);

        if ($password != $passwordDehashed) {
            $Alert = 'Das Passwort ist falsch.';
            $AlertTheme = 'warning';
        } else {
            $_SESSION['username'] = $userExists['username'];
            $_SESSION['name'] = $userExists['name'];

            $_SESSION['rcockpit'] = $userExists['role_nwcockpit'];
            $_SESSION['rfinance'] = $userExists['role_nwfinance'];
            $_SESSION['rhures'] = $userExists['role_nwhures'];
            $_SESSION['rtrader'] = $userExists['role_nwtrader'];
            header('Location:index.php');
        }
    }

    if (isset($_REQUEST['logout'])) {
        $Alert = 'Du wurdest abgemeldet.';
        $AlertTheme = 'success';
    }
?>

<body class="login-body">
    <main class="login-main">
        <div class="login-brand mb-4 bg-cockpit">
            <i class="fa-solid fa-briefcase"></i>
            <span>Northware Cockpit</span>
        </div>
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?>" role="alert">
                <?php echo $Alert ?>
            </div>
        <?php } ?>
        <div class="login-box">
            <h1>Login</h1>
            <form method="post">
                <div class="form-floating my-3">
                    <input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="Benutzername">
                    <label for="username" class="floating-label">Benutzername</label>
                </div>

                <div class="form-floating my-3">
                    <input type="password" name="password" id="username" class="form-control" autocomplete="off" placeholder="Passwort">
                    <label for="password" class="floating-label">Passwort</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit-btn">Login</button>
            </form>
        </div>
    </main>
</body>