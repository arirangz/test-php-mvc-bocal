
<?php
require_once _ROOTPATH_.'\templates\header.php'
?>
<?php if ($message) { ?>
    <div class="alert alert-danger" role="alert">
        <?=$message; ?>
    </div>
<?php } ?>

<?php
require_once _ROOTPATH_.'\templates\footer.php'
?>