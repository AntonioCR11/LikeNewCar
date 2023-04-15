<?php
require_once("connection.php");
// setcookie("activeUser","", time() - 5*60*60); 

// FETCH USER
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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

        .rightContent {
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

        @media (max-width: 770px) {
            .footer a {
                font-size: 0.9em;
            }

            .content {
                height: calc(100vh - 123px);
            }

            .rightContent {
                height: 425px;
            }

            .filterItem {
                display: flex;
                flex-direction: row;
            }

            .pembatas {
                display: block;
            }

            .hide {
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
                        <a class="nav-link" href="report.php">Report</a>
                    </li>
                    <!-- MASTER USER -->
                    <li class="nav-item">
                        <a class="nav-link text-primary active" aria-current="page" href="#">Master User</a>
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
                <!-- SEARCH BAR -->
                <div class="leftContent col-12">

                    <!-- SEARCH BAR -->
                    <div class="searchContainer">
                        <form class="d-flex">
                            <input class="form-control mx-auto w-75 me-2 py-2" type="search" placeholder="Search" aria-label="Search" style="border: 1px solid gray;" name="search_bar">
                            <button class="btn btn-success me-auto" type="submit" id="search_btn" onclick=""> Search </button>
                        </form>
                    </div>
                </div>
                <hr class="pembatas my-3 w-75 mx-auto">
                <!-- LIST USER -->
                <div class="rightContent col-12">
                    <h1>User List</h1>

                    <!-- TABLE -->
                    <table class="table table-light table-striped table-hover w-100">
                        <!-- HEADER -->
                        <tr>
                            <th>User ID</th>
                            <th>Nama User</th>
                            <th class="hide">Email User</th>
                            <th>Action</th>
                        </tr>
                        <!-- NOTE : NGKOK FOR EN SEBANYAK 5 KALI AE (NAMPILNO MEK 5 ORDER) -->
                        <?php
                        foreach ($users as $key => $value) {
                        ?>
                            <form action="#" method="GET">
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value["username"] ?></td>
                                    <td class="hide"><?= $value["email"] ?></td>
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

</script>

</html>