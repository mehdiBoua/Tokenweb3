<?php
// public/chefop/add_address.php

use App\Web3Client;
use App\Utils;

require_once __DIR__ . '/../../vendor/autoload.php';

$config = require_once __DIR__ . '/../../config/config.php';

// Liste des contrats disponibles
$contracts = [
    'TL' => [
        'name' => 'MyTokenlogistique',
        'function' => 'addAdressL',
    ],
    '???' => [
        'name' => 'MyTokencreationpersonnel',
        'function' => 'addAdressChefop',
    ],
    '???' => [
        'name' => 'MyTokenmissioncompleteeCO',
        'function' => 'addAdressChefop',
    ]
    '???' => [
        'name' => 'MyTokenmissioncompleteePC',
        'function' => 'addAdressPC',
    ]
];

$message = null;
$erreur = null;

// Vérifier si une requête POST a été envoyée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token_type'])) {
    $tokenType = $_POST['token_type'];
    $address = $_POST['address'];

    if (isset($contracts[$tokenType]) && isset($address)) {
        // Récupérer les informations du contrat
        $contractData = $contracts[$tokenType];

        // Instancier le client Web3 pour ce contrat
        $client = new Web3Client(
            $config['rpc_url'],
            $config['contracts'][$contractData['name']]['address'],
            $config['contracts'][$contractData['name']]['abi'],
            $config['contracts'][$contractData['name']]['private_key']
        );

        if (Utils::isValidEthereumAddress($nouvelleAdresse)) {
            try {
                // Appeler la fonction addAdressChefop
                $txHash = $client->sendTransaction($contractData['function'], [$nouvelleAdresse]);
                $message = "adresse ajoutée avec succès ! Hash : " . htmlspecialchars($txHash);
            } catch (\Exception $e) {
                $erreur = $e->getMessage();
            }
        } else {
            $erreur = "Adresse Ethereum invalide.";
        }
}

/*$client = new Web3Client(
    $config['rpc_url'],
    $config['contracts']['MyTokenchefop']['address'],
    $config['contracts']['MyTokenchefop']['abi'],
    $config['contracts']['MyTokenchefop']['private_key']
);*/

/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouvelleAdresse = $_POST['addresse'];

    if (Utils::isValidEthereumAddress($nouvelleAdresse)) {
        try {
            // Appeler la fonction addAdressChefop
            $txHash = $client->sendTransaction('addAdressChefop', [$nouvelleAdresse]);
            $message = "Transaction envoyée avec succès ! Hash : " . htmlspecialchars($txHash);
        } catch (\Exception $e) {
            $erreur = $e->getMessage();
        }
    } else {
        $erreur = "Adresse Ethereum invalide.";
    }
}*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter une Adresse Autorisée</title>
</head>
<body>
    <h1>Ajouter une Adresse Autorisée à MyTokenchefop</h1>
    <?php if (isset($message)): ?>
        <p style="color:green;"><?= $message ?></p>
    <?php endif; ?>
    <?php if (isset($erreur)): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="adresse">Nouvelle Adresse Ethereum :</label>
        <input type="text" id="address" name="address" required>
        <button type="submit" name="token_type" value="TC">Ajouter d'une adresse commandant autorisée</button>
        <button type="submit" name="token_type" value="TL">Ajouter d'une adresse logistique autorisée</button>
        <button type="submit" name="token_type" value="missionCO">Ajouter d'une adresse chefopmission autorisée</button>
        <button type="submit" name="token_type" value="missionPC">Ajouter d'une adresse PCmission autorisée</button>
        <button type="submit" name="token_type" value="personnel">Ajouter d'une adresse chefoppersonnel autorisée</button>

    
    </form>
    <p><a href="index.php">Retour à la Gestion de MyTokenchefop</a></p>
</body>
</html>
