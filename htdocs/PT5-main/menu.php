<?php
  include("database.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="style.css">
  <style>
    a:active {
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
    /* Basic Button Style */
a {
    background-color: #4CAF50; /* Green background */
    color: white;              /* White text */
    padding: 18px 25px;        /* Spacing inside button */
    border: none;              /* Remove default border */
    border-radius: 5px;        /* Rounded corners */
    font-size: 15px;           /* Font size */
    cursor: pointer;           /* Pointer cursor on hover */
    text-align: center;        /* Center text */
    text-decoration: none;     /* Remove underline if it’s a link */
    display: inline-block;     /* Allow setting width and height */
    transition: background-color 0.3s ease; /* Smooth hover transition */
    width: auto;
  }

/* Hover Effect */
a:hover {
    background-color: #45a049; /* Darker green on hover */
}

  </style>
</head>

<body>

  <div class="center">
    <a href="customer_list.php">Customer List</a>
    <a href="product_list.php">Product List</a>
    <a href="place_order.php">Place Order</a>
    <a href="view_orders.php">Order</a>
  </div>


</body>

</html>