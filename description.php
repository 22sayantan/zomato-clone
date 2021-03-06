<?php
	include "navbar.php";
?>
<?php 
if ($logged_in == 1) {
	echo '<div class="container"><h3>hello,'."\t".$_SESSION['name'].'</h3></div>';
} else {
	echo '<div class="container"><h3>please login to get cart,wishlist,order placed</h3></div>';
}

?>

<?php 

$product_id = $_GET['product_id'];
// connect to db
include "dbconn.php";

// write a query
$query = "SELECT * FROM products WHERE product_id = $product_id";

$result = mysqli_query($conn,$query);
$result = mysqli_fetch_assoc($result);

$img = substr(explode(',', $result['bg_img'])[0], 1);

$query4 = "SELECT * FROM reviews WHERE product_id = $product_id";

$result4 = mysqli_query($conn,$query4);

$counter = 0;
$total = 0;
while($row4 = mysqli_fetch_assoc($result4)){
	$counter++;
	$total = $total + $row4['rating'];
}
if($counter == 0){
	$avg_rating = "No rating";
}else{
	$avg_rating = $total/$counter;
}



?>

<?php
$query1 = "SELECT * FROM wishlist WHERE product_id=$product_id";

$result1 = mysqli_query($conn,$query1);
$num_rows = mysqli_num_rows($result1);
?>

<?php
	
	$query2 = "SELECT * FROM cart WHERE product_id=$product_id";

	$result2 = mysqli_query($conn,$query2);
	$num_rows2 = mysqli_num_rows($result2);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#wishlist-btn').click(function(){
			var product_id = '<?php echo $product_id; ?>';
			$.ajax({
				url:'add_to_wishlist.php',
				method:'POST',
				data:{'product_id':product_id},
				success:function(data){

					if(data === 'Success'){
						$('#wishlist-btn').hide();
						$('#button-container').append('<button class="btn btn-success btn-sm">Wishlisted</button>')
					}

				},
				error:function(error){

				}
			})
		})

		$('#button-container').on('click','#unwishlist-btn',function(){
			alert("Click on ok to unwislisted");
			var product_id = '<?php echo $product_id; ?>';
			$.ajax({
				url:'delete_from_wishlist.php',
				method:'POST',
				data:{'product_id':product_id},
				success:function(data){

					if(data === 'Success'){
						$('#unwishlist-btn').hide();
						$('#button-container').append('<button class="btn btn-info btn-sm" id="wishlist-btn">Wishlist</button>')
					}

				},
				error:function(error){

				}
			})
		})

		$('#add-cart').click(function(){
			var product_id = '<?php echo $product_id; ?>';
			$.ajax({
				url:'add_to_cart.php',
				method:'POST',
				data:{'product_id':product_id},
				success:function(data){

					if(data === 'Success'){
						$('#add-cart').hide();
						$('#button-container').prepend('<button class="btn btn-primary btn-sm">Added to Cart</button>')
					}

				},
				error:function(error){

				}
			})
		})


	})
</script>
<div class="container mt-5">
	<div class="row">
		<div class="col-md-12">
			<h5><a href="index.php">Home</a> -> <a href="category.php?category=<?php echo $result['category']; ?>"><?php echo $result['category']; ?></a></h5>
		</div>

		<div class="row mt-5">
			<div class="col-md-5">
				<img src="<?php echo $img; ?>" width="175px" height="175px">
			</div>

			<div class="col-md-6">
				<h2><?php echo $result['name']; ?></h2>
				<p><?php echo $counter; ?> reviews | Avg Rating - <?php echo $avg_rating; ?> </p>
				<hr>
				<h5>Seller:<br> <?php echo $result['seller']; ?></h5>
				<h3>Rs <?php echo $result['price']; ?></h3>
				<div class="mt-3 mb-5" id="button-container">

					
					<?php
					if($num_rows2 == 0){
						echo '<button class="btn bg-success btn-sm text-white" id="add-cart">Add to Cart</button>';
					}else{
						echo '<button class="btn bg-primary btn-sm text-white" id="add-cart">Added to Cart</button>';
					}

					if($num_rows == 0){
						echo '<button class="btn btn-info btn-sm ml-2" id="wishlist-btn">Wishlist</button>';
					}else{
						echo '<button class="btn btn-success btn-sm ml-2" id="unwishlist-btn">Wishlisted</button>';
					}
					?>
					
				</div>

				<p>
					<?php echo $result['details']; ?>
				</p>
				
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md-7">
			<h2>Reviews</h2>
			<?php
				if($counter == 0){
					echo "No reviews available for this product.";
				}
				$query3 = "SELECT * FROM reviews r JOIN users u ON r.user_id=u.user_id WHERE r.product_id = $product_id";

				$result3 = mysqli_query($conn,$query3);

				while($row3 = mysqli_fetch_assoc($result3)){
					echo '<h5>'.$row3['review_title'].'</h5>
						<p>Rating - '.$row3['rating'].'<span style="float: right">Reviewed By - <b>'.$row3['name'].'</b></span></p>
						<p> '.$row3['review_text'].'</p>
						<p>Reviewed On- '.$row3['review_date'].'</p><hr>';
				}
			?>
			
			
		</div>
		<div class="col-md-5">
			<h3>Add Review</h3>
			<form class="mb-5" action="submit_review.php" method="POST">
				<label>Rate the Product(1 to 5)</label><br>
				<input type="number" name="rating" min="1" max="5" class="form-control"><br>
				<label>Review Title</label><br>
				<input type="text" name="title" class="form-control"><br>
				<label>Review Text</label><br>
				<textarea name="body" class="form-control"></textarea><br>
				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
				<input class="btn btn-info btn-sm" type="submit" name="" value="Submit">
			</form>
		</div>
	</div>
</div>