<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Collection View</title>
    </head>

    <body>
        <h1>Liste des contacts</h1>

        <?php foreach ($data as $contact) : ?>
            <div>
                <p>Nom : <?= $contact->getFirstName() . ' ' . $contact->getLastName() ?></p>
                <p>Email : <?= $contact->getEmail() ?></p>
                <p>Téléphone : <?= $contact->getPhone() ?></p>
                <p>Status : <?= $contact->getStatus() ?></p>
                <p>Créé le : <?= $contact->getCreatedAt()->format('d/m/Y H:i:s') ?></p>
            </div>
        <?php endforeach; ?>
    </body>

</html>