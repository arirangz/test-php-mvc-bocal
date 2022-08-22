<?php /* @var $client \App\Entity\Client */ ?>
    <?php if ($message) { ?>
        <div class="alert alert-success" role="alert">
            <?=$message; ?>
        </div>
    <?php } ?>
    <div class="form-group">
        <label for="first_name">Prénom</label>
        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John" value="<?=$client->getFirstName(); ?>">
        <?php if (isset($errors['first_name'])) { ?>
        <div class="text-danger">
            <?=$errors['first_name']; ?>
        </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="last_name">Nom</label>
        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Doe" value="<?=$client->getLastName(); ?>">
        <?php if (isset($errors['last_name'])) { ?>
            <div class="text-danger">
                <?=$errors['last_name']; ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="lastname">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="example@example.com" value="<?=$client->getEmail(); ?>">
        <?php if (isset($errors['email'])) { ?>
            <div class="text-danger">
                <?=$errors['email']; ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="phone">Téléphone (optionnel)</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="0123456789" value="<?=$client->getPhone(); ?>">
    </div>