<?php
  session_start();
  include ('navbar.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cart</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="CSS/cart.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-5 col-md-8" id="order">
            <div class="card ms-5">
                <div class="card-body">
                      <div style="display:<?php if (isset($_SESSION['showAlert'])) {
                              echo $_SESSION['showAlert'];
                            } else {
                              echo 'none';
                            } unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <strong><?php if (isset($_SESSION['message'])) {
                              echo $_SESSION['message'];
                            } unset($_SESSION['showAlert']); ?></strong>
                      </div>
                      <div class="table-responsive mt-2">
                        <table class="table table-bordered table-striped text-center">
                          <thead>
                            <tr>
                              <td colspan="7">
                                <h4 class="text-center m-0">Products in your paper!</h4>
                              </td>
                            </tr>
                            <tr>
                                <th style="width: 150px;">ID</th>
                                <th style="width: 150px;">PRODUCT</th>
                                <th style="width: 150px;">UNIT</th>
                                <th style="width: 180px;">Price</th>
                                <th style="width: 200px;">Quantity</th>
                                <th style="width: 150px;">Total Price</th>
                                <th>
                                  <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Paper</a>
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                require 'config.php';
                                $stmt = $conn->prepare('SELECT * FROM cart');
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $grand_total = 0;
                                while ($row = $result->fetch_assoc()):
                              ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                            <td style="width: 300px; word-wrap: break-word;"><?= nl2br($row['description']) ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td>₱
                                <i class=""></i>&nbsp;&nbsp;<?= number_format($row['product_price'], 2); ?>
                            </td>
                            <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                            <td>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="qty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="qty" class="form-control input-number itemQty" value="<?= $row['qty'] ?>" min="1" max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="qty">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                          <td class="totalPrice">₱<?= number_format($row['total_price'], 2); ?></td>
                            <td>
                              <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                          </tr>
                  <?php $grand_total += $row['total_price']; ?>
                  <?php endwhile; ?>
                  <tr>
                    <td colspan="2">
                      
                    </td>
                    <td colspan="3"><b>Grand Total</b></td>
                    <td id="grandTotal"><b><i class="">₱</i>&nbsp;&nbsp;<?= number_format($grand_total, 2); ?></b></td>
                    <td>
                      <a href="print.php" class="btn btn-success <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="fas fa-print"></i>&nbsp;&nbsp;Edit Quotation</a>
                    </td>
                  </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>
  </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function () {
    // Function to calculate and update the grand total
    function updateGrandTotal() {
      var grandTotal = 0;

      // Loop through each row in the table and sum up the total prices
      $(".totalPrice").each(function () {
        grandTotal += parseFloat($(this).text().replace(/[^\d.-]/g, ''));
      });

      // Format the grand total with the desired locale and options
      var formattedGrandTotal = grandTotal.toLocaleString('en-US', {
        style: 'currency',
        currency: 'PHP' // You can change the currency code as needed
      });

      // Update the grand total in the HTML
      $("#grandTotal").text(formattedGrandTotal);
    }

    // Change the item quantity
    $(".btn-number").click(function (e) {
      e.preventDefault();

      var fieldName = $(this).attr("data-field");
      var type = $(this).attr("data-type");
      var $row = $(this).closest("tr");
      var inputQty = $row.find("input[name='" + fieldName + "']");
      var totalPriceElement = $row.find(".totalPrice");

      var currentQty = parseInt(inputQty.val());
      var productPrice = parseFloat($row.find(".pprice").val());

      if (!isNaN(currentQty)) {
        if (type == "minus" && currentQty > 1) {
          inputQty.val(currentQty - 1).change();
        } else if (type == "plus") {
          inputQty.val(currentQty + 1).change();
        }

        // Calculate new total price
        var newQty = parseInt(inputQty.val());
        var newTotalPrice = newQty * productPrice;

        // Format the number with the desired locale and options
        var formattedTotalPrice = newTotalPrice.toLocaleString('en-US', {
          style: 'currency',
          currency: 'PHP' // You can change the currency code as needed
        });

        totalPriceElement.text(formattedTotalPrice);

        // Send the updated total price to the server
        updateTotalPriceInDatabase($row, newQty, productPrice);
        
        // Call the function to update the grand total
        updateGrandTotal();
      } else {
        inputQty.val(1);
      }

      // Trigger the change event to update the server
      inputQty.trigger("change");
    });

    // ... (rest of your code)

    // Function to send the updated total price to the server
    function updateTotalPriceInDatabase($row, newQty, productPrice) {
      var pid = $row.find(".pid").val();
      var pprice = $row.find(".pprice").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          updateTotalPrice: true,
          pid: pid,
          newQty: newQty,
          productPrice: productPrice
        },
        success: function (response) {
          console.log(response);
        }
      });
    }

    // Call the function to initialize the grand total on page load
    updateGrandTotal();
  });
</script>

</body>

</html>