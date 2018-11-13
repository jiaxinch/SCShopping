
<div class ="container-fluid header">
    <p class="text-center"> SC Buy</p>
</div>


<nav class="container-fluid bg-dark p-2">
	<div class="row navigation">
        <div class="col-4">
            <a class="" href="index.php">
                <img src="img/home2.png" alt="home page" class="img-fluid home">
            </a>
            <a class="" href="cart.php">
                <img src="img/shopcart3.png" alt="shop cart" class="img-fluid shop">
            </a>
        </div>
        <div class="col-3">
            	<!-- <input type="text" class="form-control" id="search-id" name="search">
                <a href="",role="button" class="btn btn-primary" id="cart">Go</a> -->
                <form action="ItemPage.php" method="GET">
  <div class="row">
    <div class="">
      <div class="input-group">
   <input type="text" class="form-control" placeholder="Search" id="txtSearch" name="search"/>
   <div class="input-group-btn">
        <button class="btn btn-primary" type="submit">
        Go
        </button>
   </div>
   </div>
    </div>
  </div>
</form>

        </div>
		<div class="col-5 d-flex">

		<?php if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) : ?>

			<a class="text-center p-2 ml-auto" href="login.php">Login</a>

		<?php else : ?>

			<div class="text-center text-light p-2 ml-auto"><a href="order_history.php?id=<?php echo $_SESSION['user_id']; ?>"><?php echo $_SESSION['username']; ?><a/> </div>

		<?php endif; ?>

			<a class="text-center p-2" href="logout.php">Logout</a>

		</div>
	</div> <!-- .row -->
</nav>
