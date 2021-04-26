<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_POST = array_map('trim', $_POST);
    $_POST = array_map('strtoupper', $_POST);

    var_dump($_FILES);
    $uploadDir = 'upload/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

    //securisation//
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $extensions_ok = ['jpg', 'jpeg', 'png'];
    $maxFileSize = 2000000;
    if ((!in_array($extension, $extensions_ok))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
    }
    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 2M !";
    }
    //upload//
    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
}

if (!empty($_GET['remove_avatar'])) {
    unlink($uploadFile);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Upload ton File</title>
</head>

<body>

    <div class="container">
        <h2>Présente-toi</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <p><i>Complètes le formulaire. Les champs marqués d'un astérix </i><em>*</em> sont <em>obligatoires</em></p>
            <fieldset>
                <legend>Contact</legend>
                <label for="nom">Prénom <em>*</em></label>
                <input id="firstname" name="firstname" placeholder="Prénom" autofocus="" required=""><br>

                <label for="nom">Nom <em>*</em></label>
                <input id="lastname" name="lastname" placeholder="Nom" required=""><br>

                <label for="phone">Portable</label>
                <input id="phone" name="phone" type="tel" placeholder="06xxxxxxxx" pattern="[0-9]{10}"><br>

                <label for="email">Email <em>*</em></label>
                <input id="email" name="email" type="email" placeholder="prenom.nom@rencontre.com" required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"><br>
            </fieldset>
            <fieldset>
                <legend>Information personnelles</legend>
                <label for="address">Adresse<em>*</em></label>
                <input id="address" name="address" type="text" placeholder="XX route du bonheur" required=""><br>

                <label for="cp">Code Postal<em>*</em></label>
                <input id="cp" name="cp" type="number" placeholder="xxxxx" pattern="[0-9]{5}" required=""><br>

                <label for="city">Ville<em>*</em></label>
                <input id="city" name="city" type="text" placeholder="HEAVEN" required=""><br>

                <label for="sex">Sexe</label>
                <select id="sex" name="sex">
                    <option value="F">Femme</option>
                    <option value="H">Homme</option>
                </select><br>

                <label for="hair">Cheveux ?</label>
                <select id="hair" name="hair">
                    <option value="none">Aucun</option>
                    <option value="short">Courts</option>
                    <option value="long">Longs</option>
                </select><br>
            </fieldset>

            <fieldset>
                <h2> Choisi ta plus belle photo de profil</h2>
                <label for="imageUpload">Choisi un fichier</label>
                <input type="file" name="avatar" id="imageUpload" />
                <button name="send">Send</button>
            </fieldset>
            <fieldset class="error-message">
                <?php
                if (!empty($errors)) {
                    unlink($uploadFile);
                }    ?>
            </fieldset>
        </form>
    </div>


    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-6 picture">
                <?php if (!empty($_FILES['avatar']['name'])) { ?>
                    <img src="/upload/<?= $_FILES['avatar']['name'] ?>" class="card-img" alt="avatar">
                    <a href="?remove_avatar" class="btn btn-danger">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Supprimer la photo
                    </a>
                <?php } else { ?>
                    No picture to display
                <?php }; ?>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title">TAXICAB </br>LICENSE</h5>
                    <p class="card-text">
                        <?php if (isset($_POST['firstname']) && isset($_POST['lastname'])) : ?>
                    <div class="profil-input name"><?= $_POST['lastname'] . $_POST['firstname'] ?></div>
                    <div class="profil-input address"><?= $_POST['address'] ?></div>
                    <div class="profil-input address"><?= $_POST['cp'] . $_POST['city'] ?></div>
                    <div class="profil-input sex">SEX : <?= $_POST['sex'] ?></div>
                    <div class="profil-input hair">HAIR : <?= $_POST['hair'] ?></div>
                <?php else : ?>
                    <div class="profil-input name">NOM Prénom</div>
                    <div class="profil-input address">addresse</div>
                    <div class="profil-input address">XXXXX ville</div>
                    <div class="profil-input sex">SEX :</div>
                    <div class="profil-input hair">HAIR :</div>
                <?php endif ?>
                </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>