<?php
  include("database.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <style>
    button {
      padding: 15px 30px;
      background-color: #4CAF50;
      border: none;
      border-radius: 5px;
      color: #FFFFFF;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    button:hover {
      background-color: #45a049;
      transform: scale(1.05);
    }

    button:active {
      transform: scale(0.95);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    a {
      color: #FFFFFF;
      /* Text color */
      text-decoration: none;
      /* Remove underline */
      display: inline-block;
      /* Make the anchor tag behave like a block element */
      width: 100%;
      /* Full width for the anchor to fill the button */
      height: 100%;
      /* Full height for the anchor to fill the button */
      text-align: center;
      /* Center the text */
      line-height: 15px;
      /* Vertically center the text */
    }

    .center {
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="center">
    <button><a href="customer_list.php">Customer List</a></button>
    <button><a href="order_list.php">Order List</a></button>
    <button><a href="product_list.php">Product List</a></button>
    <button><a href="order_details.php">Order Details List</a></button>
    <button><a href="place_order.php">Place Order</a></button>

    <button><a href="view_orders.php">Order</a></button>
  </div>


</body>

</html>