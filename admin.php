<?php
require_once "./_autoload.php";

// Check if a new device should be inserted
if(isset($_POST["newDevice"]) && $_POST["newDevice"] == 1) {
    $newDevice = new Device(
            $_POST["device-id"],
            $_POST["device-type"] ?? 0,
            $_POST["device-name"] ?? 0,
            $_POST["device-cart-id"] ?? 0,
            $_POST["device-brand"] ?? ""
    );
    $newDevice->save();
    // Temporary user notification while there is nothing like a notification service implemented
    echo '<script>setTimeout(function() { alert("Device was added/updated!"); }, 1000);</script>';
}

if(isset($_POST["deleteDevice"]) && !empty($_POST["deleteDevice"])) {
    $deletedDevice = new Device($_POST["deleteDevice"]);
    $deletedDevice->delete();
    echo '<script>setTimeout(function() { alert("Device with ID '. $deletedDevice->getDeviceID() .' was deleted!"); }, 1000);</script>';
}


require_once "./view/template/header.php";
require_once "./view/template/navbar.php";

// Including of bootstrap-modals
require_once "./view/template/modal/modal_admin_device.php";
require_once "./view/template/modal/modal_history_device.php";
require_once "./view/template/modal/modal_delete_device.php";

require_once "./view/template/modal/modal_admin_cart.php";
require_once "./view/template/modal/modal_history_cart.php";
require_once "./view/template/modal/modal_delete_cart.php";

require_once "./view/template/modal/modal_add_cart.php";
require_once "./view/template/modal/modal_add_device.php";

// Testdata for data to modal
$cartID = "123456";

?>
<main role="main" class="container">
    <div class="row">
        <div class="col">
        <button disabled="disabled" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_cart">
                <i class="fas fa-plus-square"></i> Wagen anlegen
            </button>
            <h4>Wagen verwalten:</h4>
            <table id="admin_carts" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Wagen-ID</th>
                    <th>Wagen-Name</th>
                    <th>Anzahl-Geräte</th>
                    <th>Optionen</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Notebooks</td>
                    <td>15</td>
                    <td class="function-icon">
                        <button type="button" class="btn" data-toggle="modal" data-cartid="<?php echo $cartID; ?>" data-target="#modal_admin_cart">
                        <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn" data-toggle="modal" data-cartid="<?php echo $cartID; ?>" data-target="#modal_history_cart">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn" data-toggle="modal" data-cartid="<?php echo $cartID; ?>" data-target="#modal_delete_cart">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tablets</td>
                    <td>5</td>
                    <td class="function-icon">
                        <button type="button" class="btn" data-toggle="modal" data-cartid="<?php echo $cartID; ?>" data-target="#modal_admin_cart">
                        <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn" data-toggle="modal" data-cartid="<?php echo $cartID; ?>" data-target="#modal_history_cart">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn" data-toggle="modal" data-cartid="<?php echo $cartID; ?>" data-target="#modal_delete_cart">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
        <button disabled="disabled" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_device">
            <i class="fas fa-plus-square"></i> Gerät anlegen
        </button>
            <h4>Geräte verwalten:</h4>
            <table id="admin_devices" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Geräte-ID</th>
                    <th>Type</th>
                    <th>Hersteller</th>
                    <th>Name</th>
                    <th>Wagen-ID</th>
                    <th>Optionen</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach (Device::loadAll() as $device): ?>
                <tr>
                    <td><?= $device->getDeviceID() ?></td>
                    <td><?= $device->getType() ?></td>
                    <td><?= $device->getBrand() ?></td>
                    <td><?= $device->getName() ?></td>
                    <td><?= $device->getCartId() ?></td>
                    <td class="function-icon">
                        <button type="button" class="btn edit-device-button" data-toggle="modal" data-target="#modal_admin_device" data-device='<?= json_encode($device) ?>' >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn" data-toggle="modal" data-target="#modal_history_device">
                            <i class="fas fa-eye"></i>
                        </button>
                            <button type="submit" data-device='<?= json_encode($device) ?>' class="btn delete-device-button" data-toggle="modal" data-target="#modal_delete_device">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php require_once "./view/template/footer.php"; ?>
<script>
    // Datatable attributes
    $(document).ready(function () {
        $('#admin_devices').DataTable({
            language: {
                "paginate": {
                    "previous": "<<",
                    "next": ">>",
                },
                "search": "Suche:",
                "sInfo": "Ergebnisse _START_ bis _END_ von (_TOTAL_)",
                "infoFiltered":   "(gefiltert aus insgesamt _MAX_ Einträgen)",
                "infoEmpty":        "Ergebnisse 0 bis 0 von (0)",
                "sEmptyTable": "Keine Einträge zum Anzeigen",
                "sZeroRecords": "Keine Einträge zum Anzeigen"
            },
            "lengthChange": false
        });
        $('#admin_carts').DataTable({
            language: {
                "paginate": {
                    "previous": "<<",
                    "next": ">>",
                },
                "search": "Suche:",
                "sInfo": "Ergebnisse _START_ bis _END_ von (_TOTAL_)",
                "infoFiltered":   "(gefiltert aus insgesamt _MAX_ Einträgen)",
                "infoEmpty":        "Ergebnisse 0 bis 0 von (0)",
                "sEmptyTable": "Keine Einträge zum Anzeigen",
                "sZeroRecords": "Keine Einträge zum Anzeigen"
            },
            "lengthChange": false
        });
    });

    //triggered when modal is about to be shown
    $('#modal_admin_cart').on('show.bs.modal', function(e) {
        var cartID = $(e.relatedTarget).data('cartid');
        $(e.currentTarget).find('input[name="cart-id"]').val(cartID);
    });
    $('#modal_delete_cart').on('show.bs.modal', function(e) {
        var cartID = $(e.relatedTarget).data('cartid');
       // $(e.currentTarget).find('input[name="cart-id"]').val(cartID);
    });
</script>
