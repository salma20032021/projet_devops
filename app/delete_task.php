<?php
session_start();
include "DB.php";

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID manquant";
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "DELETE FROM tasks WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    $_SESSION['message'] = "Tache supprimee";
} else {
    $_SESSION['error'] = mysqli_error($conn);
}

header("Location: index.php");
exit();


$id = intval($_GET['id']);

// Si le formulaire de confirmation est soumis
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['confirm']) && $_POST['confirm'] === 'Oui') {
        $sql = "DELETE FROM tasks WHERE id = $id";
        if(mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "Tâche supprimée avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression : " . mysqli_error($conn);
        }
    }
    header("Location: index.php");
    exit();
}

// Récupérer la tâche pour affichage
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $id");
$task = mysqli_fetch_assoc($result);
if(!$task) {
    $_SESSION['error'] = "Tâche introuvable !";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer la tâche</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .confirm-container {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #e74c3c;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 25px;
            color: #555;
        }
        button {
            padding: 12px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .oui {
            background-color: #e74c3c;
            color: #fff;
        }
        .oui:hover {
            background-color: #c0392b;
        }
        .non {
            background-color: #ccc;
            color: #333;
        }
        .non:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body>
    <div class="confirm-container">
        <h2>Confirmer la suppression</h2>
        <p>Voulez-vous vraiment supprimer la tâche : <strong><?= htmlspecialchars($task['title']) ?></strong> ?</p>
        <form method="post">
            <button type="submit" name="confirm" value="Oui" class="oui">Oui</button>
            <button type="submit" name="confirm" value="Non" class="non">Non</button>
        </form>
    </div>
</body>
</html>