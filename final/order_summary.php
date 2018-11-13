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
        <div class="container col-12 col-md-10 col-lg-7 ">
            <div class="row">
              <div class="col-12 ">
							  <div class="m-2">
							     <!-- <a href="addItem.php" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Add to Cart</a> -->
							     	 <div class="col-12 mt-4">
							         <h2 class="text-center">Order Summary<h2>
							       </div>



							<?php

							// 1. Establish DB Connection.
							$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

							if ( $mysqli->connect_errno ) :
							    // Connection Error.
							    echo $mysqli->connect_error;
							else :
							    // Connection Success.

							    $mysqli->set_charset('utf8');

							    $sql = "SELECT * FROM transaction
                                  WHERE 1=1";


							    // if ( isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ) {
							    //         $sql .= " AND  buyer_id = " . $_SESSION['user_id'];
							    // }
                   $sql .= " AND  transaction_id = " . $_GET['id'];

							     $sql .= ";";

							                     //echo $sql . "<hr>";

							     $results = $mysqli->query($sql);

							     if (!$results) :
							                        // SQL Error.
							    echo $mysqli->error;
							     else :
  while ( $row = $results->fetch_assoc()):

							?>


              <div class="col-12 ">
                <div class="m-2 mt-4">
                   <p>Shipping Address: <?php echo $row['address']; ?><p>
                 </div>
             </div>
             <div class="col-12 ">
               <div class="m-2">
                  <p>Time: <?php echo $row['time']; ?><p>
                </div>
            </div>


            <table class="table table-hover table-responsive m-4">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Item Name</th>
                  <th>Price</th>
                </tr>
              </thead>
             <tbody>


          <?php  endwhile;
          $sql = "SELECT item_name,transaction_item.item_price,image_url FROM transaction_item
                          JOIN inventory
                          ON inventory.item_id=transaction_item.item_id
                          WHERE 1=1";
                          $sql .= " AND  transaction_id = " . $_GET['id'];

                          $sql .= ";";
                          $results = $mysqli->query($sql);

                          if (!$results) :
                                             // SQL Error.
                         echo $mysqli->error;
                          else :

                            $total=0;
                          while ( $row = $results->fetch_assoc()):
                            $total=$total+$row['item_price'];

          ?>
          <tr>
              <td><img src=<?php echo $row['image_url']; ?> alt="" class="img-fluid col-10 col-md-8 col-lg-5"></td>
            <td><?php echo $row['item_name']; ?></td>

            <td>$<?php echo $row['item_price']; ?></td>
          </tr>
          <?php  endwhile;

          if($total!=0):
            ?>

              <tr>
                <td><h2>Order Total:</h2></td>
                <td></td>
                <td><h4>$<?php echo $total; ?></h4></td>
               </tr>
              <?php
          endif;
          ?>
         </tbody>
         </table>



							   </div>
							</div>




							<?php
endif; /* ELSE Results Received */
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
