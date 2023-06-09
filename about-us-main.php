<?php
include 'config.php';

session_start();
$user_id = $_SESSION['user_id'];
   
if(isset($_GET['logout'])){
   unset($user_id);
   header('location:index.php');
};

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
    <title>About Us - Bake Me Happy</title>
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
            <li><a class="nav-link" href="main.php">Home</a></li>
            <li><a class="nav-link" href="menu-main.php">Menu</a></li>
            <li><a class="nav-link active" href="about-us-main.php">About Us</a></li>
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
    <?php
         if(isset($message)){
           foreach($message as $message){
               echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
           }
         } 
         ?>




    <!-- ======= Hero Section ======= -->
    <section>
      <div class="container-fluid page-header py-6 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center pt-5 pb-3">
          <h1 class="display-4 text-white animated slideInDown mb-3"></h1>
          <nav aria-label="breadcrumb animated slideInDown">
          </nav>
        </div>
      </div>
    </section>
    <!-- ======= End Hero Section ======= -->

    <div>
      <img src="assets/img/element-yellow.png" class="yellow-element">
    </div>

    <main id="main">
      <!-- ======= About Us Section ======= -->
      <section id="team" class="">
        <!-- About Start -->
        <div class="container-xxl py-6">
          <div class="container" data-aos="fade-up">
            <div class="row g-5">
              <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="row img-twice position-relative h-100">
                  <div class="col-6">
                    <img class="img-fluid rounded" src="assets\img\about\cake-1.jpg" alt="">
                  </div>
                  <div class="col-6 align-self-end">
                    <img class="img-fluid rounded" src="assets\img\about\cake-2.jpg" alt="">
                  </div>
                </div>
              </div>
              <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
                  <h1 class="display-6 mb-4">We Bake Every Item From The Core Of Our Hearts</h1>
                  <p>Welcome to Bake Me Happy, where convenience meets exquisite flavors. Whether you're surprising a loved one, treating yourself, or commemorating life's sweetest moments, the team invites you to embark on a journey of pure indulgence.</p>
                  <p>Prepare to encounter the magic of cakes like never before as you step into the world of Bake Me Happy, where delightful treats await you.</p>
                  <div class="row g-2 mb-4">
                    <div class="col-sm-6">
                      <i class="fa fa-check me-2" style="color: #ed502e;"></i>Quality Products
                    </div>
                    <div class="col-sm-6">
                      <i class="fa fa-check me-2" style="color: #ed502e;"></i>Custom Products
                    </div>
                    <div class="col-sm-6">
                      <i class="fa fa-check me-2" style="color: #ed502e;"></i>Online Order
                    </div>
                    <div class="col-sm-6">
                      <i class="fa fa-check me-2" style="color: #ed502e;"></i>Home Delivery
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- About End -->


      </section>
      <!-- End About Section -->

      <!-- ======= Team Section ======= -->

      <section id="team">
            <!-- Team Start -->
    <div class="container-xxl py-6">
        <div class="container" data-aos="fade-up">
          <div class="section-title">            
              <h2>Team</h2>
              <p>Meet Bake Me Happy's proud developer team</p>
          </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="assets\img\team\avien.png" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Avien Flaire Batul</h5>
                                <span>Back-End Developer</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.facebook.com/avieflaire.batul"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.instagram.com/avien_flaire"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://github.com/aviennn"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="assets\img\team\niel.png" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Joshua Niel Sanguyo</h5>
                                <span>Front-End Developer</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.facebook.com/joshuaniel.sanguyo"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.instagram.com/nielapag"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://github.com/nylon_n"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="assets\img\team\tine.png" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Kristine Angeli Basilio</h5>
                                <span>Front-End Developer</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.linkedin.com/in/kristineangelibasilio/"><i class="fab fa-linkedin"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.instagram.com/tineabsl"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://github.com/tinebasilio"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <img class="img-fluid" src="assets\img\team\paul.png" alt="">
                        <div class="team-text">
                            <div class="team-title">
                                <h5>Paul Trustan Yumang</h5>
                                <span>Back-End Developer</span>
                            </div>
                            <div class="team-social">
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.facebook.com/paultrustan.yumang"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://www.instagram.com/paulymng7"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-light rounded-circle" href="https://github.com/paulyumang"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->  
    </section>

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

    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/24cdc05b8b.js" crossorigin="anonymous"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
  </body>

</html>
