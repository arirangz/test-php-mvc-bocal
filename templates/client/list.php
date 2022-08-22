<?php
    require_once _ROOTPATH_.'\templates\header.php'
    /* @var $client \App\Entity\Invoice */

?>
<h1>Clients</h1>
    <div class="row">
        <div class="col-12">
            <a href="index.php?controller=client&action=new" class="btn btn-outline-primary">Ajouter un client</a>
        </div>
    </div>

<?php if ($clients) { ?>
    <table class="table">
        <thead>
            <th>Id</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </thead>
        <tbody>
        <?php foreach ($clients as $client) { ?>
            <tr>
                <td><?=$client->getId(); ?></td>
                <td><?=htmlentities($client->getFirstName()); ?></td>
                <td><?=htmlentities($client->getLastName()); ?></td>
                <td><?=htmlentities($client->getEmail()); ?></td>
                <td><?=htmlentities($client->getPhone()); ?></td>
                <td><a href="index.php?controller=client&action=show&id=<?=$client->getId(); ?>">Afficher</a>
                    | <a href="index.php?controller=client&action=edit&id=<?=$client->getId(); ?>">Modifier</a>
                    | <a href="index.php?controller=client&action=delete&id=<?=$client->getId(); ?>">Supprimer</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } elseif ($clients === false) { ?>
    <p>Aucun client</p>
<?php } ?>

<?php
    require_once _ROOTPATH_.'\templates\footer.php'
?>