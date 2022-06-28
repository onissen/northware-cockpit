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
            $Alert = '<div class="alert alert-warning" role="alert">Das Passwort ist falsch.</div>';
        } else {
            $_SESSION['username'] = $userExists[0]['username'];
            $_SESSION['name'] = $userExists[0]['name'];
            header('Location:index.php');
        }
    }

    if (isset($_REQUEST['logout'])) {
        $Alert = '<div class="alert alert-success" role="alert">Du wurdest abgemeldet.</div>';
    }
?>

<body class="login-body">
    <main class="login-main">
        <div class="login-brand mb-4 bg-cockpit">
            <i class="fa-solid fa-briefcase"></i>
            <span>Northware Cockpit</span>
        </div>
        <?php if (isset($Alert)) { ?><div class="alerts mb-4"><?php echo $Alert ?></div><?php } ?>
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