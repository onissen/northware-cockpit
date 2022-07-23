<?php
    $service = 'cockpit';
    $siteTitle = '404 - Seite nicht gefunden';
    require '../components/header.php';
?>

<section class="error-section text-center">
    <img id="illustration404" class="img-fluid mb-5" src="http://northware-cockpit.test/utilities/404-illustration.png">
    <h1 class="error-title">Error 404</h1>
    <h3 class="error-description">Die Seite konnte nicht gefunden werden</h3>

    <a href="<?php echo getenv("HTTP_REFERER"); ?>" class="link-btn link-btn-primary">Zurück zur letzten Seite</a>
    <a href="http://northware-cockpit.test/" class="link-btn link-btn-primary">Zur Startseite</a>
</section>

<?php require '../components/footer.php' ?>