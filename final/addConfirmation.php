<?php

require 'config/config.php';
	session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SC buy</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav.css">
	<style>

    </style>
</head>
<body>

	<?php include 'navigation.php'; ?>



    <div class ="container">
        <div class="row col-12">




            <?php
                // var_dump($_POST);

                if ( !isset($_POST['ItemName']) || empty($_POST['ItemName'])||
                 !isset($_POST['ItemDescription']) || empty($_POST['ItemDescription'])||
                 !isset($_POST['imageURL']) || empty($_POST['imageURL'])||
                 !isset($_POST['category']) || empty($_POST['category'])||
                 !isset($_POST['ItemNum']) || empty($_POST['ItemNum'])||
                 !isset($_POST['ItemPrice']) || empty($_POST['ItemPrice'])) :
                ?>

                    <div class="text-danger">Please fill out all required fields.</div>

                <?php

                else :
                    // All required fields present.

                    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    if ($mysqli->connect_errno) :
                        // DB Error
                        echo $mysqli->connect_error;
                    else :
                        // Connection Succuess

                        if ( isset($_POST['ItemName']) && !empty($_POST['ItemName']) ) {
                            $Itemname= "'".$_POST['ItemName']."'";
                        }
                        if ( isset($_POST['ItemDescription']) && !empty($_POST['ItemDescription']) ) {
                            $description = "'".$_POST['ItemDescription']."'";
                        }
                        if ( isset($_POST['imageURL']) && !empty($_POST['imageURL']) ) {
                            $image = "'".$_POST['imageURL']."'";
                        }
                        if ( isset($_POST['category']) && !empty($_POST['category']) ) {
                            $category = $_POST['category'];
                        }
                        if ( isset($_POST['ItemNum']) && !empty($_POST['ItemNum']) ) {
                            $Itemnum = $_POST['ItemNum'];
                        }
                        if ( isset($_POST['ItemPrice']) && !empty($_POST['ItemPrice']) ) {
                            $Itemprice = $_POST['ItemPrice'];
                        }

                        $sql = "INSERT INTO inventory (item_name, item_num,item_price,popularity,
                            rating,description,valid,category_id,image_url,rating_num)
                                        VALUES ("
                            . $Itemname
                            . ", "
                            . $Itemnum
                            . ", "
                            . $Itemprice
                            . ", "
                            . "0"
                            . ", "
                            . "0.0"
                            . ", "
                            . $description
                            . ", "
                            . "1"
                            . ", "
                            . $category
                            .","
                            . $image
                            .","
                            . "0"
                            . ");";

                        // echo $sql . "<hr>";

                        $results = $mysqli->query($sql);

                        if (!$results) :
                            // SQL Error
                            echo $mysqli->error;
                        else :
                            // SQL Success
            ?>
                        <div class="text-success"><span class="font-italic"><?php echo $_POST['ItemName']; ?></span> was successfully added.</div>

            <?php
                        endif; /* SQL Error */
                        $mysqli->close();
                    endif; /* DB Connection Connection Error */
                endif; /* Required input validtion */
            ?>






        </div>
    </div>







</body>
</html>
