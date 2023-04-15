<?php
    require_once("connection.php");
    
    // FETCH Inspection
    $stmt = $conn->prepare("SELECT * FROM inspection");
    $stmt->execute();
    $inspections = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // ACTIVE USER
    $id = $_COOKIE["activeUser"] - 1;
    $user = $users["$id"];
    $name = $user["username"];

    $brand = $_POST["carBrandSelect"];
    $model = $_POST["carModelInput"];
    $type = $_POST["carTypeSelect"];
    $name = $_POST["carNameInput"];
    $transmission = $_POST["carTransmissionSelect"];
    $year = $_POST["carYearInput"];
    $km = $_POST["carKilometerInput"];
    $price = $_POST["carPriceInput"];
    $location = $_POST["carLocationInput"];
    $status = "Available";    
    // echo "<script> alert('$brand,$model,$type,$name,$transmission,$year,$km,$price,$location,$status'); </script>";
    // echo "$brand,$model,$type,$name,$transmission,$year,$km,$price,$location,$status";

    // ADD CAR DATA <!-- fuel,color,seat,registration_date,registration_type,kilometer_driven,sparekey,service_book,warranty,period -->
    $fuel = $_POST["fuel"];
    $color = $_POST["seat"];
    $seat = $_POST["seat"];
    $reg_date = $_POST["reg_date"];
    $reg_type = $_POST["carRegTypeSelect"];
    $kmDriven = $_POST["kmDriven"];
    $sparekey = $_POST["carSpareKeySelect"];
    $serive_book = $_POST["carServiceBookSelect"];
    $warranty = $_POST["carWarrantySelect"];
    $stnk = $_POST["stnk_date"];
    // echo "<script> alert('$fuel, $color, $type,$reg_date,$reg_type,$kmDriven,$sparekey,$serive_book,$warranty,$stnk'); </script>";

    $stmt = $conn->prepare("INSERT INTO inspection(id_user,car_brand,car_model,car_type,car_name,car_transmission,car_year,car_km,car_price,car_location,car_status,fuel,color,seat,registration_date,registration_type,kilometer_driven,sparekey,service_book,warranty,period) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("isssssiiissssississss", $_COOKIE["activeUser"],$brand,$model,$type,$name,$transmission,$year,$km,$price,$location,$status, $fuel, $color, $seat,$reg_date,$reg_type,$kmDriven,$sparekey,$serive_book,$warranty,$stnk);
    $result =$stmt->execute();

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
    
    // FETCH Inspection
    $stmt = $conn->prepare("SELECT * FROM inspection");
    $stmt->execute();
    $inspections = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


    // ACTIVE CAR
    $inspectionID = count($inspections);
    $inspection = $inspections[$inspectionID - 1];

    if (isset($_GET["shop"])) {
        setcookie("currentPage", "0", time() + 5 * 60 * 60);
        header("Location: shop.php");
    } else if (isset($_GET["logout"])) {
        setcookie("activeUser", "", time() - 5 * 60 * 60);
        header("Location: index.php");
    }


?>

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

        .addCarForm {
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

        .imageContainer {
            width: 100%;
            height: 50vh;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 10px;
        }

        .cardItem:hover {
            transform: scale(101%);
        }

        .cardItem {
            box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            -webkit-box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            -moz-box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            cursor: pointer;
        }

        .topItem {
            display: flex;
        }


        .certification {
            width: 30%;
            border-radius: 5px;
        }
        .isiKeterangan{
            font-weight: bold;
        }

        /* CONTENT */
        .content {
            display: flex;
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

            .addCar {
                position: fixed;
                bottom: 370px;
                right: 180px;
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
    <div class="content w-100 py-2" >
        <div class="container">
            <div class="row">
                <div class="leftContent col-12 col-lg-7 px-0">
                    <!-- <div class="imageContainer" style="background-image: url(./Asset/shopAsset/car_<?= $carID ?>.jpg);"></div> -->
                    <h1 class="text-primary mt-2">Your Car is being Processed!</h1>
                    <h3 class="text-primary m-0" style="font-weight: 300;">Please wait for more information!</h3>
                </div>
                <div class="rightContent col-12 col-lg-5 py-2" >
                    <h5 class="card-title">
                        <div class="topItem">
                            <div class="topLeft">
                                <div class="topInfo pt-3" style="font-weight: 700;">
                                    <!-- <img class="certification me-auto" src="./Asset/shopAsset/shopParalax/certified.png" alt="" class="d-inline-block align-text-top"> -->
                                    <!-- TAHUN & MERK -->
                                    <?= $inspection["car_year"] ?> <?= $inspection["car_brand"] ?>
                                    <!-- MODEL & NAMA -->
                                    <?= $inspection["car_model"] ?> <?= $inspection["car_name"] ?>
                                    
                                <div class="anotherInfo" style="font-size: 0.8em; font-weight:400;color:rgb(71, 71, 71);">
                                    <!-- TRANSMISI KM LOKASI -->
                                    <?= $inspection["car_transmission"] ?> | <?= number_format($inspection["car_km"]) ?> km | <?= $inspection["car_location"] ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="buttonContainer w-100" >
                            <div class="harga text-danger" style="font-size: 1.3em; font-weight:600;">
                                <!-- HARGA -->
                                <?= rupiah($inspection["car_price"]) ?>
                            </div>
                        </div>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <!-- CAR DATA -->
    <div class="container">
        <div class="carData text-center my-4">
            <div class="title">
                <h1 class="mb-5 text-center">Detail Mobil</h1>
            </div>
            <hr class="m-0">
            <div class="row">
                <div class="left col-12 col-lg-6">
                    <div class="bahan_bakar py-3 px-2" style="display: flex;" >
                        <div class="keterangan text-start">Jenis Bahan Bakar </div>
                        <div class="isiKeterangan ms-auto "><?= $inspection["fuel"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="tempat_duduk py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start ">Jumlah Tempat Duduk</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["seat"]?></div>

                    </div>
                    <hr class="m-0">
                    <div class="tipe_registrasi py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start ">Tipe Registrasi</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["registration_type"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="kunci_cadangan py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start ">Kunci Cadangan</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["sparekey"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="kadaluarsa py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Kadaluwarsa Garansi Pabrik</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["warranty"]?></div>
                    </div>
                    <hr class="m-0">
                </div>
                <div class="right col-12 col-lg-6">
                    <div class="warna py-3 px-2"  style="display: flex;">
                        <div class="keterangan text-start">Warna </div>
                        <div class="isiKeterangan ms-auto"><?= $inspection["color"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="tanggal_registrasi py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Tanggal Registrasi</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["registration_date"]?></div>

                    </div>
                    <hr class="m-0">
                    <div class="jarak_tempuh py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Jarak Tempuh</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["kilometer_driven"]?> Km</div>
                    </div>
                    <hr class="m-0">
                    <div class="buku_servis py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Buku Servis</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["service_book"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="masa_berlaku py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Masa Berlaku Stnk</div>                        
                        <div class="isiKeterangan ms-auto"><?= $inspection["period"]?></div>
                    </div>
                    <hr class="m-0">
                </div>
            </div>
        </div>
    </div>
    <!-- FOOTER -->
    <div class="footer">
        <a href="">© 2021 LIKENEWCAR, All Rights Reserved.</a>
    </div>
</body>