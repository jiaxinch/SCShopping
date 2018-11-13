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
        <div class="container  col-12 col-md-10 col-lg-7 ">
            <div class="row">
              <div class="col-12 ">
							  <div class="m-2">
							     <!-- <a href="addItem.php" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Add to Cart</a> -->
							     	 <div class="col-12 mt-4">
							         <h2 class="text-center">Place Order</h2>
							       </div>


                     <form action="order_confirm.php" method="POST">
					<div class="row mb-3">
		                     <div class="font-italic text-danger col-sm-9 ml-sm-auto">
		                         <p id="form-error"></p>
		                     </div>
		                 </div> <!-- .row -->
                     <div class="col-12 mt-4">
                       <h4 class=" ">Billing and Shiping info</h4>
                       <hr>
                     </div>

                     <div class="col-12 mt-4">
                       <label>Shipping Address:</label>
                       <textarea name="address" class="form-control" id="address-id"></textarea>
                     </div>
                     <div class="col-12 mt-4">
                       <label>Name on Card:</label>
                       <input type="text" class="form-control" id="name-id" name="name">
                     </div>

                     <div class="col-12 mt-4">
                       <label>Card Number:</label>
                       <input type="number" class="form-control" id="num-id" name="card-num">
                     </div>

                     <div class="form-group col-12 mt-4">
               				<label>Exp-Month</label>

               					<select name="exp-month" id="exp-month-id" class="form-control" required>
               						<option value="" selected disabled>- Select One -</option>
               						<option value="01">01</option>
               						<option value="02">02</option>
               						<option value="04">04</option>
               						<option value="05">05</option>
               						<option value="06">06</option>
               						<option value="07">07</option>
               						<option value="08">08</option>
               						<option value="09">09</option>
               						<option value="10">10</option>
               						<option value="11">11</option>
               						<option value="12">12</option>
               					</select>

               			</div> <!-- .form-group -->

               			<div class="form-group col-12 mt-4">
               				<label for="exp-year-id" class=" col-form-label ">Exp Year:</label>

               					<select name="exp-year" id="exp-year-id" class="form-control" required>
               						<option value="" selected disabled>- Select One -</option>
               						<option value="2017">2017</option>
               						<option value="2018">2018</option>
               						<option value="2019">2019</option>
               						<option value="2020">2020</option>
               						<option value="2021">2021</option>
               					</select>

               			</div> <!-- .form-group -->

                    <div class="col-12 mt-4">
                      <label>CVC:</label>
                      <input type="number" class="form-control" id="cvc-id" name="cvc">
                    </div>



                     <div class="col-12 mt-4">
                       <h4 class=" ">Order Summary</h4>
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

							    $sql = "SELECT item_name,item_price,image_url FROM cart
                                  JOIN inventory
                                  ON inventory.item_id=cart.item_id
                                  WHERE 1=1";


							    if ( isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ) {
							            $sql .= " AND  user_id = " . $_SESSION['user_id'];
							    }


							     $sql .= ";";

							                     //echo $sql . "<hr>";

							     $results = $mysqli->query($sql);

							     if (!$results) :
							                        // SQL Error.
							    echo $mysqli->error;
							     else :


							?>



										 <?php
										 if ( isset($_GET['message']) && !empty($_GET['message']) ) :

										 ?>
										 <div class="col-12 mt-4">
										 	<h5 class="text-center"><?php echo $_GET['message']; ?><h5>
										 </div>
										 <?php
									 endif;

										 ?>

                     <table class="table table-hover table-responsive m-4">
                       <thead>
                         <tr>
                           <th>Image</th>
                           <th>Item Name</th>
                           <th>Price</th>
                         </tr>
                       </thead>
                      <tbody>

                        <?php
                        $total=0;
                        while ( $row = $results->fetch_assoc()):
                          $total=$total+$row['item_price'];
                        ?>
                        <tr>
                            <td><img src=<?php echo $row['image_url']; ?> alt="" class="img-fluid col-10 col-md-8 col-lg-8"></td>
                          <td><?php echo $row['item_name']; ?></td>

                          <td>$<?php echo $row['item_price']; ?></td>
                        </tr>
                        <?php  endwhile;
                        $_SESSION['total']=$total;
                        if($total!=0):
                          ?>

                            <tr>
                              <td><h5>Order Total:</h5></td>
                              <td></td>
                              <td><h5>$<?php echo $total;?></h5></td>
                             </tr>
                            <?php
                        endif;
                        ?>
                       </tbody>
                       </table>
                         <?php if($total!=0):
                           ?>
<!-- <botton href="addItem.php" class="btn btn-primary btn-sm btn-block ml-4" role="button">Place Order</a> -->
<button type="submit" class="btn btn-primary btn-sm btn-block ml-4" id="submit-buttom">Place Order</button>
                         <?php

                       endif;
                       ?>

							   </div>
							</div>

</form>


							<?php

							endif; /* ELSE Results Received */
							$mysqli->close();
							endif; /* ELSE Connection Success */

							?>



        </div>

        </div>
    </div>






</body>
<script>

document.querySelector('#submit-buttom').onclick = function(){
  if ( document.querySelector('#address-id').value.trim().length == 0
	|| document.querySelector('#name-id').value.trim().length == 0
	|| document.querySelector('#num-id').value.trim().length == 0
	|| document.querySelector('#cvc-id').value.trim().length == 0
  ) {
	document.querySelector('#form-error').innerHTML = 'Please fill out all required fields.';
	return false;
  }
}

</script>



</html>
