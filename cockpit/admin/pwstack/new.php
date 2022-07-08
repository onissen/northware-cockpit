<?php 
    session_start();
    if(!isset($_SESSION['unique_id'])) {
        header("Location:login.php");
    }
?>
<?php
    $service = 'cockpit';
    $siteTitle = 'Neues Passwort - PWStack';
    include_once "includes/header.php";
    require_once("includes/config.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $hashedPasswort = openssl_encrypt($password, "AES-128-ECB", SECRETKEY);
        // Hier $services definieren

        $conn->query("INSERT INTO pwm_passwords(username, name, password) VALUES ('{$username}', '{$name}', '{$hashedPasswort}');");
        header('Location: index.php?newsaved');
    }

    $conn->close();
?>

<body>
    <main class="container-lg wrapper">
        <h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">PWStack</a></li>
                <li class="breadcrumb-item active">Neues Passwort</li>
            </ol>
        </h2>
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?>" role="alert">
                <?php echo $Alert ?>
            </div>
        <?php } ?>

        <div class="my-3">
            <form name="submit-new" id="submit-new" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Benutzername</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Benutzername" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Anzeigename</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Anzeigename" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" required>
                </div>

                <a href="index.php" role="button" class="btn btn-secondary"><i class="bi bi-arrow-left-short"></i> Zurück</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Passwort speichern</button>
            </form>
        </div>
    </main>
</body>

<?php 
    include_once "includes/footer.php";
?>