<?php 
    session_start();

    if (!isset($_SESSION['unique_id'])) {
        header('Location: login.php');
    }
    
    $service = 'cockpit';
    $siteTitle = 'PWStack Registrierung';
    include_once "includes/header.php";
    require_once("includes/config.php");
?>

<div class="container">
    <div class="row">
        <div class="col-12 mt-5 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="display-6 align-center">Registration</h1>
                    <hr>

                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $username = mysqli_real_escape_string($conn, $_POST['username']);
                            $password = mysqli_real_escape_string($conn, $_POST['password']);
                            $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

                            if(!empty($username) && !empty($password) && !empty($password2)) {
                                if($password == $password2) {
                                    $sql = mysqli_query($conn, "SELECT * FROM pwm_users WHERE username = '{$username}';");
                                    if(mysqli_num_rows($sql) > 0) {
                                        echo '<div class="alert alert-danger" role="alert">This username is already taken.</div>';
                                    } else {
                                        $hashedPasswort = password_hash($password, PASSWORD_DEFAULT);
                                        mysqli_query($conn, "INSERT INTO pwm_users(username, password) VALUES ('{$username}', '{$hashedPasswort}');");
                                        $sql3 = mysqli_query($conn, "SELECT * FROM pwm_users WHERE username = '{$username}' AND password = '{$hashedPasswort}';");
                                        if(mysqli_num_rows($sql3) > 0) {
                                            echo '<div class="alert alert-success" role="alert">Der PWStack-Benutzer '.$username.' wurde registriert.</div>';
                                          
                                        }
                                    }
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">The two passwords do not match.</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Please fill all fields.</div>';
                            }
                    ?>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <label for="basic-url" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input id="username" name="username" type="text" class="form-control" placeholder="Username">
                        </div>

                        <label for="basic-url" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                        </div>

                        <label for="basic-url" class="form-label">Repeat Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input id="password2" name="password2" type="password" class="form-control" placeholder="Repeat Password">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-sign-in-alt"></i> &nbsp;Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    include_once "includes/footer.php";
?>