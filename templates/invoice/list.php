<?php
use App\Tools\FormatTools;
require_once _ROOTPATH_.'\templates\header.php'

/* @var $invoice \App\Entity\Invoice */

?>
    <h1>Factures</h1>
    <div class="row">
        <div class="col-12">
            <a href="index.php?controller=invoice&action=new" class="btn btn-outline-primary">Ajouter une facture</a>
        </div>
    </div>

<?php if ($invoices) { ?>
    <table class="table">
        <thead>
        <th>Id</th>
        <th>Number</th>
        <th>Date</th>
        <th>Titre</th>
        <th>Total HT</th>
        <th>Total TTC</th>
        <th>Taux TVA</th>
        <th>Actions</th>

        </thead>
        <tbody>
        <?php foreach ($invoices as $invoice) { ?>
            <tr>
                <td><?=$invoice->getId(); ?></td>
                <td><?=htmlentities($invoice->getNumber()); ?></td>
                <td><?=$invoice->getDate()->format('d/m/Y'); ?></td>
                <td><?=htmlentities($invoice->getTitle()); ?></td>
                <td><?=FormatTools::formatPrice($invoice->getTotalTaxExcl()); ?></td>
                <td><?=FormatTools::formatPrice($invoice->getTotalTaxIncl()); ?></td>
                <td><?=FormatTools::formatPercentage($invoice->getTaxRate()); ?></td>

                <td><a href="index.php?controller=invoice&action=show&id=<?=$invoice->getId(); ?>">Afficher</a>
                    | <a href="index.php?controller=invoice&action=edit&id=<?=$invoice->getId(); ?>">Modifier</a>
                    | <a href="index.php?controller=invoice&action=delete&id=<?=$invoice->getId(); ?>">Supprimer</a></td>
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