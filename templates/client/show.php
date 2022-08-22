<?php
    require_once _ROOTPATH_.'\templates\header.php'
    /* @var $client \App\Entity\Client */

?>
<h1>Client</h1>
<?php if ($client) { ?>
    <dl class="dl-horizontal">
        <dt>Id</dt>
        <dd><?=$client->getId(); ?></dd>
        <dt>Prénom</dt>
        <dd><?=htmlentities($client->getFirstName()); ?></dd>
        <dt>Nom</dt>
        <dd><?=htmlentities($client->getLastName()); ?></dd>
        <dt>Email</dt>
        <dd><?=htmlentities($client->getEmail()); ?></dd>
        <dt>Téléphone</dt>
        <dd><?=htmlentities($client->getPhone()); ?></dd>
    </dl>
<?php } elseif ($client === false) { ?>
    <p>Le client n'existe pas</p>
<?php } ?>

<?php
    require_once _ROOTPATH_.'\templates\footer.php'
?>