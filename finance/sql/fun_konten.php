<?php
    $sql_kto_class = "SELECT kto_classes.*, COUNT(kto_main.kto_class) AS quant_mainkto 
        FROM kto_classes LEFT JOIN kto_main ON kto_classes.classid = kto_main.kto_class 
        GROUP BY kto_classes.classid";
    
    $data_ktoclass = $db_finance->query($sql_kto_class)->fetchAll();


    // List Hauptkonten
    $number_ktomain = $db_finance->query("SELECT mainid FROM kto_main")->rowCount();
    if (isset($_REQUEST['qclass'])) {
        $qclass = $_REQUEST['qclass'];
        $list_ktomain = $db_finance->query("SELECT kto_main.*, kto_classes.class_name FROM kto_main LEFT JOIN kto_classes ON kto_main.kto_class = kto_classes.classid 
        WHERE kto_main.kto_class = $qclass ORDER BY mainid")->fetchAll();
    }

    if (isset($_POST['sub-newmain'])) {
        $mainid = $_POST['mainid'];
        $main_name = $_POST['main_name'];
        $kto_class = $_POST['kto_class'];
        $impact = $_POST['impact'];

        $stmt = $db_finance->prepare("SELECT * FROM kto_main WHERE mainid = :mainid");
        $stmt->bindParam(":mainid", $mainid);
        $stmt->execute();

        $rowExists = $stmt->fetchColumn();

        if (!$rowExists) {
            $sql = $db_finance->prepare("INSERT INTO kto_main (mainid, main_name, kto_class, impact) VALUES(:mainid, :main_name, :kto_class, :impact)");
            $sql->bindParam(':mainid', $mainid);
            $sql->bindParam(':main_name', $main_name);
            $sql->bindParam(':kto_class', $kto_class);
            $sql->bindParam(':impact', $impact);

            if ($sql->execute()) {
                $Alert = 'Das Hauptkonto '.$mainid.' / '.$main_name.' wurde angelegt.';
                $AlertTheme = 'success';
            }
        }
    }

    if (isset($_REQUEST['mainid']) AND $_REQUEST['mainid'] != 'new') {
        // Hauptkonto bearbeiten
        $mainid = $_REQUEST['mainid'];
        $this_ktomain = $db_finance->query("SELECT * FROM kto_main WHERE mainid = $mainid")->fetchObject();

        if (isset($_POST['sub-editmain'])) {
            $sql_snippet = array();
            if ($_POST['main_name'] != '') {
                $main_name = $_POST['main_name'];
                $sql_snippet[] .= 'main_name = :main_name';
            }

            if ($_POST['kto_class'] != '') {
                $kto_class = $_POST['kto_class'];
                $sql_snippet[] .= 'kto_class = :kto_class';
            }

            if ($_POST['impact'] != '') {
                $impact = $_POST['impact'];
                $sql_snippet[] .= 'impact = :impact';
            }

            $edit_rows = count($sql_snippet);
            $sql_string = '';
            foreach ($sql_snippet as $key => $value) {
                if ($key != $edit_rows - 1) {
                    $sql_snippet[$key] .=', ';
                }
                $sql_string .= $sql_snippet[$key];
            }

            
            $sql_query = "UPDATE kto_main SET $sql_string WHERE mainid = $mainid";
            $sql = $db_finance->prepare($sql_query);

            if(isset($main_name)){$sql->bindParam(':main_name', $main_name);}
            if(isset($kto_class)){$sql->bindParam(':kto_class', $kto_class);}
            if(isset($impact)){$sql->bindParam(':impact', $impact);}

            if ($sql->execute()) {
                $Alert = "Das Hauptkonto ".$mainid." / ".$main_name." wurde verändert.";
                $AlertTheme = 'success';
            }
        }
    }

    if (isset($_POST['sub-delmain']) AND $_POST['sub-delmain'] == 'deleteMainKto') {
        $mainid_delete = $_POST['mainid_delete'];

        $sql = $db_finance->prepare("DELETE FROM kto_main WHERE mainid = :delete_main");
        $sql->bindParam(':delete_main', $mainid_delete);
        if ($sql->execute()) {
            $Alert = 'Das Hauptkonto '.$mainid_delete.' wurde gelöscht.';
            $AlertTheme = 'success';
        }
    }
?>