<?php
	require 'config.php';
	
	if(isset($_POST['updateTotalPrice'])) {
		$pid = $_POST['pid'];
		$productPrice = $_POST['productPrice'];
		$newQTY = $_POST['newQty'];
		$newTotalPrice = $productPrice * $newQTY;

		$stmt = $conn->prepare("UPDATE `cart` SET `qty` = ?, `total_price` = ? WHERE `id` = ?");
		$stmt->bind_param('idi', $newQTY, $newTotalPrice, $pid);
		$stmt->execute();

		return;
	}

	if(isset($_POST['action']) && $_POST['action'] == "addItemToList") {
		$pcode = $_POST['code'];
		
		$stmt = $conn->prepare("SELECT * FROM `product` WHERE `product_code` = ? LIMIT 1");
		$stmt->bind_param('s', $pcode);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$pid = $row['id'];
		$pname = $row['product_name'];
		$description = $row['description'];
		$pprice = $row['product_price'];
		$pimage = $row['product_image'];
		$pqty = 1;

		$stmt = $conn->prepare("SELECT `product_code` FROM `cart` WHERE `product_code` = ?");
		$stmt->bind_param('s',$pcode);
		$stmt->execute();
		$res = $stmt->get_result();
		$r = $res->fetch_assoc();
		$code = $r['product_code'] ?? '';

		if (!$code) {
			$query = $conn->prepare("INSERT INTO cart (`product_name`, `product_price`, `description`, `product_image`, `qty`, `total_price`, `product_code`) VALUES (?,?,?,?,?,?,?)");
			$query->bind_param('sdssids',$pname,$pprice,$description,$pimage,$pqty,$pprice,$pcode);
			$query->execute();

			echo '<div class="alert alert-success alert-dismissible mt-2">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Item added to your paper!</strong>
							</div>';
		} else {
			echo '<div class="alert alert-danger alert-dismissible mt-2">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Item already added to your paper!</strong>
							</div>';
		}
	}

	// Add products into the cart table
	if (isset($_POST['pid'])) {
	  $pid = $_POST['pid'];
	  $pname = $_POST['pname'];
	  $pprice = $_POST['pprice'];
	  $description = $_POST['description'];
	  $pimage = $_POST['pimage'];
	  $pcode = $_POST['pcode'];
	  $pqty = $_POST['pqty'];
	  $total_price = $pprice * $pqty;

	  $stmt = $conn->prepare('SELECT product_code FROM cart WHERE product_code=?');
	  $stmt->bind_param('s',$pcode);
	  $stmt->execute();
	  $res = $stmt->get_result();
	  $r = $res->fetch_assoc();
	  $code = $r['product_code'] ?? '';

	  if (!$code) {
	    $query = $conn->prepare('INSERT INTO cart (product_name,product_price,description,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?,?)');
	    $query->bind_param('sssssss',$pname,$pprice,$description,$pimage,$pqty,$total_price,$pcode);
	    $query->execute();

	    echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item added to your paper!</strong>
						</div>';
	  } else {
	    echo '<div class="alert alert-danger alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item already added to your paper!</strong>
						</div>';
	  }
	}

	// number ng items sa paper
	if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	  $stmt = $conn->prepare('SELECT * FROM cart');
	  $stmt->execute();
	  $stmt->store_result();
	  $rows = $stmt->num_rows;

	  echo $rows;
	}

	// isa isa remove lang
	if (isset($_GET['remove'])) {
	  $id = $_GET['remove'];

	  $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
	  $stmt->bind_param('i',$id);
	  $stmt->execute();

	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'Item removed from the cart!';
	  header('location:cart.php');
	}

	// pang remove lahat ng laman nung paper
	if (isset($_GET['clear'])) {
	  $stmt = $conn->prepare('DELETE FROM cart');
	  $stmt->execute();
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:cart.php');
	}

	// Set total price of the product in the cart table
	if (isset($_POST['qty'])) {
	  $qty = $_POST['qty'];
	  $pid = $_POST['pid'];
	  $pprice = $_POST['pprice'];

	  $tprice = $qty * $pprice;

	  $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
	  $stmt->bind_param('isi',$qty,$tprice,$pid);
	  $stmt->execute();
	}

	// Checkout and save customer info in the orders table
	if (isset($_POST['action']) && $_POST['action'] == 'order') {
	  $name = $_POST['name'];
	  $email = $_POST['email'];
	  $phone = $_POST['phone'];
	  $products = $_POST['products'];
	  $grand_total = $_POST['grand_total'];
	  $address = $_POST['address'];
	  $pmode = $_POST['pmode'];

	  $data = '';

	  $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)');
	  $stmt->bind_param('sssssss',$name,$email,$phone,$address,$pmode,$products,$grand_total);
	  $stmt->execute();
	  $stmt2 = $conn->prepare('DELETE FROM cart');
	  $stmt2->execute();
	  $data .= '<div class="text-center">
								<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
								<h2 class="text-success">Your Order Placed Successfully!</h2>
								<h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
								<h4>Your Name : ' . $name . '</h4>
								<h4>Your E-mail : ' . $email . '</h4>
								<h4>Your Phone : ' . $phone . '</h4>
								<h4>Total Amount Paid : ' . number_format($grand_total,2) . '</h4>
								<h4>Payment Mode : ' . $pmode . '</h4>
						  </div>';
	  echo $data;
	}
?>