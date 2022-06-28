<?php
    $service = 'finance';
    $no_body = true;
    require '../components/header.php';
?>

<?php
    $sql = "SELECT mid, cname FROM clients ORDER BY mid";
    $data = $db_cockpit->query($sql)->fetchAll();
?>

<body class="login-body">
    <main class="login-main confirmation-main">
        <div class="login-brand mb-4 bg-finance">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span>Northware Financials</span>
        </div>

        <div class="userconfirmation-box mb-4">
            <div class="current-user float-start"><i class="fa-solid fa-user"></i> <?php echo $_SESSION['name'] ?></div>
            <div class="signout-link text-end">
                <form method="post">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-link link-btn link-btn-secondary"><i class="fa-solid fa-arrow-right-from-bracket"></i> Abmelden</button>
                </form>
            </div>
        </div>

        <div class="login-box">
            <form action="dashboard.php" method="post" class="company">
                <h2>Mandant wählen</h2>
                <label for="select-company" class="visually-hidden">Mandanten wählen</label>
                <select name="company" id="select-company" class="form-select mb-3">
                    <option value="" disabled selected>wählen</option>

                    <?php foreach ($data as $client) { ?>
                        <option value="<?php echo $client['mid'] ?>"><?php echo $client['mid'].' / '.$client['cname'] ?></option>
                    <?php } ?>
                </select>
                <button class="btn btn-primary" type="submit" name="btn-client">Mandanten wählen</button><br>
                <a href="../" class="link-btn link-btn-secondary mt-3">Zurück zum Cockpit</a></div>
            </form>
        </div>
    </main>
</body>

<?php require '../components/footer.php'; ?>