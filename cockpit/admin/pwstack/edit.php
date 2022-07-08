<?php 
    session_start();
    if(!isset($_SESSION['unique_id'])) {
        header("Location:login.php");
    }
?>
<?php
    $service = 'cockpit';
    $siteTitle = 'Passwort bearbeiten - PWStack';
    include_once "includes/header.php";
    require_once("includes/config.php");

    $id = $_REQUEST['uid'];
    $res = $conn->query("SELECT * FROM pwm_passwords WHERE id = {$id}")->fetch_object();
    $decryptedPw = openssl_decrypt($res->password, 'AES-128-ECB', SECRETKEY);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $hashedPasswort = openssl_encrypt($password, "AES-128-ECB", SECRETKEY);
        // Hier $services definieren

        $conn->query("UPDATE pwm_passwords SET username = {$username}, name = {$name}, password = {$hashedPassword}");
        header('Location: index.php?editsaved');
    }

    $conn->close();
?>

<body>
    <main class="container-lg wrapper">
        <h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">PWStack</a></li>
                <li class="breadcrumb-item active">Passwort bearbeiten</li>
            </ol>
        </h2>
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?>" role="alert">
                <?php echo $Alert ?>
            </div>
        <?php } ?>

        <div class="my-3">
            <form name="submit-edit" id="submit-edit" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Benutzername</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Benutzername" required value="<?php echo $res->username ?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Anzeigename</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Anzeigename" required value="<?php echo $res->name ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="show-edit-password" name="password" placeholder="Passwort" required value="<?php echo $decryptedPw ?>">
                        <span class="input-group-text eye-toggle"><i class="fa-solid fa-eye" style="cursor: pointer;" id="show-edit-password-eye" onclick="showPw('show-edit-password')"> </i></span>
                    </div>
                </div>

                <a href="index.php" role="button" class="btn btn-secondary"><i class="bi bi-arrow-left-short"></i> Zurück</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Passwort speichern</button>
            </form>
        </div>
    </main>
</body>

<script>
    function showPw(id) {
        const field = document.getElementById(id);
        const eye = document.getElementById(`${id}-eye`);
        if(field.type == "text") {
            field.type = "password";
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
        } else {
            field.type = "text";
            eye.classList.add("fa-eye-slash");
            eye.classList.remove("fa-eye");
        }
    }
</script>

<?php 
    include_once "includes/footer.php";
?>