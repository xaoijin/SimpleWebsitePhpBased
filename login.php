<?php
// I, Johnson Li, certify that this submission is my own original work
session_start();
$conn = mysqli_connect("localhost", "usersp23", "passwdsp23", "bcs350sp23");

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: mainmenu.php");
    exit();
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // User is authenticated, start session
            $_SESSION['username'] = $username;
            header("Location: mainmenu.php");
            exit();
        } else {
            $errorMessage = "Incorrect password.";
        }
    } else {
        $errorMessage = "Incorrect username.";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();

}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <style>
        
        body {
            background-color: #181818;
            font-family: 'Helvetica Neue', sans-serif;
        }

        h1 {
            color: #fff;
            font-size: 36px;
            text-align: center;
            margin-top: 50px;
        }

        form {
            background-color: #282828;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            color: #fff;
            display: block;
            font-size: 16px;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            background-color: #b3b3b3;
            border: none;
            border-radius: 5px;
            color: #181818;
            display: block;
            font-size: 16px;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #1db954;
            border: none;
            border-radius: 20px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            height: 40px;
            margin-top: 20px;
            width: 400px;
        }

        input[type="submit"]:hover {
            background-color: #1ed760;
        }

        p {
            color: #ff1a1a;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .signup-button {
            background-color: #1db954;
            border: none;
            border-radius: 20px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            height: 40px;
            margin-top: 20px;
            width: 400px;
        }

        .signup-button:hover {
            background-color: #1ed760;
        }
    </style>

</head>

<body>
    <h1>Login</h1>
    <?php if (isset($errorMessage)) {
        echo "<p>$errorMessage</p>";
    } ?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Log In">
        <a href="signup.php"><button type="button" class="signup-button">Sign Up</button></a>
    </form>
</body>

</html>