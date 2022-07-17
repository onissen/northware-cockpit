<?php
    $service = 'cockpit';
    $siteTitle = 'Rollen und Services - PWStack';
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
    $sql = $db_pws->query("SELECT * FROM pws_roles ORDER BY service, id");

    while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
        $item[] = $row;
    }

    if (isset($_POST['sub-delRole']) AND $_POST['sub-delRole'] == 'deleteRole') {
        $id = $_POST['id-delete'];

        $sql = mysqli_query($db_pws, "DELETE FROM pws_roles WHERE id = $id;");
        $Alert = 'Die Rolle mit der ID '.$id.' wurde gelöscht.';
        $AlertTheme = 'success';
    }

    if (isset($_POST['submit-newRole'])) {
        $service = $_POST['service'];
        $rowids = $_POST['rowid'];
        $roles = array();
        $roles = $_POST['role'];

        $role_names = array();
        $role_names = $_POST['role_name'];

        $rows = count($rowids);
        $sql_snippet = array();
        $sql_string = '';
        foreach ($rowids as $key) {
                $sql_snippet[] .= "('".$service."', '".$roles[$key]."', '".$role_names[$key]."')";
                if ($key != $rows - 1) {
                    $sql_snippet[$key] .=', ';
                }
                $sql_string .= $sql_snippet[$key];
        }

        $sql = "INSERT INTO pws_roles(service, role, role_name) VALUES $sql_string";
        
        if ($db_pws->query($sql) === TRUE) {
            $Alert = "Die neuen Rollen wurden erfolgreich hinzugefügt.";
            $AlertTheme = 'success';
        } else {
            $Alert = "Es gab einen Fehler bei der Aufgabe.<br>" . $db_pws->error;
            $AlertTheme = 'danger';
        }
            }
?>
<body>
    <main class="container-lg wrapper">
        <h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">PWStack</a></li>
                <li class="breadcrumb-item active">Rollen und Services</li>
            </ol>
        </h2>
        <?php if (isset($Alert)) { ?>
            <div class=" alerts mb-4 alert alert-dismissible alert-<?php echo $AlertTheme ?>" role="alert">
                <?php echo $Alert ?>
                <a role="button" class="btn-close" aria-label="Close" href="edit-roles.php"></a>
            </div>
        <?php } ?>
        
        <div class="accordion accordion-flush" id="accordionRoles">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNewRole">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bodyNewRole" aria-expanded="false" aria-controls="bodyNewRole">
                        Neue Rollen hinzufügen
                    </button>
                </h2>
                <div id="bodyNewRole" class="accordion-collapse collapse" aria-labelledby="headingNewRole" data-bs-parent="#accordionRoles">
                    <div class="accordion-body">
                        <form method="post" id="formNewRole" class="my-3">
                            <div class="row mb-3">
                                <label for="select-service" class="col-form-label form-label col-lg-2">Service</label>
                                <div class="col-lg-5">
                                    <select name="service" id="select-service" class="form-select" required>
                                        <option value="" disabled selected>- wählen -</option>
                                        <option value="nw_cockpit">Northware Cockpit</option>
                                        <option value="nw_finance">Northware Finance</option>
                                        <option value="nw_hures">Northware HuRes</option>
                                        <option value="nw_trader">Northware Trader</option>
                                        <option value="companydata">Company Data</option>
                                        <option value="intranet">Intranet</option>
                                    </select>
                                </div>
                                <div class="col-lg-3"><button type="button" class="btn btn-outline-wp" onclick="WPRoleSet()"><i class="fa-brands fa-wordpress-simple"></i> Wordpress Standard</button></div>
                            </div>
                            <div class="mt-3 input-table">
                                    <div class="row-labels">
                                        <label for="inputx-role" class="form-label">Rollen-Slug</label>
                                        <span class="form-text">Der Rollen-Alias im Code. Dieser Slug ist wichtig zur Rechte-Steuerung.</span>
                                    </div>
                                    <div class="row-labels ms-3">
                                        <label for="inputx-rolename" class="form-label">Rollen-Name</label>
                                        <span class="form-text">Der Anzeigename der Rolle. Diese Bezeichnung ist auf der Seite sichtbar.</span>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="row-inputs" id="row-input">
                                        <input type="hidden" name="rowid[]" id="input-rowid1" value="0">
                                        <input type="text" class="mb-2 form-control" id="input-role1" name="role[]" placeholder="Bsp: management">
                                        <input type="text" class="ms-3 mb-2 form-control" id="input-rolename1" name="role_name[]" placeholder="Bsp: Management">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <a class="link-alone cursor-pointer" id="btn-duplicateInputRow" onclick="CloneInputRow()">Weitere Rolle</a>
                            <br>
                            <button type="submit" class="btn btn-primary mt-3" id="submit-newRole" name="submit-newRole"><i class="bi bi-check-lg"></i> Rollen anlegen</button>
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingExistingRoles">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#bodyExistingRoles" aria-expanded="true" aria-controls="bodyExistingRoles">
                        Rollen anzeigen
                    </button>
                </h2>
                <div id="bodyExistingRoles" class="accordion-collapse collapse show" aria-labelledby="headingExistingRoles" data-bs-parent="#accordionRoles">
                    <div class="accordion-body">
                        <div class="row my-3" id="SearchRoles">
                            <div class="col-lg-3">
                                <select id="SearchType" class="form-select">
                                    <option value="3" selected>Service</option>
                                    <option value="1">Rollen-Slug</option>
                                    <option value="2">Rollen-Name</option>
                                </select>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="SearchInput" onkeyup="FunctionSearch()" placeholder="Suchen"></input>
                            </div>
                        </div>

                        <table class="table table-striped" id="resultTable">
                            <thead>
                                <tr>
                                    <th>Rollen-Slug</th>
                                    <th>Rollen-Name</th>
                                    <th>Service</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($item as $role) { ?>
                                    <tr>
                                        <td><?php echo $role['role'] ?></td>
                                        <td><?php echo $role['role_name'] ?></td>
                                        <td>
                                            <?php if($role['service'] == 'nw_cockpit'){ ?> <span class="badge text-bg-cockpit">Northware Cockpit</span> <?php } ?>
                                            <?php if($role['service'] == 'nw_finance'){ ?> <span class="badge text-bg-finance">Northware Finance</span> <?php } ?>
                                            <?php if($role['service'] == 'nw_hures'){ ?> <span class="badge text-bg-hures">Northware HuRes</span> <?php } ?>
                                            <?php if($role['service'] == 'nw_trader'){ ?> <span class="badge text-bg-trader">Northware Trader</span> <?php } ?>
                                            <?php if($role['service'] == 'companydata'){ ?> <span class="badge text-bg-companydata">Company Data</span> <?php } ?>
                                            <?php if($role['service'] == 'intranet'){ ?> <span class="badge text-bg-intranet">Intranet</span> <?php } ?>
                                        </td>
                                        <td><a class="link-btn-sm link-btn-danger cursor-pointer" onclick="deleteRole(<?php echo $role['id'] ?>)"><i class="fa-solid fa-trash-can"></i></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
            
                        <form method="post" id="form-delete">
                            <input type="hidden" name="id-delete" id="id-delete">
                            <input type="hidden" name="sub-delRole" id="submit-delete">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<?php require "../../../components/footer.php"; ?>