<?php
	session_start();
  require 'config/config.php';
  if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
	  header('Location:login.php?message=login to view the cart');
  }


  if (!isset( $_POST['name'] ) || empty ( $_POST['name'] )
  	|| !isset( $_POST['card-num'] ) || empty ( $_POST['card-num'] )
  	|| !isset( $_POST['exp-month'] ) || empty ( $_POST['exp-month'] )
  	|| !isset( $_POST['exp-year'] ) || empty ( $_POST['exp-year'] )
  	|| !isset( $_POST['cvc'] ) || empty ( $_POST['cvc'] )
  ) {
  	header('Location: index.php');
  }

  define('STRIPE_SECRET_KEY', '	sk_test_GA2pP9oyM5dVyECVBgAqegk2');
  define('STRIPE_TOKEN_ENDPOINT', 'https://api.stripe.com/v1/tokens');
  define('STRIPE_CHARGE_ENDPOINT', 'https://api.stripe.com/v1/charges');

  $header = ['Authorization: Bearer ' . STRIPE_SECRET_KEY];

  $token_data = [
  	'card' => [
  		'name' => $_POST['name'],
  		'number' => $_POST['card-num'],
  		'exp_month' => $_POST['exp-month'],
  		'exp_year' => $_POST['exp-year'],
  		'cvc' => $_POST['cvc'],
  	]
  ];

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, STRIPE_TOKEN_ENDPOINT);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_data));

  $token_response = curl_exec($ch);
  $token_response = json_decode($token_response, true);

  // var_dump($token_response);

  if ( !isset($token_response['error']) ) {
  	// TOKEN Generated

  	$charge_data = [
  		'amount' => ($_SESSION['total'] * 100),
  		'currency' => 'usd',
  		'source' => $token_response['id'],
  	];

  	curl_setopt($ch, CURLOPT_URL, STRIPE_CHARGE_ENDPOINT);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  	curl_setopt($ch, CURLOPT_POST, true);
  	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($charge_data));

  	$charge_response = curl_exec($ch);
  	$charge_response = json_decode($charge_response, true);
  	// echo "<hr>";
  	// var_dump($charge_response);


    // else

    // }


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
        <div class="container col-7 ">

							     <!-- <a href="addItem.php" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Add to Cart</a> -->
							     	 <div class="col-12 mt-4">
							         <h2 class="text-center">Order confirmatiom</h2>
							       </div>

                     <?php

                     if ( isset( $token_response['error'] ) && !empty( $token_response['error'] ) ) :
                     	echo "<div class='text-danger'>" . $token_response['error']['message'] . "</div>";
                     elseif ( isset( $charge_response['error'] ) && !empty( $charge_response['error'] ) ) :
                     	echo "<div class='text-danger'>" . $charge_response['error']['message'] . "</div>";
                    else:
                      //do sth to the database
                      //add transaction
                      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        							if ( $mysqli->connect_errno ) :
        							    // Connection Error.
        							    echo $mysqli->connect_error;
        							else :
        							    // Connection Success.

        							    $mysqli->set_charset('utf8');



                      if ( isset($_POST['address']) && !empty($_POST['address']) ) {
                        $address = "'" . $_POST['address'] . "'";
                      }

                      $sql = "INSERT INTO transaction (buyer_id,total_price,address)
                              VALUES ("
                              . $_SESSION['user_id']
                              . ", "
                              .  $_SESSION['total']
                              . ", "
                              . $address
                              . ");";
                       $results = $mysqli->query($sql);

                       if (!$results) {
                          echo $mysqli->error;
                       }
                       else{
                          $last_id = $mysqli->insert_id;

                          $sql = "SELECT item_name,item_price,image_url,inventory.item_id FROM cart
                                          JOIN inventory
                                          ON inventory.item_id=cart.item_id
                                          WHERE 1=1";


        							    if ( isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ) {
        							            $sql .= " AND  user_id = " . $_SESSION['user_id'];
        							    }
                          $sql .= ";";
                          $results = $mysqli->query($sql);
                          if (!$results) {
                             echo $mysqli->error;
                          }
                          else{
                            while ( $row = $results->fetch_assoc()){
                              $sql = "INSERT INTO transaction_item (item_id,item_num,transaction_id,item_price)
                                      VALUES ("
                                      . $row['item_id']
                                      . ", "
                                      .  "1"
                                      . ", "
                                      . $last_id
                                      . ", "
                                      . $row['item_price']
                                      . ");";
                                      $results1 = $mysqli->query($sql);

                                      if (!$results1) {
                                         echo $mysqli->error;
                                      }


                            }
                            $sql = "DELETE FROM cart
                                    WHERE user_id=".$_SESSION['user_id'].";";
                                    $results1 = $mysqli->query($sql);

                                    if (!$results1) {
                                       echo $mysqli->error;
                                    }

                          }






                       }








                      echo "<div class='text-success'>Order was placed successfully. Confirmation Number: " . $charge_response['id'] . "</div>";



                       endif;
                       endif;
               ?>




        </div>

        </div>
    </div>







</body>

<script>



</script>

</html>
