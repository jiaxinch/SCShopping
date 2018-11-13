<?php
	session_start();
    $page_url = $_SERVER['REQUEST_URI'];
    // echo $page_url;

    // Remove '&page=...' from the URL.
    $page_url = preg_replace('/&page=\d+/', '', $page_url);
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
        <div class="container col-8 ">
			<?php if ( isset($_GET['category']) && !empty($_GET['category']) ) {
				if($_GET['category']==1){
					$_result="Food";
				}
				else if ($_GET['category']==2){
					$_result="Drink";
				}
				else if ($_GET['category']==3){
					$_result="Home";
				}
				else if($_GET['category']==4){
					$_result="Book";
				}
			}
			if ( isset($_GET['search']) && !empty($_GET['search']) ) {
					$_result=$_GET['search'];
			}

			?>
			<h2 class="text-center">Result for "<?php echo $_result?>"</h2>
<?php
			if( isset($_GET['message']) && !empty($_GET['message'])):
				?>
				<h6 class="text-center"><?php echo $_GET['message']?></h6>

<?php
endif;

?>
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

            		$sql_num_rows = "SELECT COUNT(*) AS count
            						FROM inventory
            						WHERE 1=1";


            		// if ( isset($_GET['track_name']) && !empty($_GET['track_name']) ) {
            		// 	$sql_num_rows .= " AND tracks.name LIKE '%" . $_GET['track_name'] . "%'";
            		// }

            		if ( isset($_GET['category']) && !empty($_GET['category']) ) {
            			$sql_num_rows .= " AND category_id = " . $_GET['category'];
            		}
					if ( isset($_GET['search']) && !empty($_GET['search']) ) {
							$sql_num_rows .= " AND item_name LIKE '%" . $_GET['search'] . "%'";
					}


						$sql_num_rows .= " AND valid = 1";

            		$sql_num_rows .= ";";

            		$results_num_rows = $mysqli->query($sql_num_rows);

            		/* Check for results error here. */
                    if (!$results_num_rows) :
            			// SQL Error.
            			echo $mysqli->error;
            		else :

            		$row_num_rows = $results_num_rows->fetch_assoc();

            		$num_results = $row_num_rows['count'];

            		$results_per_page = 6;

                    if($num_results==0){
                        $last_page=1;
                    }
                    else{
                        $last_page = ceil($num_results / $results_per_page);
                    }


            		if ( isset($_GET['page']) && !empty($_GET['page']) ) {
            			$current_page = $_GET['page'];
            		} else {
            			$current_page = 1;
            		}

            		if ($current_page < 1) {
            			$current_page = 1;
            		} elseif ($current_page > $last_page) {
            			$current_page = $last_page;
            		}

            		$start_index = ($current_page - 1) * $results_per_page;

            		// 2. Generate & Submit SQL Query.
            		$sql = "SELECT * FROM inventory
            						WHERE 1=1";


            		// if ( isset($_GET['track_name']) && !empty($_GET['track_name']) ) {
            		// 	$sql .= " AND tracks.name LIKE '%" . $_GET['track_name'] . "%'";
            		// }

                    if ( isset($_GET['category']) && !empty($_GET['category']) ) {
                        $sql .= " AND  category_id = " . $_GET['category'];
                    }
					if ( isset($_GET['search']) && !empty($_GET['search']) ) {
							$sql .= " AND item_name LIKE '%" . $_GET['search'] . "%'";
					}
					$sql .= " AND valid = 1";

            		$sql .= " LIMIT " . $start_index . ", " . $results_per_page;

            		$sql .= ";";

            		 //echo $sql . "<hr>";

            		$results = $mysqli->query($sql);

            		if (!$results) :
            			// SQL Error.
            			echo $mysqli->error;
            		else :
            			// Results Received.

                        while ( $row = $results->fetch_assoc() ) :

            	?>

                <div class ="col-12 col-md-6 col-lg-4 mt-4">
					<div class ="item">
    					<a href="ItemInfo.php?id=<?php echo $row['item_id']; ?>">
                    <img src="<?php echo $row['image_url']; ?>" alt="category_2" class="img-fluid mb-2">
    				</a>
					</div>

					<a href="ItemInfo.php?id=<?php echo $row['item_id']; ?>">
						<p class="text-center mb-1"> <?php echo $row['item_name']; ?></p>
					</a>

                    <p class="text-center m-1"> $<?php echo $row['item_price']; ?></p>
                    <a href="addCart.php?id=<?php echo $row['item_id']; ?>" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Add to Cart</a>
					<?php if ( isset($_SESSION['admin']) && $_SESSION['admin'] == true ) : ?>

						<a href="delete_item.php?id=<?php echo $row['item_id']; ?>" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Delete</a>
						<a href="edit_item.php?id=<?php echo $row['item_id']; ?>" class="btn btn-primary btn-sm btn-block mt-4 mt-md-2" role="button">Edit</a>

						<?php
					endif;
						?>
                </div>

                <?php
                    endwhile;
                ?>


                <div class="col-12 mt-4">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page_url . '&page=1'; ?>">First</a>
                            </li>
                            <li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page_url . '&page=' . ($current_page-1); ?>">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href=""><?php echo $current_page; ?></a>
                            </li>
                            <li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page_url . '&page=' . ($current_page+1); ?>">Next</a>
                            </li>
                            <li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page_url . '&page=' . $last_page; ?>">Last</a>
                            </li>
                        </ul>
                    </nav>
                </div> <!-- .col -->

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
</html>
