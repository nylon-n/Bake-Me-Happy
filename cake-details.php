<?php
include 'config.php';

session_start();
   
if(isset($_GET['id'])) {
   $id = $_GET['id'];
} else {
     // Handle the case when 'id' is not provided in the URL
     echo "<script>alert('Invalid cake ID');</script>";
     echo "<script>window.location.href = 'index.php';</script>";
     exit();
   }
   
   if(isset($_POST['submit'])) {
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   
     $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass'") or die('query failed');
   
     if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location: main.php');
        exit();
     } else {
       echo "<script>alert('Incorrect email or password. Please login again.');</script>";
       echo "<script>window.location.href = 'cake-details.php?id=$id';</script>";
       exit();
     }
   }
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
    <link href="assets/css/cake-details-style.css" rel="stylesheet">

  </head>

  <body>

    <!-- Empty Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <!-- add modal-lg class to the modal-dialog to make it large -->
        <div class="modal-content custom-modal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex justify-content-center mb-4">
              <!-- add d-flex and justify-content-center classes to center the image -->
              <img src="assets\img\cart-modal.png" alt="Empty Cart" class="img-fluid">
            </div>
            <div class="text-center">
              <h3>It looks like you haven't picked any cakes yet.</h3>
              <h5>Browse our menu and add your favorites to your cart.</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
      <div class="container d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
        <nav id="navbar" class="navbar">
          <ul>
            <li><a class="nav-link" href="index.php">Home</a></li>
            <li><a class="nav-link active" href="menu.php">Menu</a></li>
            <li><a class="nav-link" href="about-us.php">About Us</a></li>
            <li><a class="login scrollto" href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
            <li><a class="login scrollto" href="#" data-toggle="modal" data-target="#cartModal">Shopping Cart</a></li> 
            <span class="position-absolute top-0 start-100 translate-middle badge-pill bg-warning" style="font-size: 15px; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">0
              <span class="visually-hidden"></span>
            </span>            

          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
      </div>
    </header>
    <!-- End Header -->

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Welcome Back!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="username">Email</label>
                <input type="email" name="email" class="form-control" id="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
              </div>
              <div class="text-center">
                <button type="submit" name="submit" class="btn btn-primary custom-login-btn" value="login now">Login</button>
              </div>
              <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php">Register Here</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <main id="main">

      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
         <div class="container">
            <ol>
               <li><a href="menu.php"><span>&#8249;</span> Back to Menu</a></li>
            </ol>
         </div>
      </section>
      <!-- End Breadcrumbs -->

      <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $id") or die('query failed');
            if($select_product){
                $fetch_product = mysqli_fetch_assoc($select_product)
            
            ?>

      <!-- ======= Cake Details Section ======= -->
      <!-- content -->
      <section class="py-5">
        <div class="container">
          <div class="row gx-5">
            <aside class="col-lg-6">
              <div class="border rounded-4 mb-3 d-flex justify-content-center">
                <a data-fslightbox="mygalley" class="rounded-4" target="" data-type="" href="">
                  <form method="post" action="">
                    <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="assets/img/cakes/<?php echo $fetch_product['image']; ?>" alt="">
                </a>
              </div>
              <!-- thumbs-wrap.// -->
              <!-- gallery-wrap .end// -->
            </aside>
            <main class="col-lg-6">
              <div class="ps-lg-3">
                <h2 class="name" style="color: #DC531B;">
                  <?php echo $fetch_product['product_name']; ?>
                  <input type="hidden" name="product_name" value="<?php echo $fetch_product['product_name']; ?>">
                </h2>
                <div class="mb-3">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                  <span class="h5">₱ <?php echo $fetch_product['price']; ?></span>
                </div>
                <p class="product_description">
                  <?php echo $fetch_product['description']; ?>
                </p>
                </form>
                <?php
                     };
                     ?>
                <div class="row">
                  <dt class="col-3">Allergens:</dt>
                  <dd class="col-9"><?php echo $fetch_product['allergens']; ?></dd>
                  <dt class="col-3">Storage:</dt>
                  <dd class="col-9"><?php echo $fetch_product['storage']; ?></dd>
                </div>
                <hr />
                <div class="row mb-4">
                  <!-- col.// -->
                  <div class="col-md-4 col-6 mb-3">
                    <label class="mb-2">Quantity</label>
                    <div class="input-group mb-3" style="width: 170px;">
                      <input type="number" min="1" class="form-control text-center border border-secondary" placeholder="14" name="product_quantity" value="1">
                    </div>
                  </div>
                </div>
                <a href="#" class="btn btn-primary shadow-0" data-toggle="modal" data-target="#loginModal">Add to cart</a>

              </div>
            </main>
          </div>
        </div>
      </section>
      <!-- content -->
      <!-- End Cake Details Section -->
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

    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/24cdc05b8b.js" crossorigin="anonymous"></script>
  </body>

</html>
