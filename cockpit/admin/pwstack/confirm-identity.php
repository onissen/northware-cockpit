<?php
    $service = 'cockpit';
    $siteTitle = 'PWStack Identitätsprüfung';
    $no_body = true;
    $noredirect = true;
    require "../../../components/header.php";

    if(isset($_SESSION['identity_confirmed'])) {
        if (isset($_GET['lockpws'])) {
            unset($_SESSION['identity_confirmed']);
            $Alert = 'Der PWStack wurde gesperrt. Sie wurden abgemeldet.';
            $AlertTheme = 'success';
        }
        else {header("Location:index.php");}
    }

    $sendmail = false;
    function sendCode() {
        $code = mt_rand(111111, 999999);
        $mail_recipiant = 'it@nissen-group.de';
        $mail_subject = 'Code fuer das PWStack';
        $mail_message = '
        <html>
        <body>    
            <p>Wir haben am '.date('d.m.Y H:i').' Uhr die Anforderung fuer einen Identifizierungscode fuer das Northware PWStack erhalten.<p>
            <p>Der Identifizierungscode lautet: <b>'.$code.'</b></p>
            <br>
            <p>Viele Gruesse vom Northware PWStack</p>
        </body>
        </html>
        ';
        $mail_header[] = 'MIME-Version: 1.0';
        $mail_header[] = 'Content-type: text/html; charset=iso-8859-1';

        global $sendmail;
        $sendmail = mail($mail_recipiant, $mail_subject, $mail_message, implode("\r\n", $mail_header));

        $_SESSION['code'] = $code;
    }

    function checkKey() {
        $key = $_POST['key'];

        if ($key == $_SESSION['code']) {
            unset($_SESSION['code']);
            $_SESSION['identity_confirmed'] = true;
            header('Location: index.php');
        } else {
            global $Alert;
            global $AlertTheme;
            $Alert = 'Der eingebene Code war falsch. Bitte versuchen Sie es mit einem neuen Code.';
            $AlertTheme = 'danger';
        }
    }

    if (isset($_POST['submit-code'])) {
        sendCode();
        if ($sendmail) {$mailarrived = true;}
        else {
            $Alert = 'Es gab ein Problem beim Mail-Versand.';
            $AlertTheme = 'danger';
        }
    }
    
    if (isset($_POST['submit-key'])) {
        checkKey();
        echo 'Code: '.$_SESSION['code'];
        echo 'Key: '.$key;
        print_r($_POST);
    }

    if (isset($_GET['noaccess'])) {
        $mailarrived = true;
        $_SESSION['code'] = $secretcode;
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
            <h1>Identität bestätigen</h1>

            <?php if (!isset($mailarrived)) { ?>
                <form method="post" class="info-mail">
                    <p>Für den Zugang zum PWStack muss deine Identität geprüft werden. Dazu senden wir eine Mail an die IT-Abteilung</p>
                    <button type="submit" class="btn btn-primary w-100 btn-lg" name="submit-code">Alles klar, jetzt Code senden</button>
                    <a href="?noaccess" class="mt-3 link-btn link-btn-primary">Ich habe keinen Zugriff auf den Code.</a>
                </form>
            <?php } else { ?>
                <form method="post" id="ident-form">
                    <div class="otp-input-fields my-3">
                        <input type="text" name="" id="" class="form-control form-control-lg" maxlength="1">
                        <input type="text" name="" id="" class="form-control form-control-lg" maxlength="1">
                        <input type="text" name="" id="" class="form-control form-control-lg" maxlength="1">
                        <input type="text" name="" id="" class="form-control form-control-lg" maxlength="1">
                        <input type="text" name="" id="" class="form-control form-control-lg" maxlength="1">
                        <input type="text" name="" id="" class="form-control form-control-lg" maxlength="1">
                    </div>

                    <?php if(isset($_GET['noaccess'])) { ?><a class="link-btn link-btn-primary" href="#" data-bs-toggle="tooltip" title="<?php echo $secrettipp ?>">Gib mir einen Tipp</a><?php } ?>

                    <input type="hidden" name="key" id="input-key">
                    <input type="hidden" name="submit-key" id="sub_key">
                </form>
            <?php } ?>
        </div>
    </main>
</body>


<?php 
    include_once "../../../components/footer.php";
?>