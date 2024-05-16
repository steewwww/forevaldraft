<?php
session_start();
require('function.php');
require('config.php');
require('navbar.php');
$user_data = check_login($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="">
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

        th, td {
            border: 1px solid #000; /* Set border color to black */
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* Set background color for header cells */
        }

        .product-description {
            max-width: 550px; /* Limit maximum width for description */
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.5; /* Adjust line height for readability */
        }
        .addItemBtn {
            background-color: #006400; /* Dark green color */
            color: #fff;
            border: 1px solid #006400; /* Match the border color to the background color */
            padding: 10px 15px; /* Adjust padding to make the button more visually appealing */
            font-size: 14px; /* Font size */
            font-weight: bold; /* Make the text bold */
            cursor: pointer;
            border-radius: 5px; /* Add rounded corners */
            transition: background-color 0.3s, transform 0.3s; /* Add smooth transition for the background color and a slight transform */
        }

        .addItemBtn:hover {
            background-color: #008000; /* Slightly lighter green on hover */
            color: #fff; /* Text color on hover */
            transform: scale(1.05); /* Slightly enlarge the button on hover */
        }

        .addItemBtn:active {
            background-color: #004d00; /* Even darker green when the button is active (clicked) */
            transform: scale(1); /* Reset the scale on active */
        }

    #categoryFilter {
            background-color: green;
            color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
        }

        #categoryFilter option {
            background-color: white;
            color: black;
        }

        #categoryFilter option[selected] {
            background-color: green;
            color: white;
        }
    </style>
</head>    

<body>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-5 col-md-8" id="order">
                <div class="card ms-5">
                    <div class="card-body">
                        <header>
                            <h1 class="text-center">Product List</h1>
                            <div id="message"></div>
                             <!-- Get the selected category value from the URL parameter -->
                            <?php
                            $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

                            // Escape the category value to prevent SQL injection
                            $escapedCategory = mysqli_real_escape_string($conn, $selectedCategory);
                            ?>

                            <!-- Category filter dropdown -->
                            <label for="categoryFilter">Filter by Category:</label>
                            <select id="categoryFilter" name="categoryFilter">
                                <option value="all" <?php echo ($selectedCategory === 'all') ? 'selected' : ''; ?>>All Categories</option>
                                <?php
                                // Fetch and populate the categories dynamically from your database
                                $categoryQuery = "SELECT DISTINCT category FROM product";
                                $categoryResult = mysqli_query($conn, $categoryQuery);

                                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                                    $category = $categoryRow['category'];
                                    echo "<option value=\"$category\" " . (($selectedCategory === $category) ? 'selected' : '') . ">$category</option>";
                                }
                                ?>
                            </select>

                        </header>

                        <!-- Form starts here -->
                        <form action="" class="form-submit">
                            <!-- Table starts here -->
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th style="width: 70px;" >Unit</th>
                                        <th>Price</th>
                                        <th>Add</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Get the selected category value from the URL parameter
                                    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

                                    $query = "SELECT * FROM product";

                                    if ($selectedCategory !== 'all') {
                                        // Escape the category value to prevent SQL injection
                                        $escapedCategory = mysqli_real_escape_string($conn, $selectedCategory);
                                        $query .= " WHERE category = '$escapedCategory'";
                                    }

                                    $result = mysqli_query($conn, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $description_with_breaks = nl2br($row['description']);
                                        echo "<tr>";
                                        echo "<td class='product-description'>{$description_with_breaks}</td>";
                                        echo "<td>{$row['product_name']}</td>";
                                        echo "<td>₱" . number_format($row['product_price'], 2) . "</td>";
                                        echo "<td>";
                                        echo "<input type='hidden' class='pqty' value='1' min='1'>";
                                        echo "<button class='too addItemBtn' data-action='addItemToList' data-id='{$row['product_code']}'><i class='uil uil-plus' data-action='addItemToList' data-id='{$row['product_code']}'></i>&nbsp;&nbsp;</button>";
                                        echo "</td>";                                        
                                        echo "<input type='hidden' class='pid' value='{$row['id']}'>";
                                        echo "<input type='hidden' class='pname' value='{$row['product_name']}'>";
                                        echo "<input type='hidden' class='pprice' value='{$row['product_price']}'>";
                                        echo "<input type='hidden' class='description' value='{$row['description']}'>";
                                        echo "<input type='hidden' class='pimage' value='{$row['product_image']}'>";
                                        echo "<input type='hidden' class='pcode' value='{$row['product_code']}'>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    
                                </tbody>
                            </table> <!-- Table ends here -->
                        </form> <!-- Form ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
                                
    <script type="text/javascript">
        document.addEventListener('click', function(e) {
            e = e || window.event;
            var target = e.target || e.srcElement;

            if(target.dataset.action == "addItemToList") {
                e.preventDefault();
                
                $.ajax({
                    url: 'action.php',
                    method: 'POST',
                    data: {
                        action: "addItemToList",
                        code: target.dataset.id
                    },
                    success: function (response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                        load_cart_item_number();
                    }
                });
                return;
            }
        });
    $(document).ready(function () {
        // Send product details to the server
        $(".addItemBtn").click(function (e) {
            e.preventDefault();
            var $form = $(this).closest("tr");
            var pid = $form.find(".pid").val();
            var pname = $form.find(".pname").val();
            var pprice = $form.find(".pprice").val();
            var description = $form.find(".description").val();
            var pimage = $form.find(".pimage").val();
            var pcode = $form.find(".pcode").val();
            var pqty = $form.find(".pqty").val();

            // $.ajax({
            //     url: 'action.php',
            //     method: 'post',
            //     data: {
            //         pid: pid,
            //         pname: pname,
            //         pprice: pprice,
            //         description: description,
            //         pqty: pqty,
            //         pimage: pimage,
            //         pcode: pcode
            //     },
            //     success: function (response) {
            //         $("#message").html(response);
            //         window.scrollTo(0, 0);
            //         load_cart_item_number();
            //     }
            // });
        });
    });

    // Load total number of items added to the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: {
                cartItem: "cart_item"
            },
            success: function (response) {
                $("#cart-item").html(response);
            }
        });
    }
</script>

<script>
    // Add an event listener to the category filter dropdown
    document.getElementById('categoryFilter').addEventListener('change', function () {
        // Get the selected category value
        var selectedCategory = this.value;

        // Update the page with the selected category
        window.location.href = 'index.php?category=' + selectedCategory;
    });
</script>

