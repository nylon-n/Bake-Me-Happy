<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $select_cart = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE product_name = ? AND user_id = ?");
    mysqli_stmt_bind_param($select_cart, 'si', $product_name, $user_id);
    mysqli_stmt_execute($select_cart);
    $result = mysqli_stmt_get_result($select_cart);

    if (mysqli_num_rows($result) > 0) {
        $message[] = 'Product already added to cart!';
    } else {
        $insert_cart = mysqli_prepare($conn, "INSERT INTO `cart` (user_id, product_name, price, image, quantity) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insert_cart, 'isdsi', $user_id, $product_name, $product_price, $product_image, $product_quantity);
        mysqli_stmt_execute($insert_cart);
        $message[] = 'Product added to cart!';
    }
}

if (isset($_POST['update_cart'])) {
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    $update_cart = mysqli_prepare($conn, "UPDATE `cart` SET quantity = ? WHERE id = ?");
    mysqli_stmt_bind_param($update_cart, 'ii', $update_quantity, $update_id);
    mysqli_stmt_execute($update_cart);
    $message[] = 'Cart quantity updated successfully!';
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $delete_cart = mysqli_prepare($conn, "DELETE FROM `cart` WHERE id = ?");
    mysqli_stmt_bind_param($delete_cart, 'i', $remove_id);
    mysqli_stmt_execute($delete_cart);
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    $delete_all_cart = mysqli_prepare($conn, "DELETE FROM `cart` WHERE user_id = ?");
    mysqli_stmt_bind_param($delete_all_cart, 'i', $user_id);
    mysqli_stmt_execute($delete_all_cart);
    header('location:cart.php');
}

// Count the number of items in the cart
$count_query = mysqli_prepare($conn, "SELECT COUNT(*) FROM `cart` WHERE user_id = ?");
mysqli_stmt_bind_param($count_query, 'i', $user_id);
mysqli_stmt_execute($count_query);
$count_result = mysqli_stmt_get_result($count_query);
$count_row = mysqli_fetch_row($count_result);
$cart_count = $count_row[0];
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>My Cart - Bake Me Happy</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="assets\img\favicon.png" rel="icon">
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
    <!-- CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
  </head>

  <body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="main.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
            <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link" href="main.php">Home</a></li>
                <li><a class="nav-link" href="menu-main.php">Menu</a></li>
                <li><a class="nav-link" href="about-us-main.php">About Us</a></li>
                <?php
                                $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE id = '$user_id'") or die('query failed');
                                if(mysqli_num_rows($select_user) > 0)
                                {
                                $fetch_user = mysqli_fetch_assoc($select_user);
                                };
                                ?>
                <li class="dropdown">
                <a href="#"><span>Hello, <?php echo $fetch_user['username']; ?> </span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                    <li><a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to log out?');" class="delete-btn">Log out</a></li>
                </ul>
                </li>
                <li><a class="login scrollto" href="#" data-target="#">Shopping Cart</a></li>
                <span class="position-absolute top-0 start-100 translate-middle badge-pill bg-warning" style="font-size: 15px; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
              <?php echo $cart_count; ?>
              <span class="visually-hidden"></span>
            </span>            
          

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>

            </nav>
            <!-- .navbar -->
        </div>
    </header>
    <!-- End Header -->

    <main id="main">

        <!-- ======= Cart Section ======= -->
        <section id="team" class="team section-bg">
            <div class="container">
            <div class="py-5 text-center">
            </div>
            <div class="row">
                <div class="col-md-7 order-md-1">
                <!-- Cart container -->
                <div class="cart-container" style="border: 1px solid #ddd; padding: 20px; background-color: #FCF9F6;">
                    <!-- Your cart section -->
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span><b>My Cart</b></span>
                    <span><a href="cart.php?delete_all" onclick="return confirm('Delete all items from cart?');" style="font-size: 16px;" class="text-danger font-weight-bold text-decoration-underline <?php echo ($grand_total > 1)?'':'disabled'; ?>">Remove All</a></span>
                    </h4>

                    <div class="list-group-container">
                    <!-- Move this div outside the loop -->
                    <ul class="list-group mb-3">
                        <?php
                            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                            $grand_total = 0;
                            if(mysqli_num_rows($cart_query) > 0){
                                while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                                    $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                                    $grand_total += $sub_total;
                        ?>
                        <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                            <img class="img-fluid" width="60" height="60" src="assets\img\cakes\<?php echo $fetch_cart['image']; ?>" alt="">
                            </div>
                            <div class="col-md-4">
                            <h4 class="mb-0"><?php echo $fetch_cart['product_name']; ?></h4>
                            <h4 class="mb-0">₱ <?php echo $fetch_cart['price']; ?></h4>
                            </div>
                            <div class="col-md-3">
                            <div class="input-group">
                                <form action="" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <div class="row">
                                    <div class="col-8">
                                    <input type="number" class="form-control text-center border border-secondary" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                    </div>
                                    <div class="col-4">
                                    <div class="input-group-append">
                                        <input type="submit" name="update_cart" value="Update" class="btn btn-primary shadow-0">
                                    </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="main.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?');"><i class="fas fa-trash-alt"></i></a>
                            </div>
                            </div>
                        </div>
                        </li>

                    <?php
            }
        }else{
            echo '<h4 style="padding:20px; text-align:center;">No items added</h4>';
        }
        ?>
                    </ul>
                    </div>

                    <!-- Cart summary section -->
                    <div class="cart-summary" id="cart-summary">
                    <hr class="my-3">
                    <div class="row justify-content-between">
                        <h4 class="col-md-6 mb-1"><b>Total</b></h4>
                        <form action="purchse.php" method="POST" class="col-md-6 text-right">
                        <h5 class="mb-1"><b>₱ <?php echo $grand_total; ?></b></h5>
                        </form>
                    </div>
                    </div>
                    <!-- End Cart summary section -->
                </div>
                <!-- End Cart container -->
            </div>

            <!-- Form section -->
            <div class="col-md-5 order-md-2">
                <h4 class="mb-3"><b>Recipient data</b></h4>
                <form class="needs-validation" action="purchase.php" method="POST" onsubmit="return validateForm()" novalidate>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" name="first_name" id="firstName" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Last Name" required>
                    </div>
                    </div>
                    <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com">
                    </div>
                    <div class="mb-3">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control" name="phone_number" id="phone" placeholder="Phone Number">
                    </div>
                    <h4 class="mb-3"><b>Delivery address</b></h4>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                        <div class="invalid-feedback">
                        Please enter your shipping address.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="deliverydate">Date of Delivery</label>
                        <input type="date" class="form-control" id="deliverydate" name="date_of_delivery" value="" placeholder="mm-dd-yy" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="deliverytime">Time of Delivery</label>
                        <select class="form-control" id="deliverytime" name="time_of_delivery" required>
                        <option value="">Select a time</option>
                        <script>
                            var now = new Date();
                            var hours = now.getHours();
                            var minutes = now.getMinutes();
                            for (var i = hours + (minutes >= 45 ? 1 : 0); i <= 20; i++) {
                            var time = (i % 12 || 12) + ':' + (minutes < 15 ? '00' : minutes < 30 ? '15' : minutes < 45 ? '30' : '00') + ' ' + (i >= 12 ? 'PM' : 'AM');
                            if (i == 21) {
                                break;
                            }
                            document.write('<option value="' + time + '">' + time + '</option>');
                            }

                        </script>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Confirm Order</button>
                    </div>
                </form>
                </div>

                <script>
                function validateForm() {
                    var firstName = document.getElementById('firstName').value;
                    var lastName = document.getElementById('lastName').value;
                    var city = document.getElementById('city').value;
                    var address = document.getElementById('address').value;
                    var deliverydate = document.getElementById('deliverydate').value;
                    var deliverytime = document.getElementById('deliverytime').value;

                    if (firstName === '' || lastName === '' || city === '' || address === '' || deliverydate === '' || deliverytime === '') {
                    alert('Please fill out all required fields.');
                    return false;
                    }
                }
            </script>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer class="footer elem-tertiary relative">
        <div class="container-footer">
            <div class="grid justify-content-between align-items-center">
            <div class="tile-md-2 mb-4">
                <div class="text-center">
                <a href="main.php" class="img-lazy js-lazy img-responsive loaded"><img src="assets/img/logo-footer.png" alt="" class="img-fluid">
                </a>
                </div>
            </div>
            <div class="grid grid--2 justify-content-center footer-links-desktop">
                <div class="tile-auto text-center mb-3 mr-3">
                <a href="">
                    <span class="subtitle">Contact Us</span>
                </a>
                </div>
                <div class="tile-auto text-center mb-3 mr-3">
                <a href="">
                    <span class="subtitle">FAQs</span>
                </a>
                </div>
                <div class="tile-auto text-center mb-3 mr-3">
                <a href="">
                    <span class="subtitle">Terms & Conditions</span>
                </a>
                </div>
                <div class="tile-auto text-center mb-3 mr-3">
                <a href="">
                    <span class="subtitle">Privacy Policy</span>
                </a>
                </div>
            </div>
            <div class="grid justify-content-center footer-links-mobile">
                <div class="tile-auto text-center mb-3">
                <a href="">
                    <span class="subtitle">Contact Us</span>
                </a>
                </div>
                <div class="tile-auto text-center mb-3">
                <a href="">
                    <span class="subtitle">FAQs</span>
                </a>
                </div>
                <div class="tile-auto text-center mb-3">
                <a href="">
                    <span class="subtitle">Terms & Conditions</span>
                </a>
                </div>
                <div class="tile-auto text-center mb-3">
                <a href="">
                    <span class="subtitle">Privacy Policy</span>
                </a>
                </div>
            </div>
            <div class="grid justify-content-center">
                <div class="tile">
                <div class="text-center">
                    <small class="subtitle">© 2023 Bake Me Happy.</small>
                </div>
                </div>
            </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/24cdc05b8b.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
  </body>

</html>
