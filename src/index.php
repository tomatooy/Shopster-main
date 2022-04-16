<?php
session_start();
require_once('./php/component.php');
require_once('./connection.php');
require_once('./php/cartFunction.php');
$database = DBConnection::get_instance();
$database->createUserTable();
$database->createProductTable();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopster | main</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <link href="./style/main.css" rel="stylesheet">
    <link href="./style/misc-style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <nav>
        <a href="index.php"><span>
                <h1 class="logo">shopster.</h1>
            </span></a>
        <div class="navbar" id="navbarNavAltMarkup">
            <ul>
                <li><a class="button-header" href="./index.php"><i>home</a></li>
                <li><a class="button-header" href="./productPage.php">products</a></li>
                <li><a class="button-header" href="./aboutPage.php">about</a></li>
                <?php
                if (isset($_SESSION['logged_in']) && $_SESSION["logged_in"] = true) {
                    echo '<li style="float:right"><a class="button-header" href="./logout.php">Log Out</a></li>';
                    echo "<li style='margin:center'><a class='userHello'>Hello, " . $_SESSION['username'] . "</i></a></li>";
                } else {
                    echo '<li style="float:right"><a class="button-header" href="./loginPage.php">Log In</i></a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="todayDeal">
        <div class="checkoutCon">
            <div></div>
            <?php
            if (isset($_COOKIE["shopping_cart"])) {
                $quantity = 0;
                $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                $cart_data = json_decode($cookie_data, true);
                foreach ($cart_data as $keys => $values) {
                    $quantity += $values["product_quantity"];
                }
                echo "<a class=\"checkoutButt\" id=\"checkNum\"href=\"./cartPage.php\">check out [$quantity]</a>";
            } else {
                echo "<a class=\"checkoutButt\" href=\"./cartPage.php\">check out [0]</a>";
            }

            ?>
        </div>
        <div class="todayHeader">
            <p>- TODAY'S DEALS -</p>
        </div>
        <div class="itemDisplayContainer">
            <div class="itemDisplayContainer">
                <?php
                $result = $database->getSpecialItem();
                while ($row = mysqli_fetch_assoc($result)) {
                    displaySpecialProduct($row['product_name'], $row['price'], $row['image'], $row['product_id']);
                }
                ?>
            </div>
        </div>
    </div>
</body>
<footer>
    <div style="color:white;">
        Shopster &copy; 2022
    </div>
</footer>

</html>