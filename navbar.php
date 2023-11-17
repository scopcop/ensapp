<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>ENS</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar-vertical {
            height: 100%;
            position: fixed;
            top: 0;
            left: 0; /* Adjusted to 0 to keep it always displayed */
            z-index: 1000;
            width: 200px;
            background-color: #EBFAFC;
            padding-top: 2rem;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            transition: left 0.3s ease;
        }

        .navbar-vertical a {
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: #495057;
            display: block;
            transition: background-color 0.3s ease;
        }

        .navbar-vertical a:hover {
            background-color: #e2e6ea;
        }



        .navbar-vertical .dropdown-content {
            display: none;
            background-color: #cccccc; /* Set your desired background color */
        }

        .navbar-vertical .dropdown-content a {
            color: white; /* Set the text color for dropdown items */
            padding: 12px 16px;
            display: block;
            text-decoration: none;
        }

        .navbar-vertical .dropdown-content a:hover {
            background-color: #333333; /* Change color on hover if needed */
        }

        .navbar-vertical .dropdown:hover .dropdown-content {
            display: block;
        }

        .content {
            margin-left: 200px;
            padding: 2rem 1rem 1rem 200px;
            transition: margin-left 0.3s ease;
        }

        .navbar-toggle {
            display: none;
        }

        .logo-space {
            padding-top: 2rem;
            text-align: center;
        }

        .logo {
            max-width: 100%;
            height: auto;
        }

        a {
            margin-top: 15px;
        }

        p {
            font-family: "Segoe UI Black";
            margin-bottom: 0;
            text-transform: uppercase;
        }
        .logo-space{
            margin-bottom: 60px; !important;
        }

    </style>
</head>

<body>
<div class="navbar-vertical">
    <img class="fit-picture" src=".idea/img/ens.png" alt="logo" width="100%" height="10%" />
    <div class="logo-space">
        <?php
        include 'db.php';

        $etudiantNameQuery = "SELECT nom FROM etudiant";
        $etudiantNameResult = $conn->query($etudiantNameQuery);
        $etudiantname = ($etudiantNameResult && $etudiantNameResult->num_rows > 0) ? $etudiantNameResult->fetch_assoc()['nom'] : 'etudiant name';
        ?>
        <p class="text"><?php echo $etudiantname; ?></p>
    </div>

        <a href="dashboard.php">Accueil</a>
        <a href="Emploi.php">Emploi du temps</a>
        <a href="resultat.php">les Resultats</a>
        <a href="demande.php">Demandes</a>





    <a href="login.php?logout=true">Déconnexion</a>
</div>

<script>
    // No need for a toggle function since the navbar is always displayed
</script>
</body>

</html>