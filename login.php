<?php
// Start the session to store user data
session_start();

// Include the database connection file
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apogee = $_POST['apogee'];
    $cne = $_POST['cne'];
    $date_naissance = $_POST['date_naissance'];

    // Validate input to prevent SQL injection (you may need to improve this)
    $apogee = mysqli_real_escape_string($conn, $apogee);
    $cne = mysqli_real_escape_string($conn, $cne);
    $date_naissance = mysqli_real_escape_string($conn, $date_naissance);

    // Query to check if the user exists
    $sql = "SELECT * FROM etudiant WHERE apogee = '$apogee' AND cne = '$cne' AND date_naissance = '$date_naissance'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, store user data in session (you can customize this)
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];

        // Redirect to a dashboard or home page
        header("Location: dashboard.php");
        exit();
    } else {
        // User not found, display an error message
        $error_message = "Invalid credentials. Please try again.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url(.idea/img/background.jpg) no-repeat center center fixed;
            background-size: cover;
            font-family: sans-serif;
        }

        .login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-box img {
            display: block;
            margin: 0 auto;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .login-box label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-box input {
            width: 92%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .login-box button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #39A6A3;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>
<body>
<div class="login-box">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <img src=".idea/img/ens.png" alt="Profile Photo">
        <?php if (isset($error_message)) : ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <label>Apogee:</label>
        <input type="text" name="apogee" required><br>
        <label>CNE:</label>
        <input type="text" name="cne" required><br>
        <label>Date of Birth:</label>
        <input type="date" name="date_naissance" required><br>
        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>
