<?php 
    $service = 'cockpit';
    require 'components/header.php';
?>
    <div class="salutation shadow-sm
    <?php 
            if (date('H')<= 11) {echo 'morning';}
            if (date('H')<= 17) {echo 'afternoon';}
            if (date('H')>= 17) {echo 'evening';}
        ?>">
        <h1>
            <?php 
                if (date('H')<= 11) {echo 'Guten Morgen';}
                if (date('H')<= 17) {echo 'Guten Tag';}
                if (date('H')>= 17) {echo 'Guten Abend';}
            ?>
        </h1>
    </div>

    <div class="choose-app mt-5 row">
        <a href="/finance" class="app-link col">
            <div class="tile-finance app-item">
                <i class="fa-app fa-solid fa-file-invoice-dollar"></i>
                <div class="title">Northware Finance</div>
            </div>
        </a>
        <a href="/hures" class="app-link col">
            <div class="tile-hures app-item">
                <i class="fa-app fa-solid fa-people-group"></i>
                <div class="title">Northware HuRes</div>
            </div>
        </a>
        <a href="/trader" class="app-link col">
            <div class="tile-trader app-item">
                <i class="fa-app fa-solid fa-dolly"></i>
                <div class="title">Northware Trader</div>
            </div>
        </a>
    </div>
<?php require 'components/footer.php' ?>