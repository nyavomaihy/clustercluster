<?php
require_once "../code.php";
session_start();

if (isset($_POST['nom']))
  $_SESSION['nom'] = $_POST['nom'];

if (isset($_SESSION['nom']))
  $nom = $_SESSION['nom'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Serveur</title>
</head>

<body>
  <h1>Serveur 2</h1>

  <?php if (isset($nom)) : ?>
    <h2>Votre couleur préférée est : <?= $nom ?></h2>
  <?php endif; ?>

  <form method="post">
    <input type="text" name="nom" />
    <input type="submit" value="Envoyer">
  </form>
</body>

</html>