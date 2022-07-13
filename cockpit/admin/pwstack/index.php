<?php 
    $service = 'cockpit';
    $siteTitle = 'PWStack Home';
    $no_body = true;
    $noredirect = true;
    require '../../../components/header.php';
?>
    <?php
    if (isset($_SESSION['username'])) {
        if(!isset($_SESSION['identity_confirmed'])) {
            header("Location:confirm-identity.php");
        }
    } else {
        header('Location: http://northware-cockpit.test/login.php');
    }
    

    $res = $db_pws->query("SELECT * FROM pws_users ORDER BY username");
    $array = array();

    while($item = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $array[] = $item;
    }

    if (isset($_POST['sub-delPW'])) {
        $uid = $_POST['uid-delete'];
        $username = $_POST['username-delete'];
        $sql = mysqli_query($db_pws, "DELETE FROM pws_users WHERE id = $uid;");
        $Alert = 'Der Eintrag zu Benutzer'.$username.' (ID '.$uid.' ) wurde gelöscht.';
        $AlertTheme = 'success';
    }

    if (isset($_GET['newsaved'])) {
        $Alert = 'Der neue Eintrag wurde gespeichert.';
        $AlertTheme = 'success';
    }

    if (isset($_GET['editsaved'])) {
        $Alert = 'Der Benutzer '.$_GET['editsaved'].' wurde gespeichert.';
        $AlertTheme = 'success';
    }
    
    $db_pws->close();
?>

<body>
    <main class="container-lg wrapper">
        <div class="row">
            <div class="col-lg-8">
                <h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-primary">PWStack</li>
                        <li class="breadcrumb-item active">Passwörter </li>
                    </ol>
                </h2>
            </div>
            <div class="col-lg-4">
                <a href="new.php" role="button" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Neu hinzufügen</a>
                <a href="confirm-identity.php?lockpws" role="button" class="btn btn-outline-primary"><i class="bi bi-shield-lock-fill"></i></i> PWStack sperren</a>
            </div>
        </div>
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-<?php echo $AlertTheme ?>" role="alert">
                <?php echo $Alert ?>
            </div>
        <?php } ?>
        <div class="my-3">
            <?php if ($res->num_rows <= 0) { ?>
            <div class="alert alert-danger" role="alert">Es sind keine Passwörter zur Anzeige vorhanden.</div>
              
            <?php } else {
                $counter = 1;
                foreach ($array as $item) {
                    $decryptedPw = openssl_decrypt($item['password'], 'AES-128-ECB', SECRETKEY); ?>
                    <div class="pw-row row">
                        <div class="col-lg-1 role-icon">
                            <?php
                                if ($item['type'] == 'department') {echo '<i class="fa-solid fa-people-group"></i>';}
                                if ($item['type'] == 'person') {echo '<i class="fa-solid fa-user"></i>';}
                                if ($item['type'] == 'group') {echo '<i class="fa-solid fa-user-group"></i>';}
                            ?>
                        </div>
                        <div class="col-lg-3 info-text">
                            <div class="username"><a href="edit.php?uid=<?php echo $item['id'] ?>"><?php echo $item['username'] ?></a></div>
                            <div class="name"><?php echo $item['name'] ?></div>
                        </div>
                        <div class="col-lg-2">
                            <div class="input-group">
                                <input type="password" id="<?php echo 'password-'.$counter ?>" readonly class="form-control-plaintext input-password" value="<?php echo $decryptedPw ?>">
                                <span class="input-group-text eye-toggle"><i class="fa-solid fa-eye" style="cursor: pointer;" id="<?php echo 'password-'.$counter.'-eye' ?>" onclick="showPw('<?php echo 'password-'.$counter ?>')"> </i></span>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <span class="badge text-bg-primary">Services</span>
                            <span class="badge text-bg-primary">Services</span>
                        </div>
                        <div class="col-1">
                            <a class="link-btn-sm link-btn-danger cursor-pointer" onclick="deletePW(<?php echo $item['id'] ?>, '<?php echo $item['username'] ?>')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
                <?php $counter++; } } ?>
        </div>
        <form method="post" id="form-delete">
            <input type="hidden" name="uid-delete" id="uid-delete">
            <input type="hidden" name="username-delete" id="username-delete">
            <input type="hidden" name="sub-delPW" id="submit-delete">
        </form>
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
    include_once "../../../components/footer.php";
?>