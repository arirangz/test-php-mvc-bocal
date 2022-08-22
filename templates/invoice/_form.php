<?php /* @var $invoice \App\Entity\Invoice */ ?>
    <?php if ($message) { ?>
        <div class="alert alert-success" role="alert">
            <?=$message; ?>
        </div>
    <?php } ?>
    <div class="form-group">
        <label for="client_id">Client</label>
        <select class="form-control" id="client_id" name="client_id">
            <?php foreach ($clients as $client) { ?>
                <?php /* @var $client \App\Entity\Client */ ?>
                <option value="<?=$client->getId()?>" <?php if ($client->getId() === $invoice->getClientId()) { echo 'selected=selected'; }?>>
                    <?=$client->getFullname().' (id:'.$client->getId().')'?>
                </option>
            <?php } ?>
        </select>
        <?php if (isset($errors['client_id'])) { ?>
            <div class="text-danger">
                <?=$errors['client_id']; ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <label for="first_name">Date (YYYY/MM/JJ)</label>
        <input type="text" class="form-control" id="date" name="date" value="<?=$invoice->getDate()->format('Y-m-d'); ?>">
        <?php if (isset($errors['date'])) { ?>
        <div class="text-danger">
            <?=$errors['date']; ?>
        </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="last_name">Titre</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="" value="<?=$invoice->getTitle(); ?>">
        <?php if (isset($errors['title'])) { ?>
            <div class="text-danger">
                <?=$errors['title']; ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="lastname">Total HT</label>
        <input type="text" class="form-control" id="total_tax_excl" name="total_tax_excl" value="<?=$invoice->getTotalTaxExcl(); ?>">
        <?php if (isset($errors['total_tax_excl'])) { ?>
            <div class="text-danger">
                <?=$errors['total_tax_excl']; ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="lastname">Taux TVA</label>
        <input type="text" class="form-control" id="tax_rate" name="tax_rate"  value="<?=$invoice->getTaxRate(); ?>">
        <?php if (isset($errors['tax_rate'])) { ?>
            <div class="text-danger">
                <?=$errors['tax_rate']; ?>
            </div>
        <?php } ?>
    </div>