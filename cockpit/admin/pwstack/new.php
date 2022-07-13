<?php

    $service = 'cockpit';
    $siteTitle = 'Neuer Benutzer - PWStack';
    $no_body = true;
    $noredirect = true;
    require "../../../components/header.php";
    // require_once("includes/config.php");

    if (isset($_SESSION['username'])) {
        if(!isset($_SESSION['identity_confirmed'])) {
            header("Location:confirm-identity.php");
        }
    } else {
        header('Location: http://northware-cockpit.test/login.php');
    }
?>
<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($db_pws, $_POST['username']);
        $name = mysqli_real_escape_string($db_pws, $_POST['name']);
        $password = mysqli_real_escape_string($db_pws, $_POST['password']);
        $hashedPassword = openssl_encrypt($password, "AES-128-ECB", SECRETKEY);
        $accountType = mysqli_real_escape_string($db_pws, $_POST['account_type']);

        $db_pws->query("INSERT INTO pws_users(username, name, password, type) VALUES ('{$username}', '{$name}', '{$hashedPassword}', '{$accountType}');");
        header('Location: roles.php?new_user='.$username);
    }
?>

<body>
    <main class="container-lg wrapper">
        <h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">PWStack</a></li>
                <li class="breadcrumb-item active">Neuer Benutzer</li>
            </ol>
        </h2>
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?>" role="alert">
                <?php echo $Alert ?>
            </div>
        <?php } ?>

        <div class="my-5">
            <form name="submit-new" id="submit-new" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="row mb-3">
                    <label for="username" class="form-label col-form-label col-2">Benutzername</label>
                    <div class="col-10"><input type="text" class="form-control" id="username" name="username" placeholder="Benutzername" required></div>
                </div>

                <div class="row mb-3">
                    <label for="name" class="form-label col-form-label col-2">Anzeigename</label>
                    <div class="col-10"><input type="text" class="form-control" id="name" name="name" placeholder="Anzeigename" required></div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="form-label col-form-label col-2">Password</label>
                    <div class="col-10"><input type="password" class="form-control" id="password" name="password" placeholder="Passwort" required></div>
                </div>

                <div class="row mb-3">
                    <label for="new-type" class="form-label col-form-label col-2">Account-Typ</label>
                    <div class="col-10">
                        <select name="account_type" id="new-type" class="form-select">
                            <option value="department">Abteilung</option>
                            <option value="group">Gruppen-Login</option>
                            <option value="person">Person</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5">
                    <a href="index.php" role="button" class="btn btn-outline-primary"><i class="bi bi-arrow-left-short"></i> Zurück</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Passwort speichern</button>
                </div>
            </form>
        </div>  
    </main>
</body>

<?php 
    require "../../../components/footer.php";
?>