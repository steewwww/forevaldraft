<?php
session_start();
include('function.php');
include('config.php');
include('adminnav.php');

$user_data = check_login($conn);
$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap scripts -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include jQuery -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

   
    
    <!-- Include DataTables CSS and JS files -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

    <style>
        .container {
            width: 100%;
            padding-left: 15px;
            padding-right: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .mt-5 {
            margin-top: 5rem;
        }

        .card {
            margin-bottom: 20px;
            border: 0;
            border-radius: .375rem;
            box-shadow: 0 0 40px rgba(0, 0, 0, .1);
            width: 100%; /* Set the card width to 100% */
        }

        .card-body {
            padding: 1.5rem;
        }

        .text-center {
            text-align: center !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000; /* Set border color to black */
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* Set background color for header cells */
        }

        .product-description {
            max-width: 300px; /* Limit maximum width for description */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .addItemBtn {
            background-color: #006400; /* Dark green color */
            color: #fff;
            border: 1px solid #006400; /* Match the border color to the background color */
            padding: 6px 8px; /* Adjust padding to make the button smaller */
            font-size: 14px; /* Adjust font size to make the text smaller */
            cursor: pointer;
            transition: background-color 0.3s; /* Add smooth transition for the background color change */
        }

        .addItemBtn:hover {
            background-color: #008000; /* Slightly lighter green on hover */
            color: #fff; /* Change text color on hover if needed */
        }
    </style>
</head>

<body >
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 px-20" id="order"> <!-- Adjusted the width to col-lg-12 -->
                <div class="card">
                    <div class="card-body">
                        <header>
                            <h1 class="text-center">All Product List</h1>
                        </header>

                        <!-- Add new product button -->
                        <div>
                            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add new</button>
                        </div>

                        <!-- Table starts here -->
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Item Number</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Description</th>
                                    <th>Unit Cost</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['product_code']; ?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td><?php echo $row['product_qty']; ?></td>
                                        <td><?php echo $row['product_name']; ?></td>
                                        <td><?php echo nl2br($row['description']); ?></td>
                                        <td><?php echo $row['product_price']; ?></td>
                                        <td>
                                            <button class="btn btn-success editbtn" data-toggle="modal" data-target="#updateModal" data-id="<?php echo $row['id']; ?>">Update</button>
                                            <button class="btn btn-dark deletebtn" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id']; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                        </table> <!-- Table ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Add Modal -->
   <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add your form fields for adding a new user here -->
                    <form action="addproduct.php" method="POST">
                        
                    <div class="form-group">
                            <label>Product Item Number</label>
                            <input type="product_code" class="form-control" name="product_code" required>
                        </div>
                    <div class="form-group">
                            <label>Description</label>
                            <textarea type="description"class="form-control" name="description" required rows="5"></textarea>
                            
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="product_name" required>
                            <option selected>Select unit</option>
                            <option value="pcs">pcs/pc</option>
                            <option value="unit">unit</option>
                            <option value="liters">liters</option>
                            <option value="sets">sets</option>
                            <option value="gal">gallon</option>
                            <option value="roll">roll</option>
                            <option value="btls">btls</option>
                            <option value="months">months</option>
                            <option value="cart">cart</option>
                            <option value="box">box</option>
                            <option value="bundle">bundle</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Product Price</label>
                            <input type="product_Price" class="form-control" name="product_price" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select type="category" class="form-control" name="category" required>
                            <option selected>Select Category</option>
                            <option value="food">food</option>
                            <option value="electronics">electronics</option>
                            <option value="materials">materials</option>
                            <option value="equipments">equipments</option>
                            <option value="others">others</option>
                            </select>
                        </div>
                        <!-- Add more fields as needed -->
                        <button type="submit" class="btn btn-primary" name="insertdata">Save Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete user </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="deleteproduct.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_id">

                        <h4> Do you want to Delete this user?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                        <button type="submit" name="delete_product" class="btn btn-danger">Confirm</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Edit Users Account </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="updateproduct.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">


                    <div class="form-group">
                        <label>Product Item Number</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" id="description" required rows="5"></textarea>
                    </div>
                    <div class="form-group">
                    <label>Category</label>
                            <select class="form-control" name="product_name" required>
                            <option selected>Select unit</option>
                            <option value="pcs">pcs/pc</option>
                            <option value="unit">unit</option>
                            <option value="liters">liters</option>
                            <option value="sets">sets</option>
                            <option value="gal">gallon</option>
                            <option value="roll">roll</option>
                            <option value="btls">btls</option>
                            <option value="months">months</option>
                            <option value="cart">cart</option>
                            <option value="box">box</option>
                            <option value="bundle">bundle</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Price</label>
                        <input type="text" class="form-control" name="product_price" id="product_price" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category" id="category" required>
                            <option selected>Select Category</option>
                            <option value="food">food</option>
                            <option value="electronics">electronics</option>
                            <option value="materials">materials</option>
                            <option value="equipments">equipments</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_product" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


    
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable();

        // Save the current page before form submission
        $('form').on('submit', function() {
            var currentPage = table.page();
            localStorage.setItem('currentPage', currentPage);
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable();

        // Restore the saved page after reload
        var savedPage = localStorage.getItem('currentPage');
        if (savedPage !== null) {
            table.page(parseInt(savedPage)).draw(false);
        }

        // Use event delegation to handle dynamically added delete buttons
        $('#example').on('click', '.deletebtn', function () {
            $('#deleteModal').modal('show');

            var deleteId = $(this).data('id');
            $('#delete_id').val(deleteId);
        });

        $('#example').on('click', '.editbtn', function () {
            $('#updateModal').modal('show');

            var updateId = $(this).data('id');
            $('#update_id').val(updateId);

            // Retrieve the data and populate the modal fields
            var productName = $(this).closest('tr').find('td:eq(3)').text();
            var description = $(this).closest('tr').find('td:eq(4)').text();
            var productPrice = $(this).closest('tr').find('td:eq(5)').text();
            var productQty = $(this).closest('tr').find('td:eq(2)').text();
            var productCode = $(this).closest('tr').find('td:eq(0)').text();
            var category = $(this).closest('tr').find('td:eq(1)').text(); 

            $('#product_name').val(productName);
            $('#description').val(description);
            $('#product_price').val(productPrice);
            $('#product_qty').val(productQty);
            $('#product_code').val(productCode);
            $('#category').val(category); 
        });
    });
</script>



</body>

</html>