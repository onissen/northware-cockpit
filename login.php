<?php
    $service = 'cockpit';
    $siteTitle = 'Login';
    require 'components/service-variables.php';
    require 'components/connection.php';
?>

<!DOCTYPE html>
<html lang="de" class="login-html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="http://northware-cockpit.test/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://northware-cockpit.test/utilities/fontawesome/css/all.css">
    <link rel="stylesheet" href="http://northware-cockpit.test/utilities/bootstrap-icons/bootstrap-icons.css">
    <link rel="shortcut icon" href="http://northware-cockpit.test/utilities/favicon-<?php echo $service ?>.png" type="image/x-icon">
    <link rel="stylesheet" href="http://northware-cockpit.test/css/main.css">
    <link rel="stylesheet" href="http://northware-cockpit.test/css/<?php echo $service ?>.css">
    
    <title><?php if (isset($siteTitle)) {echo $siteTitle.' | ';} echo $service_brand ?></title>
</head>

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
        <div class="login-brand mb-4">
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