<?php
require_once("connection.php");
// FETCH Inspection
$stmt = $conn->prepare("SELECT * FROM inspection");
$stmt->execute();
$inspections = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// ACTIVE INSPECTION
$inspectionID = $_GET["id_inspection"];

if ($_GET["action"] == 0) {
    $stmt = $conn->query("UPDATE inspection SET status = 'confirmed' WHERE id_inspection = $inspectionID");
} else if ($_GET["action"] == 1) {
    $stmt = $conn->query("UPDATE inspection SET status = 'denied' WHERE id_inspection = $inspectionID");
    echo "BERHASIL DENY MOBIL!";
?>
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
            <th>Action</th>
        </tr>
        <!-- NOTE : NGKOK FOR EN SEBANYAK 5 KALI AE (NAMPILNO MEK 5 ORDER) -->
        <?php
        foreach ($inspections as $key => $value) {
        ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $value["car_brand"] ?></td>
                    <td><?= $value["car_model"] ?></td>
                    <td><?= $value["car_name"] ?></td>
                    <td><?= $value["car_price"] ?></td>
                    <td class="hide">
                        <?php if ($value["status"] == "waiting") { ?>
                            <p class="text-primary"><?= $value["status"] ?> </p>
                        <?php } else if ($value["status"] == "confirmed") { ?>
                            <p class="text-success"><?= $value["status"] ?> </p>
                        <?php } else { ?>
                            <p class="text-danger"><?= $value["status"] ?> </p>
                        <?php } ?>
                    </td>
                    <td>
                        <button class="btn btn-success" name="confirm" onclick="confirmInspection('<?= $value['car_brand'] ?>:<?= $value['car_model'] ?>:<?= $value['car_type'] ?>:<?= $value['car_name'] ?>:<?= $value['car_transmission'] ?>:<?= $value['car_year'] ?>:<?= $value['car_km'] ?>:<?= $value['car_price'] ?>:<?= $value['car_location'] ?>:<?= $value['car_status'] ?>:<?= $value['fuel'] ?>:<?= $value['color'] ?>:<?= $value['seat'] ?>:<?= $value['registration_date'] ?>:<?= $value['registration_type'] ?>:<?= $value['kilometer_driven'] ?>:<?= $value['sparekey'] ?>:<?= $value['service_book'] ?>:<?= $value['warranty'] ?>:<?= $value['period'] ?>:<?= $value['id_inspection'] ?>')">Confirm</button>
                        <button class="btn btn-danger" name="deny" onclick="denyInspection('<?= $value['id_inspection'] ?>')">Deny</button>
                    </td>
                </tr>
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
<?php
}
?>