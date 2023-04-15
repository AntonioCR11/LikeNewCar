<?php

require_once("connection.php");

// ITEM
$stmt = $conn->prepare("SELECT * FROM cars");
$stmt->execute();
$cars = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// LIHAT APAKAH PAGE AKAN DITAMBAH ATAU DIKURANGI
$page = $_GET["page"];

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

?>

<!-- GENERATE PRODUCT CARD -->
<div class="row productContainer">
    <?php
    // UNTUK PAGINATION
    $count = $_GET["page"];
    $start = 0;
    $end = 9;
    if ($count > 0) {
        $start = $count * 9;
        $end = ($count + 1) * 9;
    }

    // echo "<script>alert('Car : $start - $end');</script>";

    for ($i = $start; $i < $end; $i++) {
        $car = $cars[$i]; // TAMPUNG MOBIL KE INDEX
        $ID_CAR = $car["id_car"]; // TAMPUNG ID MOBIL
    ?>
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <!-- LINK KE DETAIL PAGE -->
            <a href="detailPage.php?activeCar=<?= $ID_CAR ?>" style="text-decoration: none;color:black;">

                <div class="card cardItem">
                    <div class="imageContainer" style="background-image: url(./Asset/shopAsset/car_<?= $ID_CAR ?>.jpg);"></div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <div class="certified">
                                <img class="certification me-auto" src="./Asset/shopAsset/shopParalax/certified.png" alt="" class="d-inline-block align-text-top">
                            </div>
                            <div class="topItem">
                                <div class="topLeft">
                                    <div class="topInfo">
                                        <!-- TAHUN & MERK -->
                                        <?= $car["car_year"] ?> <?= $car["car_brand"] ?>
                                    </div>
                                    <div class="bottomInfo">
                                        <!-- MODEL & NAMA -->
                                        <?= $car["car_model"] ?> <?= $car["car_name"] ?>
                                    </div>
                                </div>
                                <div class="topRight ms-auto">
                                    <form action="" method="GET">
                                        <button name="like" value="<?= $ID_CAR ?>" style="border: none;background-color:rgba(0,0,0,0);">
                                            <img class="likeButton me-2" src="./Asset/shopAsset/shopParalax/likeButton.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="harga text-danger">
                                <!-- HARGA -->
                                <?= rupiah($car["car_price"]) ?>
                            </div>
                            <div class="anotherInfo" style="font-size: 0.7em; font-weight:300;color:rgb(71, 71, 71);">
                                <!-- TRANSMISI KM LOKASI -->
                                <?= $car["car_transmission"] ?> | <?= number_format($car["car_kilometer"]) ?> km | <?= $car["car_location"] ?>
                            </div>
                            <form action="">
                                <form action="" method="GET">
                                    <button class="btn btn-primary mt-2" name="addToCart" value="<?= $ID_CAR ?>">
                                        Add to cart
                                    </button>
                                </form>
                            </form>
                        </h5>

                    </div>
                </div>

            </a>
        </div>
    <?php
    }
    ?>

</div>

<!-- PAGINATION -->
<div class="paginationContainer">
    <nav aria-label="...">
        <ul class="pagination">
            <?php
            // echo "<script>alert('$currentPage');</script>";
            if ($_GET["page"] == 0) {
            ?>
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item " aria-current="page">
                    <a class="page-link" href="#" onclick="changePage('1')">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#" onclick="changePage('2')">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            <?php } else { ?>
                <li class="page-item ">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#" onclick="changePage('-1')"><?= $_GET["page"] ?></a></li>
                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#" onclick="changePage('0')"><?= $_GET["page"] + 1 ?></a>
                </li>
                <li class="page-item"><a class="page-link" href="#" onclick="changePage('1')"><?= $_GET["page"] + 2 ?></a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>