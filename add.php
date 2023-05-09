<?php
// I, Johnson Li, certify that this submission is my own original work
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
// connect to database
$conn = mysqli_connect("localhost", "usersp23", "passwdsp23", "bcs350sp23");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO bakery_orders (customer_name, item_name, item_quantity, order_date, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsd", $customer_name, $item_name, $item_quantity, $order_date, $total);

    // Sanitize input data
    $customer_name = htmlspecialchars($_POST["customer_name"]);
    $item_name = htmlspecialchars($_POST["item_name"]);
    $item_quantity = htmlspecialchars($_POST["item_quantity"]);
    $order_date = htmlspecialchars($_POST["order_date"]);
    $total = htmlspecialchars($_POST["total"]);


    // execute statement and check for errors
    if ($stmt->execute()) {
        echo "Record added successfully.";
    } else {
        echo "Error adding record: " . $stmt->error;
    }

    // close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Record</title>
    <style>
        nav {
            background-color: #333;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        nav a {
            float: left;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

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

        h2 {
            text-align: center;
            color: #f0f0f0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 50%;
            max-width: 500px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 0.5rem;
        }

        input[type="date"],
        input[type="text"],
        input[type="number"] {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 100%;
            margin-bottom: 1rem;
        }

        input[type="submit"] {
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0069d9;
        }
    </style>
</head>

<body>
    <h2>Add Record</h2>
    <nav>
        <a href="mainmenu.php">Menu</a>
        <a href="list.php">Display</a>
        <a href="search.php">Search</a>
        <a href="add.php">Add</a>
        <a href="delete.php">Delete</a>

    </nav>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" id="customer_name" required>

        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item_name" required>

        <label for="item_quantity">Item Quantity:</label>
        <input type="number" name="item_quantity" id="item_quantity" required>

        <label for="order_date">Order Date:</label>
        <input type="date" name="order_date" id="order_date" required>

        <label for="total">Total:</label>
        <input type="number" step="0.01" name="total" id="total" required>

        <input type="submit" value="Submit">
    </form>
</body>


</html>