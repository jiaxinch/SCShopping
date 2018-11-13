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

    </style>
</head>
<body>

	<?php include 'navigation.php'; ?>


    <?php

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ( $mysqli->connect_errno ) :
        // Connection Error.
        echo $mysqli->connect_error;
    else :
        // Connection Success.

        $mysqli->set_charset('utf8');

        $sql = "SELECT * FROM inventory
                        WHERE 1=1";



                $sql .= " AND  item_id = " . $_GET['id'];
                $_SESSION['item_id']=$_GET['id'];

         $sql .= ";";



         $results = $mysqli->query($sql);

         if (!$results) :
                            // SQL Error.
        echo $mysqli->error;
         else :




 while ( $row = $results->fetch_assoc() ) :







    ?>

    <div class ="container">
        <div class="row col-12">
            <h2 class="col-12 mt-4 text-center">Edit an item</h2>
        </div>

        <div class="container col-8 col-md-6 col-lg-6">

            <form action="edit_confirmation.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto">
                        <p id="form-error"></p>
                    </div>
                </div> <!-- .row -->

                <div class="form-group">
                    <label for="itemName-id">Item Name</label>
                    <input type="text" class="form-control" id="itemName-id" name="ItemName" value="<?php echo $row['item_name']; ?>">
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label for="description-id">Item description</label>
                    <input type="text" class="form-control" id="description-id" name="ItemDescription" value="<?php echo $row['description']; ?>">
                </div> <!-- .form-group -->
                <div class="form-group">
                    <label for="img-id">Image URL</label>
                    <input type="text" class="form-control" id="img-id" name="imageURL" value="<?php echo $row['image_url']; ?>">
                </div> <!-- .form-group -->

                <label>Category:</label>
                <select name="category" id="category-id" class="form-control">
                  <option value="" selected disabled>-- Select One --</option>
                  <option value="1" <?php if($row['category_id']==1){echo "selected";}?>>Food</option>
                  <option value="2" <?php if($row['category_id']==2){echo "selected";}?>>Drink</option>
                  <option value="3" <?php if($row['category_id']==3){echo "selected";}?>>Home</option>
                  <option value="4" <?php if($row['category_id']==4){echo "selected";}?>>Book</option>
                </select>

                <div class="form-group">
                    <label for="count-id">Item Number</label>
                    <input type="number" class="form-control" id="count-id" name="ItemNum" value="<?php echo $row['item_num']; ?>">
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label for="price-id">Item Price</label>
                    <input type="number" class="form-control" id="price-id" name="ItemPrice" value="<?php echo $row['item_price']; ?>">
                </div> <!-- .form-group -->


                <div class="form-group row mt-4">
                    <button type="submit" class="btn btn-primary col-5 button">Submit</button>
                    <div class="col-2"></div>
                    <a href="index.php" role="button" class="btn btn-light col-5 button">Cancel</a>
                </div> <!-- .form-group -->
            </form>
        </div>
    </div>
<?php
endwhile;
endif; /* ELSE Results Received */
$mysqli->close();
endif; /* ELSE Connection Success */

?>

</body>
<script>
document.querySelector('form').onsubmit = function(){
  if ( document.querySelector('#itemName-id').value.trim().length == 0
    || document.querySelector('#price-id').value.trim().length == 0
    || document.querySelector('#description-id').value.trim().length == 0
    || document.querySelector('#img-id').value.trim().length == 0
      || document.querySelector('#category-id').selectedIndex == 0
      ||document.querySelector('#count-id').value.trim().length==0
  ) {
    document.querySelector('#form-error').innerHTML = 'Please fill out all required fields.';
    return false;
  }
}
</script>
</html>
