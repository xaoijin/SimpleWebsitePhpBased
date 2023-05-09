<!DOCTYPE html>
<!--  I, Johnson Li, certify that this submission is my own original work -->
<html>

<head>
    <title>List Records</title>
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
            background: linear-gradient(to bottom, #ffffff, #000000);
        }

        table {
            background-color: #fff;
            color: #000;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #2d88ff;
            color: #fff;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Display Orders</h1>
    <nav>
        <a href="mainmenu.php">Menu</a>
        <a href="list.php">Display</a>
        <a href="search.php">Search</a>
        <a href="add.php">Add</a>
        <a href="delete.php">Delete</a>

    </nav>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();

            // Check if user is logged in
            if (!isset($_SESSION['username'])) {
                header('Location: login.php');
                exit();
            }
            // connect to the database
            $conn = new mysqli("localhost", "usersp23", "passwdsp23", "bcs350sp23");

            // check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // query to select all records from the bakery_orders table
            $sql = "SELECT * FROM bakery_orders";

            // execute the query
            $result = $conn->query($sql);

            // check if there are any records
            if ($result->num_rows > 0) {
                // loop through each record and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlentities($row["id"]) . "</td>";
                    echo "<td>" . htmlentities($row["customer_name"]) . "</td>";
                    echo "<td>" . htmlentities($row["item_name"]) . "</td>";
                    echo "<td>" . htmlentities($row["item_quantity"]) . "</td>";
                    echo "<td>" . htmlentities($row["order_date"]) . "</td>";
                    echo "<td>" . htmlentities($row["total"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                // display a message if there are no records
                echo "<tr><td colspan='6'>No orders found</td></tr>";
            }

            // close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>


</html>