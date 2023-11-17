<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db.php';

// Access user data from the session
$user_id = $_SESSION['user_id'];
$user_nom = $_SESSION['user_nom'];
$user_prenom = $_SESSION['user_prenom'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $document_type = $_POST['document_type'];
    $description = $_POST['description'];

    // Validate input to prevent SQL injection
    $document_type = mysqli_real_escape_string($conn, $document_type);
    $description = mysqli_real_escape_string($conn, $description);

    // Insert the request into the database
    $sql = "INSERT INTO demandes (student_id, document_type, description) VALUES ('$user_id', '$document_type', '$description')";
    $result = $conn->query($sql);

    if ($result) {
        $success_message = "Votre demande a été soumise avec succès.";
    } else {
        $error_message = "Erreur lors de la soumission de la demande. Veuillez réessayer une autrefois.";
    }
}

// Close the database connection
$conn->close();
?>

<nav class="navbar navbar-expand-lg">
    <?php include 'navbar.php'; ?>
</nav>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }

        .demande-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
        }
        select{
            width: 60%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 25px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #39A6A3;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message {
            margin-top: 20px;
            color: #39A6A3;
        }
    </style>
</head>
<body>
<div class="demande-box">
    <h2>Soumettre une demande de document</h2>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (isset($success_message)) : ?>
        <p class="message"><?php echo $success_message; ?></p>
    <?php else : ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label>Type de document:</label>
            <select name="document_type" required>
                <option value="" disabled selected>Sélectionnez le type de document</option>
                <option value="Attestation de scolarité">Attestation de scolarité</option>
                <option value="Relevé de note">Relevé de note</option>
                <!-- Add more document types as needed -->
            </select>

            <label>Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <button type="submit">Envoyer la demande</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
