<?php
    require_once _ROOTPATH_.'\templates\header.php';

?>
<h1>Modification client</h1>

<form method="POST">
    <?php require_once '_form.php' ?>
    <button type="submit" name="submitEditClient" class="btn btn-primary">Submit</button>

</form>

<?php
    require_once _ROOTPATH_.'\templates\footer.php'
?>