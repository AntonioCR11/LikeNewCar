<?php
    require_once("connection.php");
    
    // FETCH CAR
    $stmt = $conn->prepare("SELECT * FROM cars");
    $stmt->execute();
    $cars = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // GET IMAGE DATA
    $target_dir = "Asset/shopAsset/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]); 
    // $target_file = $target_dir.basename($_POST["fileToUpload"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // echo "$from" ;

    // Check if image file is a actual image or fake image
    if(isset($_POST["addCar"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            // echo "<script>alert('File is an image - " . $check["mime"] . ".')</script>";
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image.')</script>";
            $uploadOk = 0;
        }
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
        $uploadOk = 0;
    }else{
        // JIKA MERUPAKAN FILE GAMBAR MAKA UBAH MENJADI JPG
        // $location = strpos($target_file, '.');

        $countCar = count($cars)+1;
        // echo "$totalCar" ;

        $changeExtension = substr($target_file, 0, 16)."car_$countCar.jpg";
        $target_file = $changeExtension;
        // echo "$target_file";
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            // ADD CAR <!-- brand-model-type-name-transmisi-tahun-kilometer-harga-lokasi-status -->
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

            $stmt = $conn->prepare("INSERT INTO cars(car_brand,car_model,car_type,car_name,car_transmission,car_year,car_kilometer,car_price,car_location,car_status) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssiiiss", $brand,$model,$type,$name,$transmission,$year,$km,$price,$location,$status);
            $result =$stmt->execute();

            // ADD CAR DATA <!-- fuel,color,seat,registration_date,registration_type,kilometer_driven,sparekey,service_book,warranty,period -->
            $fuel = $_POST["fuel"];
            $color = $_POST["color"];
            $seat = $_POST["seat"];
            $reg_date = $_POST["reg_date"];
            $reg_type = $_POST["carRegTypeSelect"];
            $kmDriven = $_POST["kmDriven"];
            $sparekey = $_POST["carSpareKeySelect"];
            $serive_book = $_POST["carServiceBookSelect"];
            $warranty = $_POST["carWarrantySelect"];
            $stnk = $_POST["stnk_date"];
            // echo "<script> alert('$fuel, $color, $type,$reg_date,$reg_type,$kmDriven,$sparekey,$serive_book,$warranty,$stnk'); </script>";

            $stmt = $conn->prepare("INSERT INTO car_data(fuel,color,seat,registration_date,registration_type,kilometer_driven,sparekey,service_book,warranty,period) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssississss", $fuel, $color, $seat,$reg_date,$reg_type,$kmDriven,$sparekey,$serive_book,$warranty,$stnk);
            $result =$stmt->execute();


        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // FETCH CAR AGAIN
    $stmt = $conn->prepare("SELECT * FROM cars");
    $stmt->execute();
    $cars = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // FETCH CARDATA
    $stmt = $conn->prepare("SELECT * FROM car_data");
    $stmt->execute();
    $car_datas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }

    // ACTIVE CAR
    $carID = count($cars);
    $car = $cars[$carID - 1];
    // CAR DATA
    $car_data = $car_datas[$carID-1];

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
            <!-- NAV-ITEM -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- LAPORAN KEUANGAN -->
                    <li class="nav-item">
                        <a class="nav-link" href="report.php">Report</a>
                    </li>
                    <!-- MASTER USER -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="masterUser.php">Master User</a>
                    </li>
                    <!-- CAR INSPECTION -->
                    <li class="nav-item">
                        <a class="nav-link text-primary active" aria-current="page" href="carInspection.php">Car Inspection</a>
                    </li>
                </ul>
                <!-- LOGOUT BTN -->
                <li class="nav-item" style="list-style: none; ">
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
    <div class="content w-100 py-2" >
        <div class="container">
            <div class="row">
                <div class="leftContent col-12 col-lg-7 px-0">
                    <div class="imageContainer" style="background-image: url(./Asset/shopAsset/car_<?= $carID ?>.jpg);"></div>
                </div>
                <div class="rightContent col-12 col-lg-5 py-2" >
                    <h5 class="card-title">
                        <div class="topItem">
                            <div class="topLeft">
                                <div class="topInfo pt-3" style="font-weight: 700;">
                                    <img class="certification me-auto" src="./Asset/shopAsset/shopParalax/certified.png" alt="" class="d-inline-block align-text-top">
                                    <!-- TAHUN & MERK -->
                                    <?= $car["car_year"] ?> <?= $car["car_brand"] ?>
                                    <!-- MODEL & NAMA -->
                                    <?= $car["car_model"] ?> <?= $car["car_name"] ?>
                                    
                                <div class="anotherInfo" style="font-size: 0.8em; font-weight:400;color:rgb(71, 71, 71);">
                                    <!-- TRANSMISI KM LOKASI -->
                                    <?= $car["car_transmission"] ?> | <?= number_format($car["car_kilometer"]) ?> km | <?= $car["car_location"] ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="buttonContainer w-100" >
                            <div class="harga text-danger" style="font-size: 1.3em; font-weight:600;">
                                <!-- HARGA -->
                                <?= rupiah($car["car_price"]) ?>
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
                        <div class="isiKeterangan ms-auto "><?= $car_data["fuel"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="tempat_duduk py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start ">Jumlah Tempat Duduk</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["seat"]?></div>

                    </div>
                    <hr class="m-0">
                    <div class="tipe_registrasi py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start ">Tipe Registrasi</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["registration_type"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="kunci_cadangan py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start ">Kunci Cadangan</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["sparekey"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="kadaluarsa py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Kadaluwarsa Garansi Pabrik</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["warranty"]?></div>
                    </div>
                    <hr class="m-0">
                </div>
                <div class="right col-12 col-lg-6">
                    <div class="warna py-3 px-2"  style="display: flex;">
                        <div class="keterangan text-start">Warna </div>
                        <div class="isiKeterangan ms-auto"><?= $car_data["color"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="tanggal_registrasi py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Tanggal Registrasi</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["registration_date"]?></div>

                    </div>
                    <hr class="m-0">
                    <div class="jarak_tempuh py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Jarak Tempuh</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["kilometer_driven"]?> Km</div>
                    </div>
                    <hr class="m-0">
                    <div class="buku_servis py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Buku Servis</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["service_book"]?></div>
                    </div>
                    <hr class="m-0">
                    <div class="masa_berlaku py-3 px-2" style="display: flex;">
                        <div class="keterangan text-start">Masa Berlaku Stnk</div>                        
                        <div class="isiKeterangan ms-auto"><?= $car_data["period"]?></div>
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