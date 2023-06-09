<?php

include 'config.php';

session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
};


if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   
   if(mysqli_num_rows($select_cart) > 0){
    echo "<script>alert('Product already added to cart!');</script>";
    echo "<script>window.location.href = 'main.php';</script>";
 }else{
    mysqli_query($conn, "INSERT INTO `cart`(user_id, product_name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
    echo "<script>alert('Product added to cart!');</script>";
    echo "<script>window.location.href = 'main.php';</script>";
 }
   
   };

   if(isset($_POST['update_cart'])){
      $update_quantity = $_POST['cart_quantity'];
      $update_id = $_POST['cart_id'];
      mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
      $message[] = 'cart quantity updated successfully!';
      }
      
      if(isset($_GET['remove'])){
      $remove_id = $_GET['remove'];
      mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
      header('location:cart.php');
      }
      
      if(isset($_GET['delete_all'])){
      mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
    <title>Bake Me Happy</title>
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
                <li><a class="nav-link active" href="#hero">Home</a></li>
                <li><a class="nav-link" href="menu-main.php">Menu</a></li>
                <li><a class="nav-link" href="about-us-main.php">About Us</a></li>

                <li class="dropdown">
                    <?php
                                    $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE id = '$user_id'") or die('query failed');
                                    if(mysqli_num_rows($select_user) > 0)
                                    {
                                    $fetch_user = mysqli_fetch_assoc($select_user);
                                    };
                                    ?>
                <a href="#"><span>Hello, <?php echo $fetch_user['username']; ?> </span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                    <li><a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to log out?');" class="delete-btn">Log out</a></li>
                </ul>
                </li>
                <li><a class="login scrollto" href="cart.php" data-target="#">Shopping Cart</a></li>
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

    <!-- ======= Hero Section ======= -->
    <section id="hero">
      <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active" style="background-image: url(assets/img/slide/main.png)">
            <div class="carousel-container">
              <div class="container">
                <h3 class="animate__animated animate__fadeInDown">Delighting Taste Buds, <br>One Slice at a Time</span></h3>
                <a href="menu-main.php" class="btn-order-here animate__animated animate__fadeInUp scrollto">Order Here</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section><!-- End Hero -->
    <div>
        <img src="assets/img/element-yellow.png" class="yellow-element">
    </div>

    <main id="main">
        <!-- ======= Best Sellers Section ======= -->
        <section id="team" class="team section-bg">
            <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Best Sellers</h2>
                <p>Choose from our most loved cakes</p>
            </div>
            <div class="row">
                <?php
                                $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id IN (3,7,8,11)") or die('query failed');
                                if (mysqli_num_rows($select_product) > 0) 
                                {
                                while ($fetch_product = mysqli_fetch_assoc($select_product)) 
                                {
                                ?>
                <div class="col-md-3 mb-4">
                <div class="card h-100">
                <form method="post" action="">
                            <!-- Product image -->
                        <img class="card-img-top" src="assets/img/cakes/<?php echo $fetch_product['image']; ?>" alt="">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <!-- Product details -->
                        <div class="card-body">
                        <h5 class="card-title fw-bolder text-center"><?php echo $fetch_product['product_name']; ?></h5>
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['product_name']; ?>">
                        <div class="card-details">
                            <h5>₱ <?php echo $fetch_product['price']; ?></h5>
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <input type="hidden" min="1" name="product_quantity" value="1">
                            <a href="cake-details-main.php?id=<?php echo $fetch_product['id']; ?>" style="font-size: small;">See cake details</a>
                        </div>
                        <div class="card-buttons">
                            <input type="submit" value="Add to cart" name="add_to_cart" class="btn btn-outline-dark mt-2">
                        </div>
                        </div>
                </form>
                </div>
                </div>
                <?php
                                }
                                }
                                ?>
            </div>
            <div class="text-center">
                <a href="menu-main.php" class="btn-order-here">View more cakes</a>
            </div>
            </div>
        </section>
        <!-- End Best Sellers Section -->
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

    <div id="preloader"></div>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    </script>
  </body>
</html>
