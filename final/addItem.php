<?php
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
            <h2 class="col-12 mt-4 text-center">Add an item</h2>
        </div>

        <div class="container col-8 col-md-6 col-lg-6">

            <form action="addConfirmation.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto">
                        <p id="form-error"></p>
                    </div>
                </div> <!-- .row -->

                <div class="form-group">
                    <label for="itemName-id">Item Name</label>
                    <input type="text" class="form-control" id="itemName-id" name="ItemName">
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label for="description-id">Item description</label>
                    <input type="text" class="form-control" id="description-id" name="ItemDescription">
                </div> <!-- .form-group -->
                <div class="form-group">
                    <label for="img-id">Image URL</label>
                    <input type="text" class="form-control" id="img-id" name="imageURL">
                </div> <!-- .form-group -->

                <label>Category:</label>
                <select name="category" id="category-id" class="form-control">
                  <option value="" selected disabled>-- Select One --</option>
                  <option value="1">Food</option>
                  <option value="2">Drink</option>
                  <option value="3">Home</option>
                  <option value="4">Book</option>
                </select>

                <div class="form-group">
                    <label for="count-id">Item Number</label>
                    <input type="number" class="form-control" id="count-id" name="ItemNum">
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label for="price-id">Item Price</label>
                    <input type="number" class="form-control" id="price-id" name="ItemPrice">
                </div> <!-- .form-group -->


                <div class="form-group row mt-4">
                    <button type="submit" class="btn btn-primary col-5 button">Submit</button>
                    <div class="col-2"></div>
                    <a href="index.php" role="button" class="btn btn-light col-5 button">Cancel</a>
                </div> <!-- .form-group -->
            </form>
        </div>
    </div>

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
</body>

</html>
