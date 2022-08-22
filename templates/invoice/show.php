<?php
    use App\Tools\FormatTools;
    require_once _ROOTPATH_.'\templates\header.php'
    /* @var $invoice \App\Entity\Invoice */

?>
<h1>Facture</h1>
<?php if ($invoice) { ?>
    <dl class="dl-horizontal">
        <dt>Id</dt>
        <dd><?=$invoice->getId(); ?></dd>
        <dt>Numéro</dt>
        <dd><?=htmlentities($invoice->getNumber()); ?></dd>
        <dt>Date</dt>
        <dd><?=$invoice->getDate()->format('d/m/Y'); ?></dd>
        <dt>Titre</dt>
        <dd><?=htmlentities($invoice->getTitle()); ?></dd>
        <dt>Total HT</dt>
        <dd><?=FormatTools::formatPrice($invoice->getTotalTaxExcl()); ?></dd>
        <dt>Total TTC</dt>
        <dd><?=FormatTools::formatPrice($invoice->getTotalTaxIncl()); ?></dd>
        <dt>Taux TVA</dt>
        <dd><?=FormatTools::formatPercentage($invoice->getTaxRate()); ?></dd>
        <dt>Client</dt>
        <dd><?=htmlentities($invoice->getClient()->getFullname()); ?></dd>
    </dl>
<?php } elseif ($invoice === false) { ?>
    <p>La facture n'existe pas</p>
<?php } ?>

<?php
    require_once _ROOTPATH_.'\templates\footer.php'
?>