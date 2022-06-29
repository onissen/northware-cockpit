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

        $stmt = $db_cockpit->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $userExists = $stmt->fetchAll();

        $passwordHashed = $userExists[0]['password'];
        $checkPassword = password_verify($password, $passwordHashed);

        if (!$checkPassword) {
            $Alert = 'Das Passwort ist falsch.';
            $AlertTheme = 'warning';
        } else {
            $_SESSION['username'] = $userExists[0]['username'];
            $_SESSION['name'] = $userExists[0]['name'];
            $_SESSION['rcockpit'] = $userExists[0]['role_cockpit'];
            $_SESSION['rfinance'] = $userExists[0]['role_finance'];
            $_SESSION['rhures'] = $userExists[0]['role_hures'];
            $_SESSION['rtrader'] = $userExists[0]['role_trader'];
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
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?> alert-dismissible fade show" role="alert">
                <?php echo $Alert ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <input type="password" name="password" id="username" class="form-control" autocomplete="off" placeholder="Benutzername">
                    <label for="password" class="floating-label">Passwort</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit-btn">Login</button>
            </form>
        </div>
    </main>
</body>