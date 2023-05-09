<?php
session_start();

// check if user is logged in
if (!isset($_SESSION['username'])) {
    // user is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}
// logout user if requested
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Main Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            background-image: linear-gradient(to bottom right, #3366ff, #99ccff);
        }

        html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: whitesmoke;
        }

        ul {
            list-style: none;
            margin: 2rem auto;
            padding: 0;
            width: 50%;
            max-width: 500px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        li {
            border-bottom: 1px solid #ccc;
        }

        a {
            display: block;
            padding: 1rem;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #007bff;
            color: #fff;
        }

        a.active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <h1>Main Menu</h1>
    <ul>
        <li><a href="list.php">List Records</a></li>
        <li><a href="add.php">Add Record</a></li>
        <li><a href="search.php">Search Records</a></li>
        <li><a href="delete.php">Delete Record</a></li>
        <li><a href="?logout=true">Log Out</a></li>
    </ul>
</body>

</html>