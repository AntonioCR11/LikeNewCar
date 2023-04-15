<?php
require_once("connection.php");

// FETCH USER
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// FETCH CAR
$stmt = $conn->prepare("SELECT * FROM cars");
$stmt->execute();
$cars = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// FETCH WISH
$stmt = $conn->prepare("SELECT * FROM wishlist WHERE id_user =" . $_COOKIE["activeUser"]);
$stmt->execute();
$wishlist = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// FETCH CART
$stmt = $conn->prepare("SELECT * FROM cart");
$stmt->execute();
$carts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// ACTIVE USER
$id = $_COOKIE["activeUser"] - 1;
$user = $users["$id"];
$name = $user["username"];

// echo "<script> alert('USER : $name'); </script>";

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

if (isset($_GET["logout"])) {
    setcookie("activeUser", "", time() - 5 * 60 * 60);
    header("Location: shop.php");
} else if (isset($_GET["delete"])) {
    $idUser = $_COOKIE["activeUser"];
    $idCar = $_GET["delete"];
    // echo "<script> alert('ID : $idCar'); </script>";

    $stmt = $conn->prepare("DELETE FROM cart WHERE id_user =" . $_COOKIE["activeUser"] . " and id_car =" . $idCar);
    $stmt->execute();
    header("Location: cart.php");
} else if (isset($_POST["jual"])) {
    echo "<script> alert('Anda harus login terlebih dahulu!'); </script>";
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


        .summary {
            border: 1px solid rgb(210, 210, 210);
            border-radius: 5px;
            display: flex;

            box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            -webkit-box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            -moz-box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
        }

        .cartContainer {
            border: 1px solid rgb(210, 210, 210);
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;

            box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            -webkit-box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            -moz-box-shadow: 0px 0px 22px -3px rgba(0, 0, 0, 0.29);
            cursor: pointer;
        }

        .imageContainer {
            width: 25%;
            height: 150px;
            margin-right: 30px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 5px;
        }

        .carInfo {
            width: 50%;
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .buttonContainer {
            width: 10%;
            text-align: right;
            padding-top: 48px;
            padding-bottom: 48px;
        }

        .topItem {
            display: flex;
        }

        .likeButton {
            width: 50px;
            height: 50px;
            object-fit: cover;
            object-position: 0px 0px;
        }

        .likeButton:hover {
            transform: scale(110%);
        }

        .certification {
            width: 40%;
            border-radius: 5px;
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
            .imageContainer {
                width: 100%;
                margin: 0;
            }

            .carInfo {
                width: 100%;
                padding: 0;
            }

            .buttonContainer {
                width: 100%;
                padding: 0;
                text-align: left;
            }
            .buttonContainer button{
                width: 100%;
            }
            .footer a {
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body onload="hideSecondInput()">
    <form action="" method="GET">
        <input type="hidden" name="page" id="page" value="<?= $currentPage ?>">
    </form>
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
    <!-- PRODUCT -->
    <div class="product py-4">
        <div class="container">
            <h1 class="content mb-4 text-center">User Cart</h1>
            <div class="content" id="content" style="display: flex; justify-content:center;">
                <div class="row w-100">
                    <!-- LEFT -->
                    <div class="leftContent col-12 col-lg-7">
                        <?php
                        foreach ($carts as $key => $value) {
                            $car = $cars[$value["id_car"] - 1];
                            if ($value["id_user"] == $_COOKIE["activeUser"]) {
                        ?>
                                <form action="#" method="GET">
                                    <div class="cartContainer mb-3 p-3">
                                        <div class="imageContainer" style="background-image: url(./Asset/shopAsset/car_<?= $car["id_car"] ?>.jpg);"></div>
                                        <div class="carInfo my-3">
                                            <div class="name">
                                                <h3 class="mb-0"><?= $car["car_brand"] ?> <?= $car["car_model"] ?> <?= $car["car_name"] ?></h3>
                                            </div>
                                            <div class="price text-danger">
                                                <h5 class="m-0"><?= rupiah($car["car_price"]) ?></h5>
                                            </div>
                                            <div class="anotherInfo" style="font-size: 0.9em; font-weight:300;color:rgb(71, 71, 71);">
                                                <!-- TRANSMISI KM LOKASI -->
                                                <?= $car["car_transmission"] ?> | <?= number_format($car["car_kilometer"]) ?> km | <?= $car["car_location"] ?>
                                            </div>
                                        </div>
                                        <div class="buttonContainer">
                                            <button class=" btn btn-lg btn-danger" name="delete" value="<?= $car["id_car"] ?>">Delete</button>
                                        </div>
                                    </div>
                                </form>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- RIGHT -->
                    <div class="rightContent col-12 col-lg-5" >
                        <div class="summary p-4" style="display: flex; flex-direction:column;">
                            <div class="title"><h3>Summary</h3><br></div>
                            <table class="table table-light table-striped table-hover">
                                <!-- HEADER -->
                                <tr>
                                    <th>#</th>
                                    <th>Nama Mobil</th>
                                    <th>Harga Mobil</th>
                                </tr>
                                <?php
                                    $total = 0;
                                    foreach ($carts as $key => $value) {
                                        $car = $cars[$value["id_car"] - 1];
                                        if ($value["id_user"] == $_COOKIE["activeUser"]) {
                                ?>
                                            <form action="#" method="GET">
                                                <tr>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $car["car_brand"] ?> <?= $car["car_model"] ?> <?= $car["car_name"] ?></td>
                                                    <td><?= rupiah($car["car_price"]) ?></td>
                                                </tr>
                                            </form>
                                <?php
                                        $total+=$car["car_price"];
                                        }
                                    }
                                ?>
                                <!-- TOTAL -->
                                <td>Total</td>
                                <td></td>
                                <td><?= rupiah($total) ?></td>
                            </table>
                            <form action="" method="GET">
                                <button class=" btn btn-lg btn-primary" name="checkout" value="<?= $_COOKIE["activeUser"] ?>">Checkout</button>
                            </form>
                        </div>
                    </div>
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
            <form class="row g-3 needs-validation bg-dark" style="padding:35px 25px;border-radius:3%;" ; method="POST" action="userUpload.php" enctype="multipart/form-data" novalidate>

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
                <div class="col-12 mt-2 firstInput">
                    <label for="carLocationInput" class="form-label">Car Location</label>
                    <input type="text" class="form-control" id="carLocationInput" value="Tangerang Selatan" name="carLocationInput" required>
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
    function showLoginForm() {
        $("#loginForm").css({
            "visibility": "visible"
        });
        $("body").css({
            "height": "100%",
            "overflow": "hidden"
        });
    }

    function closeLoginForm() {
        $("#loginForm").css({
            "visibility": "hidden"
        });
        $("body").css({
            "height": "100%",
            "overflow": "visible"
        });
    }

    // ADD CAR FORM
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

    function hideFirstInput() {
        $(".firstInput").hide();
        $(".secondInput").show();
    }

    function hideSecondInput() {
        $(".secondInput").hide();
    }
</script>

</html>