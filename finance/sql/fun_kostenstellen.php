<?php
    // Liste Kostenstellen
    if (isset($_GET['sub_search'])) {
        // Es soll gesucht werden

        $qtype = array();
        $query = array();
        if (isset($_GET['sq_mid']) AND $_GET['sq_mid']!='') {
            $qtype[] .= 'mid';
            $query[] .= $_GET['sq_mid'];
        }

        if (isset($_GET['sq_pcenter']) AND $_GET['sq_pcenter']!='') {
            $qtype[] .= 'profitcenter';
            $query[] .= $_GET['sq_pcenter'];
        }

        if (isset($_GET['sq_kstid']) AND $_GET['sq_kstid']!='') {
            $qtype[] .= 'kstid';
            $query[] .= $_GET['sq_kstid'];
        }

        if (isset($_GET['sq_kstname']) AND $_GET['sq_kstname']!='') {
            $qtype[] .= 'kst_name';
            $query[] .= $_GET['sq_kstname'];
        }

        if (count($qtype) >= 1) {
            $rows = count($qtype);
            $search = "";
            $string = array();
            foreach ($qtype as $key => $value) {
                $string[] = $qtype[$key]." LIKE '%".$query[$key]."%'";
                if ($key != $rows - 1) {
                    $string[$key] .=' AND ';
                }
                $search .= $string[$key];
            }
            $sql_list = "SELECT * FROM kostenstellen WHERE $search ORDER BY kstid";

        } else {$sql_list = "SELECT * FROM kostenstellen WHERE deactivated IS NULL OR deactivated='' ORDER BY kstid";}
    } elseif (!isset($_REQUEST['deactivated'])) {$sql_list = "SELECT * FROM kostenstellen WHERE deactivated IS NULL OR deactivated='' ORDER BY kstid";}
    else {$sql_list = "SELECT * FROM kostenstellen WHERE deactivated IS NOT NULL ORDER BY kstid";}
    
    
    $data_list = $db_finance->query($sql_list)->fetchAll();


    // Mandanten
    // $sql_clients = "SELECT mid, cname FROM clients ORDER BY mid";
    // $data_clients = $db_cockpit->query($sql_clients)->fetchAll();

    if (isset($_REQUEST['id']) AND $_REQUEST['id'] != 'new') {
        $id = $_REQUEST['id'];
        $sql = "SELECT * FROM kostenstellen WHERE kstid = $id";
        $kst = $db_finance->query($sql)->fetchObject();
    }

    // Neue Kostenstelle
    if (isset($_POST['submit-new-kst'])) {
        $mid = $_POST['mid'];
        $kstid = intval($_POST['kstid']);
        $kst_name = $_POST['kst_name'];
        $activated = $_POST['activated'];

        $stmt = $db_finance->prepare("SELECT * FROM kostenstellen WHERE kstid = :kstid");
        $stmt->bindParam(":kstid", $kstid);
        $stmt->execute();

        $rowExists = $stmt->fetchColumn();

        if (!$rowExists) {
            $sql = $db_finance->prepare("INSERT INTO kostenstellen (mid, kstid, kst_name, activated) VALUES (:mid, :kstid, :kst_name, :activated)");
            $sql->bindParam(':mid', $mid);
            $sql->bindParam(':kstid', $kstid);
            $sql->bindParam(':kst_name', $kst_name);
            $sql->bindParam(':activated', $activated);
            if ($sql->execute()) {
                $Alert = 'Die Kostenstelle '.$kstid.' (M'.$mid.': '.$kst_name.')'.' wurde angelegt.';
                $AlertTheme = 'success';
            }
        } else {
            $Alert = 'Diese Kostenstelle existiert bereits.';
            $AlertTheme = 'danger';
        }
    }

    // Kostenstelle bearbeiten
    $sql_snippet = array();
    if (isset($_POST['submit-edit-kst'])) {
        if ($_POST['mid']!='') {
            $mid = $_POST['mid'];
            $sql_snippet[] .= 'mid = :mid';
        }
        if ($_POST['kstid']!='') {
            $kstid = intval($_POST['kstid']);
            $sql_snippet[] .= 'kstid = :kstid';
        }
        if ($_POST['kst_name']!='') {
            $kst_name = $_POST['kst_name'];
            $sql_snippet[] .= 'kst_name = :kst_name';
        }
        if ($_POST['activated']!='') {
            $activated = $_POST['activated'];
            $sql_snippet[] .= 'activated = :activated';
        } else {$sql_snippet[] .= 'activated = NULL';}
        if ($_POST['deactivated']!='') {
            $deactivated = $_POST['deactivated'];
            $sql_snippet[] .= 'deactivated = :deactivated';
        } else {$sql_snippet[] .= 'deactivated = NULL';}

        $edit_rows = count($sql_snippet);
        $sql_string = '';
        foreach ($sql_snippet as $key => $value) {
            if ($key != $edit_rows - 1) {
                $sql_snippet[$key] .=', ';
            }
            $sql_string .= $sql_snippet[$key];
        }

        $sql_query = "UPDATE kostenstellen SET $sql_string WHERE kstid = $id";
        $sql = $db_finance->prepare($sql_query);

        if(isset($mid)){$sql->bindParam(':mid', $mid);}
        if(isset($kstid)){$sql->bindParam(':kstid', $kstid);}
        if(isset($kst_name)){$sql->bindParam(':kst_name', $kst_name);}
        if(isset($activated)){$sql->bindParam(':activated', $activated);}
        if(isset($deactivated)){$sql->bindParam(':deactivated', $deactivated);}

        if ($sql->execute()) {
            $Alert = 'Die Kostenstelle '.$kstid.' (M'.$mid.': '.$kst_name.')'.' wurde verändert.';
            $AlertTheme = 'success';

        }

    }
?>
