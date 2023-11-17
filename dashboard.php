<?php
// Start the session to access user data
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

// Fetch additional user information from the database
$sql = "SELECT * FROM etudiant WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    // Handle the case where user data is not found
    // Redirect to logout to clear the session and go back to the login page
    header("Location: logout.php");
    exit();
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
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #dddddd;
            font-family: 'Arial', sans-serif;
            background-image: url(".idea/img/bg1.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .dashboard-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 90%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
        }

        .user-info {
            margin-top: 20px;
            height: 50%;
            margin-top: 100px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #39A6A3;
            color: #fff;
        }
        h3{
            text-transform: uppercase;
            font-family: "Raleway Black" ;
            font-size: 30px;

        }
    </style>
</head>
<body>
<div class="dashboard-box">
    <h3>Bienvenue, <?php echo $user_nom . ' ' . $user_prenom; ?>!</h3>
    <div class="user-info">
        <p><strong>Votre Profile:</strong></p>
        <table>
<!--            <tr>-->
<!--                <th>Field</th>-->
<!--                <th>Value</th>-->
<!--            </tr>-->
            <tr>
                <td>Apogee</td>
                <td><?php echo $user_data['Apogee']; ?></td>
            </tr>
            <tr>
                <td>CIN</td>
                <td><?php echo $user_data['cin']; ?></td>
            </tr>
            <tr>
                <td>CNE</td>
                <td><?php echo $user_data['cne']; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $user_data['email']; ?></td>
            </tr>
            <tr>
                <td>Filière</td>
                <td><?php echo $user_data['filiere']; ?></td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td><?php echo $user_data['date_naissance']; ?></td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
    </div>
</div>
</body>
</html>
