<?php
	session_start();

    require 'config/config.php';
    // echo "<br>";
    // echo $page_url;
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
        <div class="container col-12 col-md-10 col-lg-8 ">
            <div class="row">

							<?php

							// 1. Establish DB Connection.
							$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

							if ( $mysqli->connect_errno ) :
							    // Connection Error.
							    echo $mysqli->connect_error;
							else :
							    // Connection Success.

							    $mysqli->set_charset('utf8');

							    $sql = "SELECT * FROM inventory
							                    WHERE 1=1";


							    if ( isset($_GET['id']) && !empty($_GET['id']) ) {
							            $sql .= " AND  item_id = " . $_GET['id'];
							    }


							     $sql .= ";";

							                     //echo $sql . "<hr>";

							     $results = $mysqli->query($sql);

							     if (!$results) :
							                        // SQL Error.
							    echo $mysqli->error;
							     else :

							         while ( $row = $results->fetch_assoc() ) :

							?>


							<div class="col-12 ">
							  <div class="m-2">
							     <!-- <a href="addItem.php" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Add to Cart</a> -->
							     	 <div class="col-12 mt-4">
							         <h2 class="text-center"><?php echo $row['item_name']; ?><h2>
							       </div>
										 <?php
										 if ( isset($_GET['message']) && !empty($_GET['message']) ) :

										 ?>
										 <div class="col-12 mt-4">
										 	<h5 class="text-center"><?php echo $_GET['message']; ?><h5>
										 </div>
										 <?php
									 endif;

										 ?>

							       <div class="col-10 col-md-8 col-lg-5 container">
							         <div class="m-2">
							         <img src="<?php echo $row['image_url']; ?>" alt="category_2" class="img-fluid mb-2">
							          </div>
							      </div>

							      <div class="col-12 ">
							        <div class="m-2">
							           <p>Price:$<?php echo $row['item_price']; ?><p>
							         </div>
							     </div>
							     <div class="col-12 ">
							       <div class="m-2">
							          <p>Description:<?php echo $row['description']; ?><p>
							        </div>
							    </div><a href="addCart.php?id=<?php echo $_GET['id']; ?>",role="button" class="btn btn-primary" id="cart">Add to Cart</a>
							   </div>
							</div>




							<?php
							endwhile;
							endif; /* ELSE Results Received */
							$mysqli->close();
							endif; /* ELSE Connection Success */

							?>



        </div>

        </div>
    </div>







</body>

<script>



</script>

</html>
