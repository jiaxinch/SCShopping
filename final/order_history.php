<?php
	session_start();

    require 'config/config.php';
    // echo "<br>";
    // echo $page_url;
	if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
		header('Location:login.php?message=login to view the cart');
	}
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
							         <h2 class="text-center">Order History<h2>
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


							    if ( isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ) {
							            $sql .= " AND  buyer_id = " . $_SESSION['user_id'];
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
                           <th>Order#</th>
                           <th>Price</th>
                           <th>Time</th>
                         </tr>
                       </thead>
                      <tbody>


                        <?php
                        $total=0;
                        while ( $row = $results->fetch_assoc()):

                        ?>
                        <tr>
                            <td><a href="order_summary.php?id=<?php echo $row['transaction_id']; ?>"><?php echo $row['transaction_id']; ?><a/></td>
                          <td>$<?php echo $row['total_price']; ?></td>

                          <td><?php echo $row['time']; ?></td>
                        </tr>
                        <?php  endwhile;


                        ?>
                       </tbody>
                       </table>


							   </div>
							</div>




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



</script>

</html>
