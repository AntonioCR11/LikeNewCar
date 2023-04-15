<?php
require_once("connection.php");
// setcookie("activeUser","", time() - 5*60*60); 

// FETCH USER
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// FETCH ORDERS
$stmt = $conn->prepare("SELECT * FROM orders");
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

function encrypt_decrypt($string, $action = 'encrypt')
{ // ENCRYPT DECRYPT METHOD 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27';
    $secret_iv = '5fgf5HJ5g27';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}


// ACTIVE USER
$id = $_COOKIE["activeUser"] - 1;
$user = $users["$id"];
$name = $user["username"];

if (isset($_GET["shop"])) {
    setcookie("currentPage", "0", time() + 5 * 60 * 60);
    header("Location: shop.php");
} else if (isset($_GET["logout"])) {
    setcookie("activeUser", "", time() - 5 * 60 * 60);
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIKENEWCAR</title>
    <!-- Bootstrap CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- CDN Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 18px;
        }

        .loginForm {
            display: flex;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.7);
            width: 100%;
            height: 100vh;
            align-items: center;
            position: absolute;
            top: 0;
            visibility: hidden;
        }

        /* CONTENT */
        .content {
            height: calc(100vh - 130px);
            display: flex;
        }
        .rightContent{
            height: 520px;
        }
        .paginationContainer {
            display: flex;
            justify-content: center;
        }
        .field {
            display: block;
            margin-left: 2px;
            margin-right: 2px;
            padding-top: 0.35em;
            padding-bottom: 0.625em;
            padding-left: 0.75em;
            padding-right: 0.75em;
            border: 1px solid rgb(210, 210, 210);
            border-radius: 5px;
        }
        /* FOOTER */
        .footer {
            text-align: center;
            padding: 20px 0px;
            background-color: rgb(23, 22, 54);
        }

        .footer a {
            text-decoration: none;
            font-size: 1.1em;
            color: white;
        }

        .pembatas {
            display: none;
        }

        @media (max-width: 770px) {
            .footer a {
                font-size: 0.9em;
            }

            .content {
                height: calc(100vh - 123px);
            }
            .rightContent{
                height: 425px;
            }

            .filterItem {
                display: flex;
                flex-direction: row;
            }

            .pembatas {
                display: block;
            }
            .hide{
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- LOGO -->
            <div class="logoContainer ">
                <a class="navbar-brand" href="index.php" style="display: flex;padding:0; padding-top:5px;">
                    <img class="me-2" src="./Asset/homeAsset/logo.png" alt="" width="75" height="23" class="d-inline-block align-text-top">
                    <h4 style="font-weight: bold;">LIKE</h4>
                    <h4 class="">NEWCAR</h4>
                </a>
            </div>

            <!-- HAMBURGER -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- BELI MOBIL -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Beli Mobil
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <form action="./shop.php">
                                <li><button class="dropdown-item" href="#">Tampilkan semua mobil!</button></li>
                            </form>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Daihatsu</a></li>
                            <li><a class="dropdown-item" href="#">Mazda</a></li>
                            <li><a class="dropdown-item" href="#">Nissan</a></li>
                            <li><a class="dropdown-item" href="#">Toyota</a></li>
                            <li><a class="dropdown-item" href="#">Honda</a></li>
                            <li><a class="dropdown-item" href="#">Mitsubishi</a></li>
                            <li><a class="dropdown-item" href="#">Suzuki</a></li>
                            <li><a class="dropdown-item" href="#">Wuling</a></li>
                        </ul>
                    </li>
                    <!-- JUAL MOBIL -->
                    <?php if (!isset($_COOKIE["activeUser"])) { ?>
                        <!-- JUAL MOBIL -->
                        <li class="nav-item">
                            <form action="" method="POST">
                                <button class="btn nav-link" aria-current="page" href="#" name="jual">Jual Mobil</button>
                            </form>
                        </li>
                    <?php } else { ?>
                        <!-- JUAL MOBIL -->
                        <li class="nav-item">
                            <button class="btn nav-link" aria-current="page" href="#" onclick="showAddCarForm()">Jual Mobil</button>
                        </li>
                    <?php } ?>
                    <!-- ABOUT US -->
                    <li class="nav-item">
                        <a class="nav-link" href="aboutUs.php">About Us</a>
                    </li>

                </ul>
                <?php if (!isset($_COOKIE["activeUser"])) { ?>
                    <!-- LOGIN BTN -->
                    <button class="btn" type="login" id="login" onclick="showLoginForm()">
                        <i class="fa fa-user-circle"></i>
                        Daftar atau Masuk
                    </button>
                <?php } else {
                    $user = $users[$_COOKIE["activeUser"] - 1];
                    $nama = $user["username"];
                ?>
                    <!-- <div class="userInfo me-2">Hello, <?= $nama ?></div> -->
                    <a href="cart.php" style="text-decoration: none;color:black;"><i class="fa fa-shopping-cart me-2" style="font-size: 1.6em;cursor:pointer;"></i></a>
                    <a href="wishlist.php" style="text-decoration: none;color:black;"><i class="fa fa-heart me-2" style="font-size: 1.6em;cursor:pointer;"></i></a>

                    <li class="dropdown" style="list-style: none;">
                        <i class="fa fa-user-circle p-0 me-2 dropdown-toggle" style="font-size: 1.6em;" href="#" id="profile" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu" aria-labelledby="profile">
                            <li><a class="dropdown-item" href="#">
                                    <!-- LOGOUT BTN -->
                                    <form action="" method="GET">
                                        <button class="btn btn-outline-success" type="logout" id="logout" name="logout">
                                            Logout
                                        </button>
                                    </form>
                                </a></li>
                            <li><a class="dropdown-item" href="#">Account</a></li>
                        </ul>
                    </li>

                <?php } ?>
            </div>
        </div>
    </nav>
    <!-- CONTENT -->
    <div class="content py-2">
        <div class="container">
            <div class="row">
                <!-- FILTER -->
                <div class="leftContent col-sm-12 col-lg-3">
                    <nav class="nav flex-sm-row flex-lg-column">
                        <h1>Tabs</h1>
                        <a class="nav-link active" href="#">Bidoata</a>
                        <a class="nav-link text-muted" href="userCarInspection.php">Car Inspection</a>
                    </nav>
                </div>
                <hr class="pembatas my-3 w-75 mx-auto">
                <!-- REPORT -->
                <div class="rightContent col-sm-12 col-lg-9">
                    <div class="field">
                        <h1>Biodata</h1>
                        <hr class="my-3 w-100 mx-auto">
                        <div class="data d-flex " style="width: 60%;"><h4>Name          :</h4><h5 class="ms-auto"> <?=$user["username"]?></h5></div>
                        <div class="data d-flex " style="width: 60%;"><h4>Email Address :</h4><h5 class="ms-auto"> <?=$user["email"]?>  </h5></div>
                        <div class="data d-flex " style="width: 60%;"><h4>Address       :</h4><h5 class="ms-auto"> <?=$user["address"]?></h5></div>
                        <div class="data d-flex " style="width: 60%;"><h4>Phone number  :</h4><h5 class="ms-auto"> <?=$user["phone"]?> </h5></div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FOOTER -->
    <div class="footer">
        <a href="">© 2021 LIKENEWCAR, All Rights Reserved.</a>
    </div>
</body>
<script>
</script>

</html>