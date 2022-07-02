<?php

ob_start();

session_start();

$pageTitle = 'Items';

if (isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {



        $stmt = $con->prepare("SELECT 
                                    items.* ,
                                    categories.Name AS Category_Name
                                FROM 
                                    items 
                                INNER JOIN 
                                    categories 
                                ON 
                                    categories.ID = items.Cat_ID 
                                ORDER BY id DESC");
        $stmt->execute();

        // Assign To Variable
        $items = $stmt->fetchAll();

        if (!empty($items)) {

?>
            <h2 class="h1 text-center">Manage Items</h2>
            <div class="container">
                <div class="table-responsive text-center">
                    <table class="main-table magnage-items table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Name</td>
                            <td>Image</td>
                            <td>price</td>
                            <td>color</td>
                            <td>description</td>
                            <td>Category_Name</td>
                            <td></td>
                        </tr>
                        <?php
                        foreach ($items as $item) {
                            echo "<tr>";
                            echo "<td>" . $item['id'] . "</td>";
                            echo "<td>" . $item['name'] . "</td>";
                            echo "<td><img src='uploadImage/" . $item['image'] . "' alt=''></td>";
                            echo "<td>" . $item['price'] . "</td>";
                            echo "<td>" . $item['color'] . "</td>";
                            echo "<td>" . $item['description'] .  "</td>";
                            echo "<td>" . $item['Category_Name'] .  "</td>";
                            echo "<td> 
                                        <a href='items.php?do=Edit&itemid=" . $item['id'] .  "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='items.php?do=Delete&itemid=" . $item['id'] .  "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                            echo "</td>";
                        }
                        ?>


                    </table>
                </div>
                <a href="items.php?do=Add" class="btn btn-primary" y> <i class="fa fa-plus-circle"></i>New Item</a>
            </div>
        <?php
        } else {
            echo '<div class="container">';
            echo '<div class="alert alert-info">There is no record to show</div>';
            echo '<div>';
            echo '<a href="items.php?do=Add" class="btn btn-primary"y> <i class="fa fa-plus-circle"></i>New Item</a>';
        }


        // <!-- end  Manage Members Page -->

    } elseif ($do == 'Add') { ?>

        <h2 class="h1 text-center">Add New Item</h2>
        <div class="container">
            <form class="form text-center form-item" action="?do=Insert" method="POST" enctype="multipart/form-data">
                <!-- Start Name Field -->
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Name Of Item">
                </div>
                <!-- End Name Field -->
                <!-- Start Price Field -->
                <div class="form-group">
                    <input type="text" name="price" class="form-control" placeholder="Price Of Item">
                </div>
                <!-- End Price Field -->
                <!-- Start Color Field -->
                <div class="form-group">
                    <input type="text" name="color" class="form-control" placeholder="Color Of Item">
                </div>
                <!-- End Color Field -->
                <!-- Start image Field -->
                <div class="form-group">
                    <input type="file" name="image" class="form-control">
                </div>
                <!-- End image Field -->
                <!-- Start Description Field -->
                <div class="form-group">
                    <input type="text" name="description" class="form-control" placeholder="Decription">
                </div>
                <!-- End Description Field -->
                <!-- Start Categories Field -->
                <div class="form-group">
                    <select name="category" class="form-control">
                        <option value="0">category</option>
                        <?php
                        $stmt2 = $con->prepare("SELECT * FROM categories");
                        $stmt2->execute();
                        $cats = $stmt2->fetchAll();
                        foreach ($cats as $cat) {
                            echo "<option value='" . $cat['id'] . "'> " . $cat['name'] .  " </option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- End Categories Field -->
                <!-- Start Submit Field -->
                <div class="form-group">
                    <div class="row d-flex justify-content-center ">
                        <input type="submit" value="Add Item" class="offset-2 btn btn-primary btn-lg">
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>
        <?php

    } elseif ($do == 'Insert') {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h2 class="h1 text-center">Insert  Member</h2>';

            echo '<div class="container">';

            //get Image
            $image = $_FILES['image'];

            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageType = $_FILES['image']['type'];

            $listExtention = array("jpeg", "jpg", "png", "gif");
            $imageFullName = explode('.', $imageName);
            $imageExtentionName = end($imageFullName);
            $imageLowerEx = strtolower($imageExtentionName);


            // get variables from Add Page


            $name           = $_POST['name'];
            $price          = $_POST['price'];
            $color          = $_POST['color'];
            $description    = $_POST['description'];
            $cat            = $_POST['category'];

            // validate my form
            $formerrors = array();

            if (empty($name)) {

                $formerrors[] = 'Name connot be <strong>empty</strong>';
            }
            if (empty($price)) {

                $formerrors[] = 'price connot be <strong>empty</strong>';
            }
            if (empty($color)) {

                $formerrors[] = 'Color connot be <strong>empty</strong>';
            }
            if (!empty($imageName) && !in_array($imageLowerEx, $listExtention)) {
                $formerrors[] = 'This Extention Is <strong> Not Allowed</strong>';
            }
            if (empty($imageName)) {
                $formerrors[] = 'Image Is <strong>Required</strong>';
            }
            if ($imageSize > 2097152) {
                $formerrors[] = 'This Size Larger Than<strong>2MB</strong>';
            }
            if (empty($description)) {

                $formerrors[] = 'Country connot be <strong>empty</strong>';
            }
            if ($cat == 0) {

                $formerrors[] = 'You Must Choose  <strong>Category</strong>';
            }
            foreach ($formerrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            // after Passed error


            if (empty($formerrors)) {

                $image = rand(0, 1000000) . '_' . $imageName;
                move_uploaded_file($imageTmp, "uploadImage\\" . $image);

                // Insert User info to data


                $stmt = $con->prepare("INSERT INTO 

                            items(name, price, 	color, image, description, cat_id)

                        VALUE(:zname, :zprice, :zcolor, :zimage, :zdesc, :zcat)");

                $stmt->execute(array(
                    'zname'     => $name,
                    'zprice'     => $price,
                    'zcolor'    => $color,
                    'zimage'    => $image,
                    'zdesc'     => $description,
                    'zcat'      => $cat
                ));

                // Ehco success message
                $theMsg = '<div class="alert alert-success">' . $count = $stmt->rowCount() . 'record Inserted' . '<div>';

                redirectHome($theMsg, 'back');
            }
        } else {

            echo "<div class='container'>";

            $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg);

            echo "</div>";
        }
        echo '</div>';
    } elseif ($do == 'Edit') {

        // Check if Get Request Itemid Is Numiric & Get Its Integer Value

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        // Select All Data Depend On This ID

        $stmt = $con->prepare("SELECT * FROM items WHERE id = ?");

        // execute Query

        $stmt->execute(array($itemid));

        // Fetch All Data

        $item = $stmt->fetch();

        // The Row Count

        $count = $stmt->rowCount();

        if ($count > 0) { ?>

            <h2 class="h1 text-center">Edit Item</h2>
            <div class="container">
                <form class="form text-center" action="?do=Update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                    <!-- Start Name Field -->
                    <div class="form-group">
                        <div class="row d-flex justify-content-center">
                            <label class="col-sm-2 control-lable">Name</label>
                            <input type="text" name="name" class="col-sm-10 col-md-4 form-control" required="required" value="<?php echo $item['name'] ?>">
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start Price Field -->
                    <div class="form-group">
                        <div class="row d-flex justify-content-center">
                            <label class="col-sm-2 control-lable">Price</label>
                            <input type="text" name="price" class="col-sm-10 col-md-4 form-control" required="required" value="<?php echo $item['price'] ?>">
                        </div>
                    </div>
                    <!-- End Price Field -->
                    <!-- Start Country Made Field -->
                    <div class="form-group">
                        <div class="row d-flex justify-content-center">
                            <label class="col-sm-2 control-lable">Country Made</label>
                            <input type="text" name="color" class="col-sm-10 col-md-4 form-control" required="required" value="<?php echo $item['color'] ?>">
                        </div>
                    </div>
                    <!-- End Country Made Field -->
                    <!-- Start Description Field -->
                    <div class="form-group">
                        <div class="row d-flex justify-content-center">
                            <label class="col-sm-2 control-lable">Description</label>
                            <input type="text" name="description" class="col-sm-10 col-md-4 form-control" required="required" value="<?php echo $item['description'] ?>">
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Start Categories Field -->
                    <div class="form-group">
                        <div class="row d-flex justify-content-center">
                            <label class="col-sm-2 control-lable">Category</label>
                            <select name="category" class="form-control col-sm-10 w-auto " required="required">
                                <?php
                                $stmt2 = $con->prepare("SELECT * FROM categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                                foreach ($cats as $cat) {
                                    echo "<option value='" . $cat['id'] . "'";
                                    if ($item['cat_id'] == $cat['id']) {
                                        echo "selected";
                                    }
                                    echo "> " . $cat['name'] .  " </option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Categories Field -->
                    <!-- Start Submit Field -->
                    <div class="form-group">
                        <div class="row d-flex justify-content-center ">
                            <input type="submit" value="Save Item" class="offset-2 btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>

    <?php



        } else {

            echo "<div class='container'>";

            $theMsg = "<div class='alert-danger'>There is No Such ID </div>";

            redirectHome($theMsg);

            echo "</div>";
        }
    } elseif ($do == 'Update') {

        echo '<h2 class="h1 text-center">Update Item</h2>';

        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // get variables from Edit Page
            $itemid     = $_POST['itemid'];
            $name   = $_POST['name'];
            $price  = $_POST['price'];
            $color   = $_POST['color'];
            $description   = $_POST['description'];
            $cat   = $_POST['category'];

            // validate my form
            // validate my form
            $formerrors = array();

            if (empty($name)) {

                $formerrors[] = 'Name connot be <strong>empty</strong>';
            }
            if (empty($price)) {

                $formerrors[] = 'price connot be <strong>empty</strong>';
            }
            if (empty($color)) {

                $formerrors[] = 'color connot be <strong>empty</strong>';
            }
            if (empty($description)) {

                $formerrors[] = 'Description connot be <strong>empty</strong>';
            }
            if ($cat == 0) {

                $formerrors[] = 'You Must Choose  <strong>Category</strong>';
            }
            foreach ($formerrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            // after Passed error
            if (empty($formerrors)) {

                // Update data form
                $stmt = $con->prepare("UPDATE 
                                                items 
                                            SET
                                                name = ?, 
                                                price = ?,
                                                color = ?,
                                                description = ?,
                                                cat_id = ?
                                            WHERE 
                                                id = ? ");
                $stmt->execute(array($name, $price, $color, $description, $cat, $itemid));

                // Ehco success message
                $theMsg = '<div class="alert alert-success">' . $count = $stmt->rowCount() . 'record Updated' . '</div>';

                redirectHome($theMsg, 'back');
            }
        } else {

            $theMsg = "<div class='alert-danger'>Sorry You Connt Browse This Page Directly</div>";

            redirectHome($theMsg);
        }
        echo '</div>';
    } elseif ($do == 'Delete') {

        // Delete Item Page
        echo '<h2 class="h1 text-center">Delete Item</h2>';

        echo '<div class="container">';

        // Check If Get Request userid Is Numeric && And Integer

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $check = checkItem('id', 'items', $itemid);

        if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM items WHERE id = :zid");

            $stmt->bindparam(':zid', $itemid);

            $stmt->execute();

            $theMsg = '<div class="alert alert-danger">' . $count = $stmt->rowCount() . 'record Deleted' . '</div>';

            redirectHome($theMsg, 'back');
        } else {

            $theMsg = "<div class='alert-danger'>This ID is NOT Found</div>";

            redirectHome($theMsg);
        }
        echo "</div>";
    }
    include $tbls . 'footer.php';
} else {

    header('Location:index.php');

    exit();
}
ob_end_flush();

    ?>