<?php
	include "navbar.php";
	include "dbconn.php";
	$user_id = $_SESSION['user_id'];
	$order_id = $_GET['order_id'];

	$query = "SELECT * FROM orders WHERE order_id LIKE '$order_id'";

	$result = mysqli_query($conn,$query);

	$result = mysqli_fetch_assoc($result);

	$total = $result['amount'];
?>

<div class="container">
	<div class="row mt-5">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<h4>Select Payment Options</h4>
				</div>
				<form class="form" action="complete_order.php" method="POST">
				<div class="col-md-12 mt-5">
					<div class="card">
						<div class="card-body">
							<input type="radio" class="mr-3" value="Credit Card" name="x">Credit Card
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<input type="radio" class="mr-3" value="Debit Card" name="x">Debit Card
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<input type="radio" class="mr-3" value="UPI" name="x">UPI
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<input type="radio" class="mr-3" value="NEFT" name="x">NEFT
						</div>
					</div>
				</div>

				<div class="col-md-12 mt-4">
					<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
					<input type="submit" class="btn btn-lg btn-primary pull-right" value="Pay Now">
				</div>

				</form>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<h4>Order details</h4>
					<h5>Total Amount</h5>
					<h3>Rs <span><?php echo $total; ?></span></h3>
				</div>
			</div>
		</div>
	</div>
</div>