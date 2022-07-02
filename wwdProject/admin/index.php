<?php
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    
    include 'init.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT 
                                id, admin_name, password
                            FROM
                                admins
                            WHERE
                                admin_name=?
                            AND
                                password=?
                            LIMIT 1
    ");
    $stmt->execute(array($name, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
            $_SESSION['admin'] = $name; //register session name
            header('location: dashboard.php');
            exit();
    
    }
    }

?>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h4 class="text-center">Admin Login</h4>
        <input class="form-control" type="text" name="name" placeholder="Admin Name" autocomplete="off" />
        <input class="form-control" type="password" name="password" placeholder="Admin password" autocomplete="new-password" />
        <input class="btn btn-primary btn-block" type="submit" value="login">
    </form>
<?php
    include $tbls . 'footer.php';
?>