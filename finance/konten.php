<?php
    $service = 'finance';
    $siteTitle = 'Kontenverwaltung';
    require '../components/header.php';
    include 'sql/fun_konten.php';
?>

<h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item text-primary">Kontenverwaltung</li>
        <?php
            if (isset($_REQUEST['type'])) {
                if ($_REQUEST['type'] == 'main') { 
                    if(isset($_GET['mainid'])) {?>
                    <li class="breadcrumb-item"><a href="?type=main">Hauptkonten</a></li> 
                    <?php if ($_GET['mainid'] == 'new') { ?> <li class="breadcrumb-item active">Neues Hauptkonto</li> <?php }
                        else { ?> <li class="breadcrumb-item active">Hauptkonto <?php echo $_GET['mainid'] ?> bearbeiten</li> <?php } ?>
                    <?php } else { ?> <li class="breadcrumb-item active">Hauptkonten</li> <?php }
                }
                if ($_REQUEST['type'] == 'class') { ?>
                    <li class="breadcrumb-item active">Kontenklassen</li> 
                <?php }
            } else { ?> <li class="breadcrumb-item active">Buchungskonten</li> <?php } ?>
    </ol>
</h2>

<div class="row">
    <nav class="col-md-3 col-lg-2 sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a href="konten.php" class="nav-link link-btn link-btn-primary">Buchungskonten</a>
                <a href="?type=main" class="nav-link link-btn link-btn-primary">Hauptkonten</a>
                <a href="?type=class" class="nav-link link-btn link-btn-primary">Kontenklassen</a>
            </li>
        </ul>
    </nav>

    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <?php if (isset($Alert)) { ?>
            <div class="alert alert-<?php echo $AlertTheme ?> alert-dismissible fade show" role="alert">
                <?php echo $Alert ?>
                
                <?php if (isset($_GET['mainid'])) {
                    if ($_GET['mainid'] == 'new') { ?>
                        <a href="konten.php?type=main&mainid=new" class="btn-close" role="button" aria-label="Close"></a>
                    <?php } else { ?>
                        <a href="konten.php?type=main&mainid=<?php echo $_GET['mainid'] ?>" class="btn-close" role="button" aria-label="Close"></a>
                    <?php }
                } ?>
            </div>
        <?php } ?>


        <?php if (!isset($_REQUEST['type'])) { ?>
            
        <?php } else { 
            if ($_REQUEST['type'] == 'main') { 
                include 'mng_mainkto.php';
            }
            if ($_REQUEST['type'] == 'class') { ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Bezeichnung</th>
                            <th>Hauptkonten</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data_ktoclass as $ktoclass) { ?>
                        <tr>
                            <td><?php echo $ktoclass['classid'] ?></td>
                            <td><?php echo $ktoclass['class_name'] ?></td>
                            <td><?php echo $ktoclass['quant_mainkto'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php }
        } ?>
    </div>
</div>

<?php require '../components/footer.php' ?>