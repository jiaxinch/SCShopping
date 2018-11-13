<?php
session_start();
require 'config/config.php';
// 1. Establish DB Connection.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ( $mysqli->connect_errno ) :
    // Connection Error.
    echo $mysqli->connect_error;
else :
    // Connection Success.

    $mysqli->set_charset('utf8');

    $sql = "UPDATE inventory
        SET valid=0
                    WHERE 1=1";


//    if ( isset($_GET['id']) && !empty($_GET['id']) ) {
            $sql .= " AND  item_id = " . $_GET['id'];
//    }
//    $sql .= " AND user_id = " . $_SESSION['user_id'];

     $sql .= ";";



     $results = $mysqli->query($sql);

     if (!$results) :
                        // SQL Error.
    echo $mysqli->error;
     else :










  endif; /* ELSE Results Received */
$mysqli->close();
endif; /* ELSE Connection Success */
$result_status="item successfully deleted";
 $goto='Location:'.$_SERVER['HTTP_REFERER'].'&message='.$result_status;
header($goto)
?>
