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

if (isset($_GET["login"])) { // LOGIN
    $email = $_GET["email"];
    $password = $_GET["password"];
    $found = false;

    // SEARCHING TIPE USER
    foreach ($users as $key => $value) {
        if ($value["email"] == $email) {
            $found = true;
            $decrypted_password = encrypt_decrypt($value["password"], 'decrypt');
            if ($decrypted_password == $password) {
                $namaUser = $value["username"];

                // echo "<script> alert('Berhasil login, selamat datang $namaUser!'); </script>";
                setcookie("activeUser", $value["id_user"], time() + 5 * 60 * 60);
                header("Location: shop.php");
            } else {
                echo "<script> alert('Password anda salah!'); </script>";
            }
        }
    }

    // JIKA USER TIDAK DITEMUKAN
    if (!$found) {
        echo "<script> alert('Username tidak ditemukan!'); </script>";
    }
} else if (isset($_GET["shop"])) {
    setcookie("currentPage", "0", time() + 5 * 60 * 60);
    header("Location: shop.php");
} else if (isset($_GET["logout"])) {
    setcookie("activeUser", "", time() - 5 * 60 * 60);
    header("Location: index.php");
}else if (isset($_POST["jual"])) {
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
        .imageContainer {
            width: 100%;
            height: 50vh;
            background-size:contain ;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 10px;
        }
        .banner2{
            background-color: rgb(255, 242, 199);
            height: 30vh;
        }
        .banner3{
            background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("./Asset/aboutUsAsset/HeroPic4.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 40vh;
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
            .imageContainer {
                height: 30vh;
            }
            .banner3{
                height: 60vh;
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

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- BELI MOBIL -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Beli Mobil
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <form action="#" method="GET">
                                <li><button class="dropdown-item" href="#" name="shop">Tampilkan semua mobil!</button></li>
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
                        <a class="nav-link" href="#">About Us</a>
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
    <div class="titleContainer text-center my-2">
        <h1>Tentang Kami</h1>
        <hr class="mx-auto" style="width:10%;border:3px solid black;border-radius:5px;">
    </div>
    <!-- BANNER -->
    <div class="jumbotron jumbotron-fluid banner mb-0 py-4">
        <div class="container">
            <div class="row h-100 mx-0">
                <div class="left col-sm-12 col-md-6 col-lg-6">
                    <!-- KIRI -->
                    <h1 style="font-size: 2.7em;font-weight:700;">Siapa kami?</h1>
                    <p class="lead mt-2" style="font-size: 1.2em;">Likenewcar adalah platform jual beli mobil bekas online terbesar di Asia Tenggara yang saat ini hadir di Malaysia, Indonesia, Thailand dan Singapura. Perusahaan ini memiliki misi untuk membawa industri mobil bekas ke era digital dengan membangun dan mengangkat pengalaman dalam menjual dan membeli mobil.</p>
                    <p class="lead mt-2 text-muted" style="font-size: 1.1em;">Likenewcar menyediakan solusi terlengkap untuk pembeli dan penjual mobil bekas, mulai dari inspeksi mobil, mutasi kepemilikan hingga pembiayaan, menjanjikan pelayanan yang Terpercaya, Mudah dan Cepat.</p>
                </div>
                <div class="right col-sm-12 col-md-6 col-lg-6">
                    <!-- KANAN -->
                    <div class="imageContainer" style="background-image: url(./Asset/aboutUsAsset/HeroPic.jpg);"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER 2-->
    <div class="jumbotron jumbotron-fluid banner2 mb-3">
        <div class="container text-white py-3 py-lg-5" style="display:flex;flex-direction:column;">
            <!-- KIRI -->
            <h1 class="text-muted" style="font-size: 2.2em;font-weight:600;">Visi kami</h1>
            <h3 class="text-dark" style="font-weight:700;">Memajukan industri otomotif di Asia Tenggara dalam ekosistem mobil bekas</h3>
        </div>
    </div>
    <!-- BANNER -->
    <div class="jumbotron jumbotron-fluid banner mb-0 py-2 py-lg-4">
        <div class="container">
            <div class="row h-100 mx-0">
                <h1 style="font-size: 2em;font-weight:700;">Layanan Kami</h1>
                <div class="left col-sm-12 col-md-6 col-lg-6">
                    <!-- KIRI -->
                    <p class="lead mt-2" style="font-size: 1.2em;">Kami memulai pertama kali sebagai platform penjualan mobil bekas, dimana kami membantu pelanggan menjual mobil bekas mereka melalui proses yang Terpercaya, Mudah, dan Cepat.</p>
                    <p class="lead mt-2 text-muted" style="font-size: 1.1em;">Proses sederhana ini dimulai dengan menjadwalkan inspeksi gratis secara online. Proses inspeksi kami di 175 titik inspeksi yang ekstensif secara gratis dan hanya membutuhkan waktu 30 menit di Inspection Center Carsome.
                    <br><br>
Inspektor profesional kami siap untuk memberikan laporan kondisi mobil yang lengkap sebelum memberikan penawaran di tempat. Sebagai alternatif, pelanggan dapat melanjutkan penawaran dimana jaringan dealer terverifikasi kami memiliki kesempatan untuk mengajukan penawaran. Setelah transaksi disepakati, semua urusan dokumen penjualan akan kami tangani.
                    <br><br>
Mulai dari inspeksi mobil, mutasi kepemilikan, hingga kemudahan pembiayaan, menjual mobil menjadi sangat mudah Carsome menghilangkan kesulitan dalam proses penjualan mobil bekas secara tradisional, menawarkan solusi efektif kepada konsumen dan dealer mobil bekas.</p>
                </div>
                <div class="right col-sm-12 col-md-6 col-lg-6">
                    <!-- KANAN -->
                    <div class="imageContainer" style="background-image: url(./Asset/aboutUsAsset/HeroPic2.jpg);"></div>
                </div>
            </div>
        </div>
    </div><!-- BANNER -->
    <div class="jumbotron jumbotron-fluid banner mb-0 py-2 py-lg-4">
        <div class="container">
            <div class="row h-100 mx-0">
                <div class="left col-sm-12 col-md-6 col-lg-6">
                    <!-- KANAN -->
                    <div class="imageContainer" style="background-image: url(./Asset/aboutUsAsset/HeroPic3.jpg);"></div>
                </div>
                <div class="right col-sm-12 col-md-6 col-lg-6">
                    <!-- KIRI -->
                    <p class="lead" style="font-size: 1.2em;">Pada bulan April 2021, kami meluncurkan cara baru membeli mobil, layanan baru yang menawarkan pengalaman membeli mobil yang mudah kepada konsumen di Indonesia.</p>
                    <p class="lead mt-2 text-muted" style="font-size: 1.1em;">Masuk ke www.carsome.id, klik tab Beli Mobil, dan konsumen dapat mencari mobil impian mereka yang sesuai dengan gaya hidup mereka. Semua mobil yang terdaftar memiliki tampilan 360 derajat dari interior dan eksterior mobil, daftar kondisi unit mobil saat ini, laporan rekondisi profesional, serta harga yang mencakup semua. Membuat janji test drive dapat dilakukan dengan mudah, kapanpun dan dimanapun melalui website, sebelum menuju ke Carsome Experience Center untuk melakukan test drive.
                    <br><br>
Untuk memberikan rasa tenang dan nyaman kepada konsumen, semua mobil Carsome Certified didukung dengan Carsome Promise yang artinya telah melewati pemeriksaan di 175 titik inspeksi oleh Carsome, layanan garansi selama satu tahun dan jaminan uang kembali selama lima hari, serta harga yang diberikan adalah harga pasti tanpa ada biaya tersembunyi.</p>

                </div>
            </div>
        </div>
    </div>
    <!-- BANNER 3-->
    <div class="jumbotron jumbotron-fluid banner3 mb-0">
        <div class="container text-white text-center py-5">
            <h1 style="font-size: 2.4em;font-weight:700;">Siap untuk menjual?</h1>
            <p class="lead mt-2" style="font-size: 1em;">Baik untuk menjual mobil bekas Anda atau membeli kendaraan Anda berikutnya, kami dapat melakukan semuanya.</p>
            <div class="buttonContainer" style="display: flex;justify-content:center;">
                <form class="w-25 me-2" action="shop.php">
                    <button class="btn btn-light py-3" style="width: 100%;font-weight:600;">Beli Mobil</button>
                </form>
                <!-- JUAL MOBIL -->
                <?php if (!isset($_COOKIE["activeUser"])) { ?>
                    <!-- JUAL MOBIL -->
                    <form class="w-25"  action="" method="POST">
                        <button class="btn btn-warning py-3" style="width: 100%;font-weight:600;" name="jual">Jual Mobil</button>
                    </form>
                <?php } else { ?>
                    <!-- JUAL MOBIL -->
                    <button class="btn btn-warning py-3" style="width: 25%;font-weight:600;" onclick="topFunction()">Jual Mobil</button>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- LOGIN FORM -->
    <div class="loginForm" id="loginForm">
        <div class="form col-sm-12 col-md-6 col-lg-4 text-light" style="position:relative;">
            <!-- KANAN -->
            <div class="closeButton text-end" style="position:absolute;top:5;right:20px;">
                <i class="fa fa-times" style="cursor: pointer;" onclick="closeLoginForm()"></i>
            </div>
            <form class="row g-3 needs-validation bg-dark" style="padding:35px 25px;border-radius:3%;" ; novalidate>
                <div class="title text-center">
                    <h5>Daftar atau Masuk!</h5>
                    <h6 class="text-muted mt-0">Selamat datang di Likenewcar!</h6>
                </div>

                <div class="col-md-12 mt-2">
                    <label for="validationCustom01" class="form-label">Email Address</label>
                    <input type="text" class="form-control" id="validationCustom01" value="John123@gmail.com" name="email" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-12 mt-2 mb-3">
                    <label for="validationCustom03" class="form-label">Password</label>
                    <input type="password" class="form-control" id="validationCustom03" value="Masukan password anda" name="password" required>
                    <div class="invalid-feedback">
                        Password invalid
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-warning w-100" type="loginBtn" name="login">login!</button>
                </div>
                <div class="col-12 text-center">
                    Tidak Punya Akun?
                    <button style="background-color: rgba(0,0,0,0);border:none;"><a href="register.php">Daftar sekarang</a></button>
                </div>
            </form>
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
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        setTimeout(function(){
            $("#addCarForm").css({
                "visibility": "visible"
            });
            $("body").css({
                "height": "100%",
                "overflow": "hidden"
            });
        },700);
    }

</script>

</html>