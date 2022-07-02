<?php

ob_start();

session_start();

$pageTitle = 'categories';

if (isset($_SESSION['admin'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {

        $stmt2 = $con->prepare("SELECT * FROM categories ");

        $stmt2->execute();

        $cats = $stmt2->fetchAll();

        if (!empty($cats)) { ?>

            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-edit"></i> Manage Categories
                    </div>
                    <div class="card-body">
                        <?php
                        foreach ($cats as $cat) {

                            echo "<div class='cat'>";
                                echo "<div class='hidden-buttons'>";
                                    echo "<a href='categories.php?do=Edit&catid=" . $cat['id'] .  "'class='btn btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                    echo "<a href='categories.php?do=Delete&catid=" . $cat['id'] .  "'class='btn btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                                echo "</div>";
                                echo "<h3>" . $cat['name'] . "</h3>";
                                echo "<div class='full-view'>";
                                    echo '<p>';
                                        if (empty($cat['description'])) {
                                            echo "This Category Has No Description";
                                        } else {
                                            echo $cat['Description'];
                                        }
                                    echo '</p>';
                                echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <a href="categories.php?do=Add" class="btn btn-primary add-category"><i class="fa fa-plus-circle"></i> Add New Category</a>
            </div>

<?php
        } else {
            echo '<div class="container">';
            echo '<div class="alert alert-info">There is no record to show</div>';
            echo '<div>';
            echo '<a href="categories.php?do=Add" class="btn btn-primary add-category"><i class="fa fa-plus-circle"></i> Add New Category</a>';
        }
    }
}
