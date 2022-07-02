<?php

ob_start(); //Ouput Buffering Start

session_start();

if (isset($_SESSION['admin'])) {

    $pageTitle = 'Dashboard';

    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {

        $stmt = $con->prepare("SELECT 
                                    orders.* ,
                                    items.name AS Product_Name
                                FROM 
                                    orders 
                                INNER JOIN 
                                    items 
                                ON 
                                    items.id = orders.item_id 
                                WHERE status='0'
                                ORDER BY id DESC");
        $stmt->execute();

        // Assign To Variable
        $orders = $stmt->fetchAll();

        if (!empty($orders)) { ?>
            <h2 class="h1 text-center">Manage Orders</h2>
            <div class="container">
                <div class="table-responsive text-center">
                    <table class="main-table magnage-items table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Client Name</td>
                            <td>Client Email</td>
                            <td>Client Address</td>
                            <td>item_id</td>
                            <td>status</td>
                            <td>Product Name</td>
                            <td></td>
                        </tr>
                        <?php
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>" . $order['id'] . "</td>";
                            echo "<td>" . $order['name'] . "</td>";
                            echo "<td>" . $order['email'] . "</td>";
                            echo "<td>" . $order['address'] . "</td>";
                            echo "<td>" . $order['item_id'] .  "</td>";
                            if ($order['status'] === '0') {
                                echo "<td><a href='dashboard.php?do=active&orderid=" . $order['id']  . "' class='btn btn-info'><i class='fa fa-edit'></i> Active Order</a>" .  "</td>";
                            } else {
                                echo "<td class='text-success'>Order Has Been Seen</i></td>";
                            }
                            echo "<td>" . $order['Product_Name'] .  "</td>";
                            echo "<td><a href='dashboard.php?do=delete&orderid=" . $order['id']  . "' class='btn btn-danger'><i class='fa fa-close'></i> Delete Order</a>" .  "</td>";
                        }
                        ?>
                    </table>
                </div>
            </div>

        <?php } else { ?>
            <h2 class="h1 text-center">there is no Orders show</h2>


    <?php }
    } elseif ($do == 'active') {
        echo '<h2 class="h1 text-center">Activate Order</h2>';

        echo '<div class="container">';
        $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;

        $check = checkItem('id', 'orders', $orderid);

        if ($check > 0) {

            $stmt = $con->prepare("UPDATE orders SET status = 1 WHERE id = ?");

            $stmt->execute(array($orderid));

            $theMsg = '<div class="alert alert-success">' . $count = $stmt->rowCount() . 'record Activated' . '</div>';

            redirectHome($theMsg);
        } else {

            $theMsg = "<div class='alert-danger'>This ID is NOT Found</div>";

            redirectHome($theMsg);
        }
        echo "</div>";
    } elseif ($do == 'delete') {
        echo '<h2 class="h1 text-center">Delete Order</h2>';

        echo '<div class="container">';
        $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;

        $check = checkItem('id', 'orders', $orderid);

        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM `orders` WHERE `orders`.`id` = ?");

            $stmt->execute(array($orderid));

            $theMsg = '<div class="alert alert-success">' . $count = $stmt->rowCount() . 'record deleted' . '</div>';

            redirectHome($theMsg, 'back');
        } else {

            $theMsg = "<div class='alert-danger'>This ID is NOT Found</div>";

            redirectHome($theMsg, 'back');
        }
        echo "</div>";
    }


    ?>
<?php
    //End Dashboard Page

    include $tbls . 'footer.php';
} else {

    header('Location: index.php');
    exit();
}

ob_end_flush();

?>