<?php

ob_start();

session_start();

$pageTitle = 'Messages';

if (isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        $stmt = $con->prepare("SELECT * FROM messages");
        $stmt->execute();

        // Assign To Variable
        $messages = $stmt->fetchAll(); ?>
        <div class="container">
            <div class="table-responsive text-center">
                <table class="main-table magnage-items table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Image</td>
                        <td>email</td>
                        <td>phone</td>
                        <td>statuas</td>
                        <td>show</td>
                        <td>delete</td>
                    </tr>
                    <?php foreach ($messages as $message) { ?>
                        <tr>
                            <td><?= $message['id'] ?></td>
                            <td><?= $message['name'] ?></td>
                            <td><img src="uploadImage/messages/<?= $message['image'] ?>"></td>
                            <td><?= $message['email'] ?></td>
                            <td><?= $message['phone'] ?></td>
                            <td><?= $message['message'] ?></td>
                            <td>
                                <?php if($message['status'] =="0"){
                                ?><a href="?do=Activate&messageid=<?= $message['id'] ?>" class='btn btn-primary'><i class='fa fa-edit'></i>show</a></td>
                                <?php } ?>
                            <td><a href="?do=Delete&messageid=<?= $message['id'] ?>" class='btn btn-danger'><i class='fa fa-close'></i>Delete</a></td>
                        </tr>

                    <?php } ?>
                </table>
            </div>
        </div>
<?php
    } elseif ($do == 'Delete') {

        // Delete Member Page
        echo '<h2 class="h1 text-center">Delete Page</h2>';

        echo '<div class="container">';

        // Check If Get Request userid Is Numeric && And Integer

        $messageid = isset($_GET['messageid']) && is_numeric($_GET['messageid']) ? intval($_GET['messageid']) : 0;

        $check = checkItem('id', 'messages', $messageid);

        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM messages WHERE id = :zid");

            $stmt->bindparam(':zid', $messageid);

            $stmt->execute();

            $theMsg = '<div class="alert alert-danger">' . $count = $stmt->rowCount() . 'record Deleted' . '</div>';

            redirectHome($theMsg, 'back');
        } else {

            $theMsg = "<div class='alert-danger'>This ID is NOT Found</div>";

            redirectHome($theMsg);
        }
        echo "</div>";
    } elseif ($do == 'Activate') {

        echo '<h2 class="h1 text-center">Activate Member</h2>';

        echo '<div class="container">';
        $messageid = isset($_GET['messageid']) && is_numeric($_GET['messageid']) ? intval($_GET['messageid']) : 0;

        $check = checkItem('id', 'messages', $messageid);

        if ($check > 0) {

            $stmt = $con->prepare("UPDATE messages SET status = '1' WHERE id = ?");

            $stmt->execute(array($messageid));

            $theMsg = '<div class="alert alert-success">' . $count = $stmt->rowCount() . 'record Activated' . '</div>';

            redirectHome($theMsg, 'back', 5);
        } else {

            $theMsg = "<div class='alert-danger'>This ID is NOT Found</div>";

            redirectHome($theMsg, 'back', 5);
        }
        echo "</div>";
    }
    include $tbls . 'footer.php';
} else {

    header('Location:index.php');

    exit();
}
ob_end_flush();
