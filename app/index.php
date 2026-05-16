<?php 
session_start(); 
include "DB.php"; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .message {
            text-align: center;
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .task-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }
        .task-form input[type="text"] {
            flex: 1;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        .task-form button {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }
        .task-form button:hover {
            background-color: #45a049;
        }
        .task-table {
            width: 100%;
            border-collapse: collapse;
        }
        .task-table th, .task-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .task-table th {
            background-color: #f7f7f7;
        }
        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            font-size: 14px;
            margin-right: 5px;
            transition: 0.3s;
        }
        .edit-btn {
            background-color: #3498db;
        }
        .edit-btn:hover {
            background-color: #2980b9;
        }
        .delete-btn {
            background-color: #e74c3c;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .no-task {
            text-align: center;
            color: #888;
            font-style: italic;
        }
        @media (max-width: 600px) {
            .task-form {
                flex-direction: column;
            }
            .edit-btn, .delete-btn {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Liste des tâches</h2>

    <?php if(isset($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <!-- Formulaire -->
    <form action="add_task.php" method="POST" class="task-form">
        <input type="text" name="title" placeholder="Nom" required>
        <input type="text" name="description" placeholder="Description">
        <button type="submit">Ajouter</button>
    </form>

    <!-- Tableau des tâches -->
    <?php
    if (!$conn) die("<p style='color:red;'>Erreur de connexion</p>");

    $sql = "SELECT * FROM tasks";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0):
    ?>
        <table class="task-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="edit-btn">Modifier</a>
                        <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Supprimer ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-task">Aucune tâche pour le moment</p>
    <?php endif; ?>

</div>

</body>
</html>