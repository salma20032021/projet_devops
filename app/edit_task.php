<?php
session_start();
include "DB.php";

// Vérifier que l'id est présent
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Récupérer la tâche
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $id");
$task = mysqli_fetch_assoc($result);

if (!$task) {
    $_SESSION['message'] = "Tâche introuvable !";
    header("Location: index.php");
    exit();
}

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn, "UPDATE tasks SET title='$title', description='$description' WHERE id=$id");
    $_SESSION['message'] = "Tâche modifiée !";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la tâche</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: 500;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .message {
            text-align: center;
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modifier la tâche</h2>
        <?php if(isset($_SESSION['message'])) { ?>
            <div class="message"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php } ?>
        <form method="post">
            <label>Nom :</label>
            <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
            
            <label>Description :</label>
            <textarea name="description" required><?= htmlspecialchars($task['description']) ?></textarea>
            
            <button type="submit">Modifier</button>
        </form>
        <a class="back-link" href="index.php">← Retour à la liste</a>
    </div>
</body>
</html>