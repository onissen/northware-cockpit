<?php 
    $service = 'cockpit';
    $siteTitle = 'Passwort bearbeiten - PWStack';
    $no_body = true;
    $noredirect = true;
    require "../../../components/header.php";

    if (isset($_SESSION['username'])) {
        if(!isset($_SESSION['identity_confirmed'])) {
            header("Location:confirm-identity.php");
        }
    } else {
        header('Location: http://northware-cockpit.test/login.php');
    }
?>
<?php
    if (isset($_REQUEST['uid'])) {
        $id = $_REQUEST['uid'];
        $res = $db_pws->query("SELECT * FROM pws_users WHERE id = {$id}")->fetch_object();
        $decryptedPw = openssl_decrypt($res->password, 'AES-128-ECB', SECRETKEY);

        if (isset($_POST['submit_epassword'])) {
            $id = $_REQUEST['uid'];
            $username = $_POST['username'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $type = $_POST['type'];
            $hashedPassword = openssl_encrypt($password, "AES-128-ECB", SECRETKEY);
            
            $sql = $db_pws->prepare("UPDATE pws_users SET username=?, name=?, password=?, type=? WHERE id=?");
            $sql->bind_param('ssssi', $username, $name, $hashedPassword, $type, $id);

            if ($sql->execute()) {
                header('Location: index.php?useredited='.$username);
            }
        }
    }
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

        <div class="my-5">
            <?php if(isset($_REQUEST['uid'])) { ?>
            <form name="submit-edit" id="submit-edit" method="post">
                <div class="mb-3 row">
                    <label for="username" class="form-label col-form-label col-lg-2">Benutzername</label>
                    <div class="col-lg-10"><input type="text" class="form-control" id="username" name="username" placeholder="Benutzername" required value="<?php echo $res->username ?>"></div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="form-label col-form-label col-lg-2">Anzeigename</label>
                    <div class="col-lg-10"><input type="text" class="form-control" id="name" name="name" placeholder="Anzeigename" required value="<?php echo $res->name ?>"></div>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="form-label col-form-label col-lg-2">Password</label>
                    <div class="col-lg-10"><div class="input-group">
                        <input type="password" class="form-control" id="show-edit-password" name="password" placeholder="Passwort" required value="<?php echo $decryptedPw ?>">
                        <span class="input-group-text eye-toggle"><i class="fa-solid fa-eye" style="cursor: pointer;" id="show-edit-password-eye" onclick="showPw('show-edit-password')"> </i></span>
                    </div></div>
                </div>

                <div class="row mb-3">
                    <label for="type" class="form-label col-form-label col-2">Account-Typ</label>
                    <div class="col-10">
                        <select name="type" id="type" class="form-select">
                            <option value="department" <?php if($res->type == 'department') {echo 'selected';} ?> >Abteilung</option>
                            <option value="group" <?php if($res->type == 'group') {echo 'selected';} ?> >Gruppen-Login</option>
                            <option value="person" <?php if($res->type == 'person') {echo 'selected';} ?> >Person</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5">
                    <a href="index.php" role="button" class="btn btn-outline-primary"><i class="bi bi-arrow-left-short"></i> Zurück</a>
                    <button type="submit" class="btn btn-primary" name="submit_epassword"><i class="bi bi-check-lg"></i> Passwort speichern</button>
                </div>
            </form>
            <?php } else { ?>              
                <div class="alert alert-danger" role="alert">
                    Da in dieser Ansicht keine Daten angezeigt werden könnten, werden Sie auf die Startseite zurück geleitet.
                </div>
                <meta http-equiv="refresh" content="3; URL= index.php">
            <?php } ?>
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
    require "../../../components/footer.php";
?>