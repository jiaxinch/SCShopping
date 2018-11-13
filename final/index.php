<?php
	session_start();
	require 'config/config.php';
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
	.fluid-image{
		height: 100%;
	}
    </style>
</head>
<body>

	<?php include 'navigation.php'; ?>

	<?php if ( isset($_SESSION['admin']) && $_SESSION['admin'] == true ) : ?>
	<div class ="container">
		<div class ="row col-12">
			<div class="col-4">
			</div>
			<div class="col-3">
				<a href="addItem.php" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Add a item</a>
			</div>
		</div>
	</div>
	<?php endif; ?>

    <div class ="container">
		<div class="col-12 mt-4">
		<h2 class="text-center">Shop By Category<h2>
	  </div>
        <div class="row col-12">
            <div class ="col-12 col-md-6 col-lg-3 cate">
				<a href="ItemPage.php?category=1">
                <img src="https://image.flaticon.com/sprites/new_packs/267776-food-and-restaurant.png" alt="category_1" class="img-fluid">
                <p class="text-center"> Food</p>
				</a>
            </div>

            <div class ="col-12 col-md-6 col-lg-3 cate">
					<a href="ItemPage.php?category=2">
                <img src="https://image.flaticon.com/sprites/new_packs/111006-drinks-set.png" alt="category_2" class="img-fluid">
                <p class="text-center"> Drink</p>
				</a>
            </div>
            <div class ="col-12 col-md-6 col-lg-3 cate">
					<a href="ItemPage.php?category=3">
                <img src="https://image.shutterstock.com/z/stock-vector-bathroom-necessities-icon-set-586742945.jpg" alt="category_3" class="img-fluid">
                <p class="text-center"> Home</p>
				</a>
            </div>

            <div class ="col-12 col-md-6 col-lg-3 cate">
					<a href="ItemPage.php?category=4">
                <img src="http://www.free-icons-download.net/images/book-icon-78892.png" alt="category_4" class="img-fluid">
                <p class="text-center"> Book</p>
				</a>
            </div>
        </div>
		<div class="col-12 mt-4">
		<h2 class="text-center">Top Seller<h2>
	  </div>
	  <div class="row col-12">

		  <?php


		  // 1. Establish DB Connection.
		  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		  if ( $mysqli->connect_errno ) :
		      // Connection Error.
		      echo $mysqli->connect_error;
		  else :
		      // Connection Success.

		      $mysqli->set_charset('utf8');

		      $sql = "
SELECT inventory.item_id,item_name,inventory.item_price,image_url,COUNT(*)
From transaction_item
JOIN inventory
ON inventory.item_id=transaction_item.item_id
Group by inventory.item_id
ORDER BY COUNT(*) DESC;";




		     //  $sql .= ";";



		       $results = $mysqli->query($sql);

		       if (!$results) :
		                          // SQL Error.
		      echo $mysqli->error;
		       else :
				  $count=0;
				  while ($count < 8):
					  $count=$count+1;
					  if ( $row = $results->fetch_assoc()):
?>
<div class ="col-12 col-md-6 col-lg-3">
	<div class ="item">
		<a href="ItemInfo.php?id=<?php echo $row['item_id']; ?>">
	<img src="<?php echo $row['image_url']; ?>" alt="category_2" class="img-fluid mb-2">
	</a>
	</div>

	<a href="ItemInfo.php?id=<?php echo $row['item_id']; ?>">
		<p class="text-center mb-1"> <?php echo $row['item_name']; ?></p>
	</a>

	<p class="text-center m-1"> $<?php echo $row['item_price']; ?></p>


</div>





<?php

					  endif;
				  endwhile;
		    endif; /* ELSE Results Received */
		  $mysqli->close();
		  endif; /* ELSE Connection Success */


		  ?>


	  </div>

    </div>






</body>
</html>
