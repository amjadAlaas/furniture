<?php
    include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $image = $_FILES['image'];

    $imageName = $_FILES['image']['name'];
    $imageSize = $_FILES['image']['size'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageType = $_FILES['image']['type'];

    $listExtention = array("jpeg", "jpg", "png", "gif");
    $imageFullName = explode('.', $imageName);
    $imageExtentionName = end($imageFullName);
    $imageLowerEx = strtolower($imageExtentionName);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $formerrors = array();

    if (empty($name)) {

        $formerrors[] = 'Name connot be <strong>empty</strong>';
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
    if (empty($email)) {

        $formerrors[] = 'email connot be <strong>empty</strong>';
    }
    if (empty($phone)) {

        $formerrors[] = 'phone connot be <strong>empty</strong>';
    }
    if (empty($message)) {

        $formerrors[] = 'message connot be <strong>empty</strong>';
    }
    foreach ($formerrors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    if (empty($formerrors)) {

        $image = rand(0, 1000000) . '_' . $imageName;
        move_uploaded_file($imageTmp, "admin\uploadImage\messages\\" . $image);


        $stmt = $con->prepare("INSERT INTO 

                            messages(name, image, email, phone, message)

                        VALUE(:zname,:zimage, :zemail, :zphone, :zmessage)");
        $stmt->execute(array(
            'zname'    => $name,
            'zimage'   => $image, 
            'zemail'   => $email,
            'zphone'   => $phone,
            'zmessage' => $message
        ));
        $theMsg = '<div class="alert alert-success">' . $count = $stmt->rowCount() . 'record Inserted' . '<div>';
        redirectHome($theMsg, 'back', 30);
    } else {

        echo "<div class='container'>";

            $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";

            redirectHome($theMsg, 'back', 3);

        echo "</div>";
    }
    echo '</div>';

}
