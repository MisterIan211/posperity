<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://kit.fontawesome.com/f7e75704ad.js" crossorigin="anonymous"></script>
</head>


<body>
    <header>
        <h1>
            <?php
            session_start();
            if (isset($_SESSION['merchantname'])) {
                echo $_SESSION['merchantname'];
            }
            ?>
        </h1>
        <div class="head">
            <a href="logout.php">Logout</a>
            <div class="menu">
                <a onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></a>
                <div id="hide" class="navbar-toggle">
                    <a class="bar" href="index.php">Home</a>
                    <a class="bar" href="#">Make Sale</a>
                    <a class="bar" href="inventory.php">Inventory</a>
                    <a class="bar" href="#">Transactions</a>
                    <a class="bar" href="about.html">About</a>
                    <a class="bar" href="services.html">Services</a>
                </div>
            </div>
            <nav class="nav" id="navbarLinks">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Make Sale</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="#">Transactions</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="services.html">Services</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <style>
        .actionsBar {
            height: 6vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-right: 3vw;
            padding-left: 3vw;
        }

        .searchBar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .searchInput {
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .searchButton {
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #0e1f3d;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
    <div class="inventorydiv">
        <div>
            <div class="actionsBar">
                <div>
                    <button class="button" onclick="toAdd()">Add items</button>
                </div>
                <div>
                    <div class="searchBar">
                        <input type="text" id="searchInput" class="searchInput" placeholder="Search...">
                        <button class="searchButton" onclick="searchItems()">Search</button>
                    </div>
                </div>
            </div>
            <div class="inventorydiv1">
                <!-- <button>::</button> -->
                <?php
                // Connect to your database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "posperity";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the database
                $sql = "SELECT `product_id`, `name`, `description`, `price`, `quantity`, `img_url`,
             `user`, `merchant` FROM `product` WHERE `merchant` = ?";

                $stmt = $conn->prepare($sql);

                // Bind the parameter to the statement
                $stmt->bind_param("i", $_SESSION['merchantid']);

                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                // Check if the query returned any rows
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {

                        echo "<div class='card'>";
                        echo "<img src='" . $row["img_url"] . "' alt='Product Image'>";
                        echo "<div class='card-content'>";
                        echo "<h4>" . $row["name"] . "</h4>";
                        echo "<p>" . $row["description"] . "</p>";
                        echo "<p>Ksh. " . $row["price"] . "</p>";
                        echo "<p>stock: " . $row["quantity"] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No data found</td></tr>";
                }
                $conn->close();
                ?>

            </div>
        </div>
        <footer>
            <p style="font-size: 10px;color:white;">
                &copy; 2024 posperity,all rights reserved</p>
        </footer>
    </div>


</body>
<script>
    function toggleMenu() {
        var navbarLinks = document.getElementById("hide");
        if (navbarLinks.style.display === "flex") {
            navbarLinks.style.display = "none";
        } else {
            navbarLinks.style.display = "flex";
        }
    }


    function searchItems() {
        var input = document.getElementById('searchInput').value.trim().toLowerCase();
        var cards = document.getElementsByClassName('card');

        for (var i = 0; i < cards.length; i++) {
            var name = cards[i].querySelector('h4').textContent.toLowerCase();
            var description = cards[i].querySelector('p').textContent.toLowerCase();

            if (name.includes(input) || description.includes(input)) {
                cards[i].style.display = 'block';
            } else {
                cards[i].style.display = 'none';
            }
        }
    }

    function toAdd() {
            // Redirect to another page (replace 'page-url' with the actual URL)
            window.location.href = 'add_product.php';
        }
</script>

</html>