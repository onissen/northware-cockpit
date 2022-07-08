<?php 
    session_start();

    if(isset($_SESSION['unique_id'])) {
        if (isset($_GET['lockpws'])) {
            unset($_SESSION['unique_id']);
            $Alert = 'Der PWStack wurde gesperrt. Sie wurden abgemeldet.';
            $AlertTheme = 'success';
        }
        else {header("Location:index.php");}
    }

    $service = 'cockpit';
    $siteTitle = 'PWStack Login';
    include_once "includes/header.php";
    require_once("includes/config.php");

    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if(!empty($username) && !empty($password)) {
            $sqlUserData = mysqli_query($conn, "SELECT password FROM pwm_users WHERE username = '{$username}' LIMIT 1;");
            $finfo = $sqlUserData->fetch_array(MYSQLI_NUM);

            if (!is_array($finfo) || !count($finfo) === 1) {
                $Alert = 'Es gab ein Problem bei der Anmeldung.';
                $AlertTheme = 'danger';
                exit;
            }

            if (password_verify($password, $finfo[0])) {
                $sql = mysqli_query($conn, "SELECT * FROM pwm_users WHERE username = '{$username}' LIMIT 1;");
                $row = mysqli_fetch_assoc($sql);
                $_SESSION['unique_id'] = $row['id'];
                header("Location:index.php");
            } else {
                $Alert = 'Der Benutzername oder das Passwort sind falsch. bitte versuche es noch einmal.';
                $AlertTheme = 'warning';
            }
        } else {
            $Alert = 'Bitte fülle alle felder aus.';
            $AlertTheme = 'warning';
        }
    }
?>

<body class="login-body" id="login-pwstack">
    <main class="login-main">
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?>" role="alert">
                <?php echo $Alert ?>
            </div>
        <?php } ?>
        <div class="login-box">
            <h1>Login PWStack</h1>

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

<?php 
    include_once "includes/footer.php";
?>