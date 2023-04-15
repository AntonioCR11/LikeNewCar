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
            <!-- NAV-ITEM -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- LAPORAN KEUANGAN -->
                    <li class="nav-item">
                        <a class="nav-link text-primary active" href="#">Report</a>
                    </li>
                    <!-- MASTER USER -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="masterUser.php">Master User</a>
                    </li>
                    <!-- CAR INSPECTION -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="carInspection.php">Car Inspection</a>
                    </li>
                </ul>
                <!-- LOGOUT BTN -->
                <li class="nav-item" style="list-style: none;">
                    <form action="" method="GET">
                        <button class="btn btn-outline-success" type="logout" id="logout" name="logout">
                            Logout
                        </button>
                    </form>
                </li>
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
                        <h1>Filter</h1>
                        <a class="nav-link active" href="#">All</a>
                        <!-- PRICE -->
                        <div class="dropdown mb-1 me-1">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuPrice" data-bs-toggle="dropdown" aria-expanded="false">
                                Price
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuPrice">
                                <li><a class="dropdown-item" href="#">Ascending</a></li>
                                <li><a class="dropdown-item" href="#">Descending</a></li>
                            </ul>
                        </div>
                        <!-- MONTH -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle " type="button" id="dropdownMenuMonth" data-bs-toggle="dropdown" aria-expanded="false">
                                Month
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuMonth">
                                <li><a class="dropdown-item" href="#">Januari</a></li>
                                <li><a class="dropdown-item" href="#">Februari</a></li>
                                <li><a class="dropdown-item" href="#">Maret</a></li>
                                <li><a class="dropdown-item" href="#">April</a></li>
                                <li><a class="dropdown-item" href="#">Mei</a></li>
                                <li><a class="dropdown-item" href="#">Juni</a></li>
                                <li><a class="dropdown-item" href="#">Juli</a></li>
                                <li><a class="dropdown-item" href="#">Agustus</a></li>
                                <li><a class="dropdown-item" href="#">September</a></li>
                                <li><a class="dropdown-item" href="#">Oktober</a></li>
                                <li><a class="dropdown-item" href="#">November</a></li>
                                <li><a class="dropdown-item" href="#">Desember</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <hr class="pembatas my-3 w-75 mx-auto">
                <!-- REPORT -->
                <div class="rightContent col-sm-12 col-lg-9">
                    <h1>Report</h1>

                    <!-- TABLE -->
                    <table class="table table-light table-striped table-hover w-100">
                        <!-- HEADER -->

                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th class="hide">Nama User</th>
                            <th class="hide">Tanggal Transaksi</th>
                            <th class="hide">Note Pembeli</th>
                            <th class="hide">Subtotal</th>
                            <th>Action</th>
                        </tr>
                        <!-- NOTE : NGKOK FOR EN SEBANYAK 5 KALI AE (NAMPILNO MEK 5 ORDER) -->
                        <?php
                        foreach ($orders as $key => $value) {
                        ?>
                            <form action="#" method="GET">
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td class="hide"><?=$value["id_user"]?></td>
                                    <td class="hide"><?=$value["order_date"]?></td>
                                    <td class="hide"><?=$value["order_note"]?></td>
                                    <td class="hide"><?=$value["order_subtotal"]?></td>
                                    <td><button style="border-radius: 5px;">Detail</button></td>
                                </tr>
                            </form>
                        <?php
                        }
                        ?>
                    </table>

                    <!-- PAGINATION -->
                    <div class="paginationContainer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
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
    function make_Order_ID(length) {
        var result           = '#';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
</script>

</html>