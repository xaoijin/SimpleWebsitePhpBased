<!DOCTYPE html>
<!--  I, Johnson Li, certify that this submission is my own original work -->
<html>

<head>
    <title>Search Records</title>
    <style>
        h2 {
            text-align: center;
        }

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

        form {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        label {
            margin-right: 1rem;
        }

        select,
        input[type="text"],
        input[type="submit"] {
            padding: 0.5rem;
            font-size: 1rem;
            border: 2px solid #ccc;
            border-radius: 0.25rem;
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

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #ff9900;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #ffeecc;
        }

        tr:nth-child(odd) {
            background-color: #fff7e6;
        }

        td {
            border: 1px solid #ffcc66;
        }
    </style>

</head>

<body>
    <h2>Search Records</h2>
    <nav>
        <a href="mainmenu.php">Menu</a>
        <a href="list.php">Display</a>
        <a href="search.php">Search</a>
        <a href="add.php">Add</a>
        <a href="delete.php">Delete</a>

    </nav>
    <form method="post">
        <label for="search_field">Search Field:</label>
        <select name="search_field" id="search_field">
            <option value="id">ID</option>
            <option value="customer_name">Customer Name</option>
            <option value="item_name">Item Name</option>
            <option value="item_quantity">Item Quantity</option>
            <option value="order_date">Order Date</option>
            <option value="total">Total</option>
        </select>
        <label for="search_value">Search Value:</label>
        <input type="text" name="search_value" id="search_value">
        <input type="submit" value="Search">
    </form>
    <?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
    // Establish database connection
    $conn = mysqli_connect(
        "localhost",
        "usersp23",
        "passwdsp23",
        "bcs350sp23"
    );
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve search field and value from form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search_field = $_POST["search_field"];
        $search_value = $_POST["search_value"];

        // Prepare and execute SQL query
        $search_value = "%$search_value%"; // Add wildcards to search value
        $stmt = $conn->prepare("SELECT * FROM bakery_orders WHERE LOWER($search_field) LIKE LOWER(?)");
        $stmt->bind_param("s", $search_value);
        $stmt->execute();

        // Display search results in a table
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Customer Name</th><th>Item Name</th><th>Item Quantity</th><th>Order Date</th><th>Total</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row["id"]) .
                    "</td><td>" . htmlspecialchars($row["customer_name"]) .
                    "</td><td>" . htmlspecialchars($row["item_name"]) .
                    "</td><td>" . htmlspecialchars($row["item_quantity"]) .
                    "</td><td>" . htmlspecialchars($row["order_date"]) .
                    "</td><td>" . htmlspecialchars($row["total"]) .
                    "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }
    }

    ?>
</body>

</html>