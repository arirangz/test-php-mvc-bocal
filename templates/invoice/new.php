<?php
    require_once _ROOTPATH_.'\templates\header.php';
    /* @var $client \App\Entity\Client */

?>
<h1>Nouvelle facture</h1>

<form method="POST">
    <?php require_once '_form.php' ?>
    <button type="submit" name="submitNewInvoice" class="btn btn-primary">Submit</button>

</form>

<?php
    require_once _ROOTPATH_.'\templates\footer.php'
?>