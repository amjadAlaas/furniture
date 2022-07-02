<?php

    function getTitle() {

        global $pageTitle;
        
        if(isset($pageTitle)){

            echo $pageTitle;

        }else{

            echo 'Defualt';

        }

    }
    /* Redirect Function v2.0 
    ** This Function Accept Parameters
    ** $theMsg = Echo The Msg [ Error , success , danger ]
    ** $url = link you want to redirect 
    ** $second = seconds Before Redirecting
    */
    function redirectHome($theMsg, $url=null, $seconds = 3){
        
        if($url === null){

            $url = 'index.php';
            $link = 'HomePage';

        }else{

            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

                $url = $_SERVER['HTTP_REFERER'];
                
                $link = 'previous page';

            }else{

                $url = 'index.php';
                $link = 'HomePage';

            }

        }

        echo $theMsg ;

        echo "<div class='alert alert-success'>you will redirect to $link After " . $seconds . " seconds</div>";

        header("refresh:$seconds;url=$url");

        exit();

    }

    /*
    ** Check Items Function v1.0
    ** Function To Check Item In Database
    ** Function Accept Parameters
    ** $select = The Item To Select  [ Ex: user , category , Item ]
    ** $from = The Table To Select From [ Ex: users , items , categories ]
    ** $value = The Value Of Select [ Ex: amjad, box , electronics ]
    */

    function checkItem($select, $from, $value){

        global $con;

        $stetment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

        $stetment->execute(array($value));

        $count = $stetment->rowCount();

        return $count;

    }

    /*
    **Count Number Of Items Function v 1.0
    **Function To Count Number Of Rows
    **$item = The Item To Count 
    **$table = The Table To Choose From 
    */
    function countItems($item, $table){
        global $con;

        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

        $stmt2->execute();

        return $stmt2->fetchColumn();
    }

    /*
    ** Get Latest Records Function v1.0
    ** Function To Get Latest Items From Database [ Users, Items , Comments ]
    ** $select = Field To Select 
    ** $table  = The Table To Choose From
    ** $order  = The DESC Order
    ** $limit  = Number Of Record
    */

    function getLatest($select, $table, $order, $limit = 5){

        global $con;

        $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC  LIMIT $limit");

        $getStmt->execute();

        $rows = $getStmt->fetchAll();

        return $rows;

    }
