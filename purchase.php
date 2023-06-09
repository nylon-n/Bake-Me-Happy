<?php
   
include 'config.php';

   session_start();
   $user_id = $_SESSION['user_id'];

   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   $email = $_POST['email'];
   $phone_number = $_POST['phone_number'];
   $city = $_POST['city'];
   $address = $_POST['address'];
   $date_of_delivery = $_POST['date_of_delivery'];
   $time_of_delivery = $_POST['time_of_delivery'];

   $select = mysqli_query($conn, "SELECT * FROM `order_manager` WHERE user_id = '$user_id' AND Order_id = (SELECT MAX(Order_id) FROM `order_manager` WHERE user_id = '$user_id');") or die('query failed');

   mysqli_query($conn, "INSERT INTO `order_manager`(user_id, first_name, last_name, email, phone_number, city, address, date_of_delivery, time_of_delivery) VALUES('$user_id', '$first_name', '$last_name', '$email', '$phone_number', '$city', '$address', '$date_of_delivery', '$time_of_delivery')") or die('query failed');
   $order_id = mysqli_insert_id($conn);
   $message[] = 'Success';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Order Details - Bake Me Happy</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Alice&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xxx" crossorigin="anonymous" />


    <!-- CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
      .custom-container {
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        border-radius: 10px;
        padding: 20px;
      }

    </style>
  </head>

  <body>

    <!-- Logo -->
    <div class="container text-center my-4">
      <img src="assets\img\logo-footer.png" alt="Logo" class="img-fluid">
    </div>

    <!-- Single Border Container -->
    <div class="container my-5 p-4 border rounded custom-container" style="background-color: #FCF9F6;">
      <div class="container">
        <div class="alert alert-success d-flex align-items-center" role="alert">
          <i class="fas fa-check-circle mr-2"></i>
          <div>
            Your order has been confirmed and is now being processed. We will notify you once it's out for delivery.
          </div>
        </div>

        <div class="row">
          <div class="col-md-8">
            <!-- Purchased Items Section -->
            <div class="d-flex justify-content-between align-items-center mb-3">

              <h2 class="mb-0">Purchased Items</h2>

            </div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Image</th>
                  <th scope="col">Item</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Subtotal</th>
                  <th scope="col"></th>
                </tr>
                <?php
            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $grand_total = 0;
            if(mysqli_num_rows($cart_query) > 0){
               while($fetch_cart = mysqli_fetch_assoc($cart_query)){
               ?>

              </thead>
              <tbody>
                <tr>
                  <td><img class="img-fluid" width="60" height="60" src="assets\img\cakes\<?php echo $fetch_cart['image']; ?>" alt=""></td>
                  <td><?php echo $fetch_cart['product_name']; ?></td>
                  <td><?php echo $fetch_cart['quantity']; ?></td>
                  <td><?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                </tr>
                <?php
                           $grand_total += $sub_total;
                           }
                           }else{
                              echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                           }
                           ?>
              </tbody>
            </table>
          </div>
          <!-- Order Details Section -->
          <div class="col-md-4">
            <div class="order-details mb-4">
              <h2>Order Details</h2>
              <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `order_manager` WHERE user_id = '$user_id' AND Order_id = (SELECT MAX(Order_id) FROM `order_manager` WHERE user_id = '$user_id');") or die('query failed');
         while ($fetch_order = mysqli_fetch_assoc($order_query)) {
               ?>
              <ul class="list-group">
                <li class="list-group-item"><strong>Order ID: </strong><?php echo $fetch_order['Order_id']; ?></li>
                <li class="list-group-item"><strong>Name: </strong><?php echo $fetch_order['first_name']; ?> <?php echo $fetch_order['last_name']; ?> </li>
                <li class="list-group-item"><strong>Email: </strong><?php echo $fetch_order['email']; ?></li>
                <li class="list-group-item"><strong>Phone Number: </strong><?php echo $fetch_order['phone_number']; ?></li>
                <li class="list-group-item"><strong>City: </strong><?php echo $fetch_order['city']; ?></li>
                <li class="list-group-item"><strong>Address: </strong><?php echo $fetch_order['address']; ?></li>
                <li class="list-group-item"><strong>Date of Delivery: </strong><?php echo $fetch_order['date_of_delivery']; ?></li>
                <li class="list-group-item"><strong>Time of Delivery: </strong><?php echo $fetch_order['time_of_delivery']; ?></li>
              </ul>
              <?php
         }
         ?>
            </div>
            <div class="total-amount">
              <!-- Total Amount Section in Two Columns -->
              <div class="row">
                <div class="col">
                  <h4>Total Amount:</h4>
                </div>
                <div class="col text-right">
                  <h3 class="font-weight-bold">₱ <?php echo $grand_total; ?></h3>
                </div>
              </div>
            </div>
            <a href="delete_cart_main.php" class="btn btn-primary btn-block back-to-home">Back to Home</a>
          </div>
        </div>
      </div>
      <!-- Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

      <!-- Font Awesome Kit -->
      <script src="https://kit.fontawesome.com/24cdc05b8b.js" crossorigin="anonymous"></script>

  </body>

</html>
