<?php
// Include the database connection file
include 'db.php';

// Assuming the student's ID is available in the session
// You may need to modify this based on your authentication system
session_start();
$student_id = $_SESSION['user_id'];

// Fetch the student's filiere and semester from the database
$sql_student_info = "SELECT filiere FROM etudiant WHERE id = $student_id";
$result_student_info = $conn->query($sql_student_info);

if ($result_student_info->num_rows > 0) {
    $row_student_info = $result_student_info->fetch_assoc();
    $student_filiere = $row_student_info['filiere'];
} else {
    // Handle the case where the filiere is not found
    echo "Error: Filière introuvable pour l'élève. Contactez l'Administrateur";
    exit();
}

// Handle form submission to choose semester
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_semester = $_POST['selected_semester'];
} else {
    // Default to the first semester if not submitted
    $selected_semester = 1;
}

// Fetch timetable for the selected filiere and semester
$sql_timetable = "SELECT timetable_link FROM emplois_du_temps WHERE filiere = '$student_filiere' AND semestre = $selected_semester";
$result_timetable = $conn->query($sql_timetable);

if ($result_timetable->num_rows > 0) {
    $row_timetable = $result_timetable->fetch_assoc();
    $timetable_link = $row_timetable['timetable_link'];
} else {
    // Handle the case where the timetable is not found
    $timetable_link = "Aucun Emplois Du temps trouvé pour la filière et le semestre sélectionnés.";
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
    <title>Student - Emploi du Temps</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            margin-right: 10px;
            color: #333;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        h3 {
            text-align: center;
            color: #333;
        }

        .content-iframe {
            width: 80%;
            height: 400px; /* Adjust the height based on your content */
            border: 1px solid #ccc;
            margin-top: 10px;
        }

        p {
            font-size: 16px;
            color: #333;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h2>Student - Emploi du Temps</h2>

<!-- Form to choose semester -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>Choose Semester:</label>
    <select name="selected_semester" onchange="this.form.submit()">
        <?php for ($i = 1; $i <= 6; $i++) : ?>
            <option value="<?php echo $i; ?>" <?php echo ($selected_semester == $i) ? 'selected' : ''; ?>>Semester <?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
</form>

<!-- Display content of the timetable link -->
<h3>Timetable for <?php echo $student_filiere; ?> - Semester <?php echo $selected_semester; ?>:</h3>
<div class="content-iframe">
    <?php echo file_get_contents($timetable_link); ?>
</div>
</body>
</html>
