<?php
require_once("connection.php");
// setcookie("activeUser","", time() - 5*60*60); 

// FETCH USER
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// FETCH Inspection
$stmt = $conn->prepare("SELECT * FROM inspection");
$stmt->execute();
$inspections = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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

        /* ADD CAR BUTTON */
        .addCar {
            position: fixed;
            bottom: 100px;
            right: 50px;
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

            .addCar {
                position: fixed;
                bottom: 370px;
                right: 180px;
            }
        }
    </style>
</head>

<body onload="hideSecondInput()">
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
                        <a class="nav-link text-primary active" aria-current="page" href="#">Car Inspection</a>
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
                <!-- LIST INSPEKSI -->
                <div class="rightContent col-12">
                    <h1>Inspection List</h1>

                    <!-- TABLE -->
                    <table class="table table-light table-striped table-hover w-100">
                        <!-- HEADER -->
                        <tr>
                            <th>#</th>
                            <th>Car Brand</th>
                            <th>Car Model</th>
                            <th class="hide">Car Name</th>
                            <th class="hide">Car Price</th>
                            <th>Inspection Status</th>
                        </tr>
                        <!-- NOTE : NGKOK FOR EN SEBANYAK 5 KALI AE (NAMPILNO MEK 5 ORDER) -->
                        <?php
                        foreach ($inspections as $key => $value) {
                            if($value["id_user"] == $_COOKIE["activeUser"]){
                        ?>
                            <form action="#" method="GET">
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value["car_brand"] ?></td>
                                    <td><?= $value["car_model"] ?></td>
                                    <td><?= $value["car_name"] ?></td>
                                    <td><?= $value["car_price"] ?></td>
                                    <td class="hide">
                                        <?php if($value["status"] == "waiting"){ ?> 
                                            <p class="text-primary"><?= $value["status"] ?> </p>   
                                        <?php }else if($value["status"] == "confirmed"){ ?>
                                            <p class="text-success"><?= $value["status"] ?> </p> 
                                        <?php } else {?>
                                            <p class="text-danger"><?= $value["status"] ?> </p> 
                                        <?php } ?>
                                    </td>
                                </tr>
                            </form>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD CAR FORM -->
    <div class="addCarForm" id="addCarForm">
        <div class="form col-sm-12 col-md-6 col-lg-4 text-light" style="position:relative;">
            <!-- CLOSE BUTTON -->
            <div class="closeButton text-end" style="position:absolute;top:15px;right:20px;">
                <i class="fa fa-times" style="cursor: pointer;" onclick="closeAddCarForm()"></i>
            </div>
            <!-- FORM -->
            <form class="row g-3 needs-validation bg-dark" style="padding:35px 25px;border-radius:3%;" ; method="POST" action="userUpload.php"  enctype="multipart/form-data"  novalidate>
                
                <div class="title text-center">
                    <h5>Tambahkan Mobil Sekarang!</h5>
                    <h6 class="text-muted mt-0">Pastikan semua data mobil terisi!</h6>
                </div>

                <!-- CAR brand-model-type-name-transmisi-tahun-kilometer-harga-lokasi -->

                <!-- CAR BRAND SELECT -->
                <div class="col-6 col-lg-4 mt-2 firstInput">
                    <label for="carBrandSelect" class="form-label">Car Brand</label>
                    <select class="form-select" aria-label="Default select example" id="carBrandSelect" name="carBrandSelect">
                        <option value="Daihatsu">Daihatsu</option>
                        <option value="Mazda">Mazda</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Honda">Honda</option>
                        <option value="Mitsubishi">Mitsubishi</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Wuling">Wuling</option>
                    </select>
                </div>
                <!-- CAR MODEL -->
                <div class="col-6 col-lg-4 mt-2 firstInput">
                    <label for="carModelInput" class="form-label">Car Model</label>
                    <input type="text" class="form-control" id="carModelInput" value="YARIS,XPANDER,etc" name="carModelInput" required>
                </div>
                <!-- CAR TYPE SELECT -->
                <div class="col-12 col-lg-4 mt-2 firstInput">
                    <label for="carTypeSelect" class="form-label">Car Type</label>
                    <select class="form-select" aria-label="Default select example" id="carTypeSelect" name="carTypeSelect">
                        <option value="Sedan">Sedan</option>
                        <option value="SUV">SUV</option>
                        <option value="MPV">MPV</option>
                        <option value="Hatchback">Hatchback</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Coupe">Coupe</option>
                        <option value="Truck">Truck</option>
                        <option value="Wagon">Wagon</option>
                        <option value="Convertible">Convertible</option>
                        <option value="Van">Van</option>
                    </select>
                </div>
                <!-- CAR NAME -->
                <div class="col-12 mt-2 firstInput">
                    <label for="carNameInput" class="form-label">Car Name</label>
                    <input type="text" class="form-control" id="carNameInput" value="S TRD 1.5, G 1.2, etc" name="carNameInput" required>
                </div>
                <!-- CAR TRANSMISSION -->
                <div class="col-6 col-lg-4 mt-2 firstInput">
                    <label for="carTransmissionSelect" class="form-label">Car Transmission</label>
                    <select class="form-select" aria-label="Default select example" id="carTransmissionSelect" name="carTransmissionSelect">
                        <option value="Manual">Manual</option>
                        <option value="Automatic">Automatic</option>
                    </select>
                </div>
                <!-- CAR YEAR -->
                <div class="col-6 col-lg-4 mt-2 firstInput">
                    <label for="carYearInput" class="form-label">Car Year</label>
                    <input type="number" class="form-control" id="carYearInput" value="2021" name="carYearInput" required>
                </div>
                <!-- CAR KM -->
                <div class="col-12 col-lg-4 mt-2 firstInput">
                    <label for="carKilometerInput" class="form-label">Car Kilometer</label>
                    <input type="number" class="form-control" id="carKilometerInput" value="17080" name="carKilometerInput" required>
                </div>
                <!-- CAR PRICE -->
                <div class="col-12 col-lg-12 mt-2 firstInput">
                    <label for="carPriceInput" class="form-label">Car Price</label>
                    <input type="number" class="form-control" id="carPriceInput" value="211000000" name="carPriceInput" required>
                </div>
                <!-- CAR LOCATION -->
                <div class="col-6 mt-2 firstInput">
                    <label for="carLocationInput" class="form-label">Car Location</label>
                    <input type="text" class="form-control" id="carLocationInput" value="Tangerang Selatan" name="carLocationInput" required>
                </div>
                <!-- CAR IMAGE -->
                <div class="col-6 mt-2 firstInput">
                    <label for="fileToUpload" class="form-label">Upload Image</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
                <!-- NEXT BUTTON -->
                <div class="col-12 firstInput">
                    <div class="btn btn-warning w-100" type="nextBtn" name="next" onclick="hideFirstInput()">Next!</div>
                </div>

                <!-- CAR DATA -->
                <!-- fuel,color,seat,registration_date,registration_type,kilometer_driven,sparekey,service_book,warranty,period -->
                <!-- CAR FUEL -->
                <div class="col-4 col-lg-4 mt-2 secondInput">
                    <label for="carFuelInput" class="form-label">Car Fuel</label>
                    <input type="text" class="form-control" id="carFuelInput" value="Bensin" name="fuel" required>
                </div>
                <!-- CAR COLOR -->
                <div class="col-4 col-lg-4 mt-2 secondInput">
                    <label for="carColorInput" class="form-label">Car Color</label>
                    <input type="text" class="form-control" id="carColorInput" value="Merah" name="color" required>
                </div>
                <!-- CAR SEAT -->
                <div class="col-4 col-lg-4 mt-2 secondInput">
                    <label for="carSeatInput" class="form-label">Car Seat</label>
                    <input type="number" class="form-control" id="carSeatInput" value="5" name="seat" required>
                </div>
                <!-- CAR REG DATE -->
                <div class="col-6 col-lg-6 mt-2 secondInput">
                    <label for="carRegDateInput" class="form-label">Registration Date</label>
                    <input type="date" class="form-control" id="carRegDateInput" value="" name="reg_date" required>
                </div>
                <!-- CAR REG_TYPE SELECT -->
                <div class="col-6 col-lg-6 mt-2 secondInput">
                    <label for="carRegTypeSelect" class="form-label">Registration Type</label>
                    <select class="form-select" aria-label="Default select example" id="carRegTypeSelect" name="carRegTypeSelect">
                        <option value="Perorangan">Perorangan</option>
                        <option value="Perusahaan">Perusahaan</option>
                    </select>
                </div>
                <!-- KM DRIVEN -->
                <div class="col-12 col-lg-12 mt-2 secondInput">
                    <label for="carKmDrivenInput" class="form-label">Kilometer Driven</label>
                    <input type="number" class="form-control" id="carKmDrivenInput" value="3000" name="kmDriven" required>
                </div>
                <!-- CAR SPAREKEY SELECT -->
                <div class="col-4 col-lg-4 mt-2 secondInput">
                    <label for="carSpareKeySelect" class="form-label">Kunci Cadangan</label>
                    <select class="form-select" aria-label="Default select example" id="carSpareKeySelect" name="carSpareKeySelect">
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
                <!-- CAR SERVICE BOOK SELECT -->
                <div class="col-4 col-lg-4 mt-2 secondInput">
                    <label for="carServiceBookSelect" class="form-label">Service Book</label>
                    <select class="form-select" aria-label="Default select example" id="carServiceBookSelect" name="carServiceBookSelect">
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
                <!-- CAR WARRANTY SELECT -->
                <div class="col-4 col-lg-4 mt-2 secondInput">
                    <label for="carWarrantySelect" class="form-label">Garansi Pabrik</label>
                    <select class="form-select" aria-label="Default select example" id="carWarrantySelect" name="carWarrantySelect">
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
                <!-- CAR STNK DATE -->
                <div class="col-12 col-lg-12 mt-2 secondInput">
                    <label for="carSTNKInput" class="form-label">Masa Berlaku STNK</label>
                    <input type="date" class="form-control" id="carSTNKInput" value="" name="stnk_date" required>
                </div>
                <!-- ADD BUTTON -->
                <div class="col-12 secondInput">
                    <button class="btn btn-warning w-100" type="addCarBtn" name="addCar">Add Car!</button>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <a href="">© 2021 LIKENEWCAR, All Rights Reserved.</a>
    </div>
</body>
<script>
    function showAddCarForm() {
        $("#addCarForm").css({
            "visibility": "visible"
        });
        $("body").css({
            "height": "100%",
            "overflow": "hidden"
        });
    }

    function closeAddCarForm() {
        $("#addCarForm").css({
            "visibility": "hidden"
        });
        $("body").css({
            "height": "100%",
            "overflow": "visible"
        });
        
        $(".firstInput").show();
        $(".secondInput").hide();
    }
    function hideFirstInput(){
        $(".firstInput").hide();
        $(".secondInput").show();
    }
    function hideSecondInput(){
        $(".secondInput").hide();
    }
</script>

</html>