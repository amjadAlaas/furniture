<?php
ob_start();

session_start();

include 'init.php';
$do = isset($_GET['do']) ? $_GET['do'] : 'all';

if ($do == 'all') {

    $stmt = $con->prepare("SELECT
*
FROM
items
ORDER BY id DESC
");
    $stmt->execute();

    // Assign To Variable
    $items = $stmt->fetchAll();
?>
    <div class="Products text-center">
        <div class="container">
            <h6 class="wow slideInUp" data-wow-offset="0" data-wow-duration="0" data-wow-delay="0">Products</h6>
            <h2>Our Products</h2>
            <div class="row">
                <?php
                foreach ($items as $item) {
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="parent-img">
                                <img class="card-img-top" src="admin/uploadImage/<?php echo $item['image'] ?>" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-left">Name : <?php echo $item['name'] ?></h5>
                                <p class="card-text text-left">Color : <?php echo $item['color'] ?></p>
                                <p class="card-text text-left">Price : <?php echo $item['price'] ?></p>
                                <p class="card-text text-left"><?php echo $item['description'] ?></p>
                                <a href="#" class="card-link btn">buy it Nwo</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

<?php

} elseif ($do == 'searchForm') { ?>
    <div class="container">
        <form action="?do=searchDB" method="POST" style="width: 50%; margin: 20px auto;">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="search Product">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block btn-lg link">
            </div>
        </form>
    </div>

    <?php
} elseif ($do == 'searchDB') {
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $search = preg_replace("#[^0-9a-z]#i", "", $search);
        $stmt = $con->prepare("SELECT 
                    * 
                FROM 
                    items 
                WHERE name LIKE '%$search%' ");
        $stmt->execute();

        // Assign To Variable
        $search = $stmt->fetchAll();

        $count = $stmt->rowCount();

        if ($count > 0) { ?>
            <div class="Products text-center">
                <div class="container">
                    <div class=row>
                        <?php foreach ($search as $s) { ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card">
                                    <div class="parent-img">
                                        <img class="card-img-top" src="admin/uploadImage/<?php echo $s['image'] ?>" alt="Card image cap">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-left">Name : <?php echo $s['name'] ?></h5>
                                        <p class="card-text text-left">Color : <?php echo $s['color'] ?></p>
                                        <p class="card-text text-left">Price : <?php echo $s['price'] ?></p>
                                        <p class="card-text text-left"><?php echo $s['description'] ?></p>
                                        <a href="#" class="card-link btn">buy it Nwo</a>
                                    </div>
                                </div>
                            </div>
                        <?php  } ?>
                    </div>
                </div>
            </div>
    <?php
        } else {
            echo "<div class='container'>";

            $theMsg = "<div class='alert-danger pt-3 pb-3'>There is No Such Name </div>";

            redirectHome($theMsg);

            echo "</div>";
        }
    } else {
        echo "<div class='container'>";

        $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";

        redirectHome($theMsg);

        echo "</div>";
    }
}
include 'footer.html';
ob_end_flush();
