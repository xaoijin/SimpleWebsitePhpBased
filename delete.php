<!DOCTYPE html>
<!--  I, Johnson Li, certify that this submission is my own original work-->
<html>

<head>
    <title>Bakery Orders</title>
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

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 1rem;

            padding: 1rem;
        }

        form input[type="submit"]:hover {
            background-color: #ff3333;
            color: #fff;
        }

        label {
            font-weight: bold;
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


        select,
        input[type="text"] {
            padding: 0.5rem;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: cadetblue;

        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Bakery Orders</h1>
    <nav>
        <a href="mainmenu.php">Menu</a>
        <a href="list.php">Display</a>
        <a href="search.php">Search</a>
        <a href="add.php">Add</a>
        <a href="delete.php">Delete</a>

    </nav>
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


    // Prepare and execute SQL query to retrieve records
    $stmt = $conn->prepare("SELECT * FROM bakery_orders");
    $stmt->execute();
    $result = $stmt->get_result();
    // Display search results in a table with delete button
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Customer Name</th><th>Item Name</th><th>Item Quantity</th><th>Order Date</th><th>Total</th></tr>";
        while ($row = $result->fetch_assoc()) {
            //Sanitizing output
            $id = htmlspecialchars($row["id"]);
            $customer_name = htmlspecialchars($row["customer_name"]);
            $item_name = htmlspecialchars($row["item_name"]);
            $item_quantity = htmlspecialchars($row["item_quantity"]);
            $order_date = htmlspecialchars($row["order_date"]);
            $total = htmlspecialchars($row["total"]);
            echo "<tr><td>$id</td><td>$customer_name</td><td>$item_name</td><td>$item_quantity</td><td>$order_date</td><td>$total</td>";
            echo "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to delete this record?\")'><input type='hidden' name='record_id' value='$id'><input type='submit' value='Delete'></form></td></tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }


    // Delete record 
    if (isset($_POST["record_id"])) {
        $record_id = $_POST["record_id"];
        $stmt = $conn->prepare("DELETE FROM bakery_orders WHERE id = ?");
        $stmt->bind_param("i", $record_id);
        $stmt->execute();
        echo "<script>
        alert('Record deleted successfully.');
         window.location.href = 'delete.php';
    </script>";
    }

    ?>
</body>

</html>