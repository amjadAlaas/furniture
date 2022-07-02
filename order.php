<?php
include 'init.php';


$do = isset($_GET['do']) ? $_GET['do'] : 'addOrderForm';

if ($do == 'addOrderForm') {
   $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        // Select All Data Depend On This ID

        $stmt = $con->prepare("SELECT * FROM items WHERE id = ?");

        // execute Query

        $stmt->execute(array($itemid));

        // Fetch All Data

        $item = $stmt->fetch();

        // The Row Count

        $count = $stmt->rowCount();

        if ($count > 0) { 

?>

    <div class="container">
        <form action="order.php?do=InsertOrder" method="POST" style="width: 50%; margin: 20px auto;">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Enter Your Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Enter Your Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="address" placeholder="Enter Your Email">
            </div>
            <div class="form-group">
                <input type="text"  hidden="hidden" class="form-control" name="itemid" value="<?= $item['id'] ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block btn-lg link">
            </div>
        </form>
    </div>


<?php } else {

        echo "<div class='container'>";

        $theMsg = "<div class='alert-danger'>There is No Such ID </div>";

        redirectHome($theMsg);

        echo "</div>";
    }
    } elseif ($do == 'InsertOrder') {

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $address = $_POST['address'];
        $itemid  = $_POST['itemid'];

        $formerrors = array();

        if (empty($name)) {

            $formerrors[] = 'Name connot be <strong>empty</strong>';
        }
        if (empty($email)) {

            $formerrors[] = 'email connot be <strong>empty</strong>';
        }
        if (empty($address)) {

            $formerrors[] = 'address connot be <strong>empty</strong>';
        }
        if (empty($itemid)) {

            $formerrors[] = 'itemid connot be <strong>empty</strong>';
        }
        foreach ($formerrors as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        if (empty($formerrors)) {
            $stmt = $con->prepare("INSERT INTO 

                            orders(name, email, address, item_id)

                        VALUE(:zname, :zemail, :zaddress, :zitemid)");

            $stmt->execute(array(
                'zname'     => $name,
                'zemail'     => $email,
                'zaddress'    => $address,
                'zitemid'    => $itemid
            ));

            $theMsg = '<div class="alert alert-success">' . $count = $stmt->rowCount() . 'record Inserted' . '<div>';
            redirectHome($theMsg, 'back');
        }
    } else {

        echo "<div class='container'>";

        $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";

        redirectHome($theMsg);

        echo "</div>";
    }
}
