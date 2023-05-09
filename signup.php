<?php
// I, Johnson Li, certify that this submission is my own original work
$conn = mysqli_connect("localhost", "usersp23", "passwdsp23", "bcs350sp23");

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get form data
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirm_password']);

    // Check if any input field is empty
    if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        echo "<script>alert('Please fill in all required fields');</script>";
        exit("<script>location.href='$_SERVER[PHP_SELF]';</script>");
    }

    // Check if the username is at least 6 characters long
    if (strlen($username) < 6) {
        echo "<script>alert('Username must be at least 6 characters long');</script>";
        exit("<script>location.href='$_SERVER[PHP_SELF]';</script>");
    }

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address');</script>";
        exit("<script>location.href='$_SERVER[PHP_SELF]';</script>");
    }

    // Check if the password is at least 8 characters long
    if (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long');</script>";
        exit("<script>location.href='$_SERVER[PHP_SELF]';</script>");
    }

    // Check if the password contains at least one lowercase letter, one uppercase letter, and one numeric digit
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
        echo "<script>alert('Password must contain at least one lowercase letter, one uppercase letter, and one numeric digit');</script>";
        exit("<script>location.href='$_SERVER[PHP_SELF]';</script>");
    }

    // Check if the password and confirm password match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match');</script>";
        exit("<script>location.href='$_SERVER[PHP_SELF]';</script>");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        // Start the session
        session_start();

        // Set session variables
        $_SESSION['username'] = $username;

        // Redirect to mainmenu.php
        header("Location: mainmenu.php");
        exit();
    } else {
        echo "<script>alert('Error registering user.');</script>";
        exit("<script>location.href='$_SERVER[PHP_SELF]';</script>");
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <script>
        const signupForm = document.getElementById('signup-form');
        const signupBtn = document.getElementById('signup-btn');
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        // Function to validate the form inputs
        function validateForm() {
            // Check if any input field is empty
            if (!usernameInput.value || !emailInput.value || !passwordInput.value || !confirmPasswordInput.value) {
                alert('Please fill in all required fields');
                return false;
            }

            // Check if the username is at least 6 characters long
            if (usernameInput.value.length < 6) {
                alert('Username must be at least 6 characters long');
                return false;
            }

            // Check if the email is valid
            if (!/\S+@\S+\.\S+/.test(emailInput.value)) {
                alert('Please enter a valid email address');
                return false;
            }

            // Check if the password is at least 8 characters long
            if (passwordInput.value.length < 8) {
                alert('Password must be at least 8 characters long');
                return false;
            }

            // Check if the password contains at least one lowercase letter, one uppercase letter, and one numeric digit
            if (!/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/.test(passwordInput.value)) {
                alert('Password must contain at least one lowercase letter, one uppercase letter, and one numeric digit');
                return false;
            }

            // Check if the password and confirm password match
            if (passwordInput.value !== confirmPasswordInput.value) {
                alert('Passwords do not match');
                return false;
            }

            return true;
        }

        // Add an event listener to the submit button to validate the form before submission
        signupBtn.addEventListener('click', (event) => {
            if (!validateForm()) {
                event.preventDefault();
            }
        });
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            text-align: center;
        }

        html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        form {
            display: inline-block;
            padding: 30px;
            border-radius: 10px;
            background: linear-gradient(to bottom, #fff, #f9f9f9);
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
        }



        label {
            color: #555;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            max-width: 300px;

            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #555;
            background-color: #f5f5f5;
        }


        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn {
            display: inline-block;
            background-color: #0062cc;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0062cc;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Signup Form
        </h2>

        <form id="signup-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="text-center">
                <button type="submit" id="signup-btn" class="btn btn-primary" name="submit">Register</button>

            </div>
            <a href="login.php" class="link">Already have an account? Login</a>
        </form>

    </div>


</body>

</html>