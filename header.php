<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/animate.css">
</head>

<body>

    <!-- Start Upperbar -->
    <div class="upper-bar">
        <div class="container">
            <div class="row">
                <div class="brand col-lg col-md-12">
                    <h2>My.<span>.House</span></h2>
                </div>
                <div class="call-us col-lg col-md-4">
                    <p class="d-flex"><i class="mr-2 fa fa-telegram fa-2x"></i>amjad.alass94@gmail.com</p>
                </div>
                <div class="call-us col-lg col-md-4">
                    <p class="d-flex"><i class="fa fa-phone fa-2x"></i>Call SYR: +963936168035</p>
                </div>
                <div class="quote col-lg col-md-4">
                    <p>request a quote</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Upperbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewItems.php">View All Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewItems.php?do=searchForm">search Product</a>
                    </li>
                    <?php
                    if (isset($_SESSION['admin'])) {
                        echo ' <li class="nav-item">';
                        echo '<a class="nav-link" href="admin/dashboard.php">dashbaord</a>';
                        echo '</li>';
                    } else {
                        echo ' <li class="nav-item">';
                        echo '<a class="nav-link" href="admin/index.php">login</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>