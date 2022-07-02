<?php
ob_start();

session_start();

include 'init.php';
?>

<!-- Start Slider -->
<div class="slider">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"><span></span></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"><span></span></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"><span></span></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active item1">
            </div>
            <div class="carousel-item item2">
            </div>
            <div class="carousel-item item3">
            </div>
        </div>
    </div>
</div>
<!-- End Slider -->
<div class="border-in-slider">
    <p class="lead">be part of BUSINESS</p>
    <h4>Request A Quote</h4>
</div>
<div class="conact-us text-center wow slideInUp" data-wow-offset="0">
    <h6 class="wow slideInUp" data-wow-offset="0" data-wow-duration="0" data-wow-delay="0">Contact us</h6>
    <h2 class=text-center>Contact us<h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <form action="insertMessages.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter Your Name">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="image" placeholder="Enter Your Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" placeholder="Enter Your Email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="phone" placeholder="Enter Your Phone">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control input-lg" name="message" placeholder="your Message"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block btn-lg link">Send Your Opinion</a>
                            </div>
                        </form>
                    </div>
                    <?php
                    $stmt = $con->prepare("SELECT 
                    * 
                FROM 
                    messages 
                WHERE status='1'
                LIMIT 4");
                    $stmt->execute();

                    // Assign To Variable
                    $messages = $stmt->fetchAll();

                    ?>
                    <div class="col-md-8 col-sm-6 testimonials">

                        <div id="carouselSecond" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselSecond" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselSecond" data-slide-to="1"></li>
                                <li data-target="#carouselSecond" data-slide-to="2"></li>
                                <li data-target="#carouselSecond" data-slide-to="3"></li>
                                <li data-target="#carouselSecond" data-slide-to="4"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="carousel-box active">
                                        <p>this section to show what our client say</p>
                                        <h5>testimonials</h5>
                                    </div>
                                    <img class="d-block w-100" src="images/architecture-1837150_1280.jpg" alt="First slide">
                                </div>
                                <?php
                                foreach ($messages as $message) {

                                ?>
                                    <div class="carousel-item">
                                        <div class="carousel-box">
                                            <p><?php echo $message['message'] ?></p>
                                            <h5><?php echo $message['name'] ?></h5>
                                        </div>
                                        <img class="d-block w-100" src="admin/uploadImage/messages/<?= $message['image'] ?>" alt="First slide">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
</div>
<?php
$stmt = $con->prepare("SELECT 
                                *
                            FROM 
                                items 
                            ORDER BY id DESC
                            LIMIT 6");
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
                            <a href="order.php?itemid=<?= $item['id'] ?>" class="card-link btn">buy it Nwo</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
include 'footer.html';
ob_end_flush();
