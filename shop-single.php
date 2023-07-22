<?php
session_start();
require('admins/functions.php');

// Periksa apakah pengguna telah login
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
  // Mendapatkan username dari session
  $email = $_SESSION["email"];
  $password = $_SESSION["password"];

  // Gunakan nilai email sesuai kebutuhan
  $user = query("SELECT * FROM `customer` WHERE `email`='$email'");

  
} 
$id = $_GET["id"];

if (isset($_POST["cart"])) {
  if (cartplus($_POST) > 0) {
    header("Location: shop-single.php?id=$id&success=true");
    exit();  
  } else {
      echo mysqli_error($conn);
  }
 
}


$product = query("SELECT * FROM `product` WHERE `id`=$id");
$clr = query("SELECT * FROM `color`");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">


  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>

<body>
<div id="custom-alert" class="alert alert-success fade show" style="display: none;" role="alert">
  <strong>Yeay</strong> Produk berhasil ditambahkan ke keranjang!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<script>
  // Fungsi untuk menampilkan alert
  function showAlert() {
    const alertElement = document.getElementById("custom-alert");
    alertElement.style.display = "block";

    // Sembunyikan alert setelah 3 detik
    setTimeout(function() {
      alertElement.style.display = "none";
    }, 3000);
  }

  // Cek apakah alert perlu ditampilkan berdasarkan parameter URL 'success'
  const urlParams = new URLSearchParams(window.location.search);
  const successParam = urlParams.get('success');

  if (successParam && successParam === "true") {
    showAlert();
  }
</script>



  <div class="site-wrap">
  <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
            <form action="shop.php" class="site-block-top-search" method="post" class="filterForm">
                
                <span class="icon icon-search2"></span>

                <input type="text" name="search"class="form-control border-0" placeholder="Search">
              </form>
            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <div class="site-logo">
                <a href="index.php" class="js-logo-clone">Shoppers</a>
              </div>
            </div>

            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
              <div class="site-top-icons">
                <ul>
                <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true){
                    echo "<li class='dropdown'>
                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                        <span class='icon icon-person'></span>
                    </a>
                    <ul class='dropdown-menu'>
                        <li class='dropdown-item'><a href='profile.php'> Edit Profile</a></li>
                        <li class='dropdown-item'><a href='transaksi.php'> Transaksi</a></li>
                        <li class='dropdown-item'><a href='riwayat.php'> Riwayat Transaksi</a></li>
                        <li class='dropdown-item'><a href='logoutuser.php'> Logout</a></li>
                        <!-- Tambahkan item dropdown lainnya sesuai kebutuhan -->
                    </ul>
                </li>";
                  }else {
                    echo "<li><a href='login-form-06'><span class='icon icon-person'></span></a></li>";
                  } ?>
                  <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
                  <li>
                    <a href="cart.php" class="site-cart">
                      <span class="icon icon-shopping_cart"></span>
                      <span class="count">2</span>
                    </a>
                  </li>
                  <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span
                        class="icon-menu"></span></a></li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li class="active"><a href="shop.php">Shop</a></li>
            <li><a href="catalog.php">Catalogue</a></li>
            <li><a href="newarrival.php">New Arrivals</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <?php foreach ($product as $prd): ?>
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong
              class="text-black"><?= $prd["name"]; ?></strong></div>
        </div>
      </div>
    </div>

      <div class="site-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <img src="images/<?= $prd["gambar"]; ?>" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6">
              <?= $prd["about"]; ?>
              <p><strong class="text-primary h4">
                  <?php
                  $priceFromDatabase = $prd["price"];
                  $formattedPrice = "Rp " . number_format($priceFromDatabase, 0, ',', '.');
                  echo $formattedPrice;
                  ?>
                </strong></p>
              <form action="" method="post">
              <?php
              // Ambil nilai ukuran dari kolom 'size' pada tabel produk
              $sizeValues = $prd["size"];

              // Pecah nilai ukuran menjadi array
              $sizeArray = explode(',', $sizeValues);
              ?>
              <div class="mb-1 d-flex">
                <?php foreach ($sizeArray as $size): ?>
                  <label for="<?= $size; ?>" class="d-flex mr-3 mb-3">
                    <span class="d-inline-block mr-2" style="top:2px; position: relative;"><input type="radio"
                        id="<?= $size; ?>" name="size" value="<?= $size; ?>" required></span> <span class="d-inline-block text-black">
                      <?= $size; ?>
                    </span>
                  </label>
                <?php endforeach; ?>
              </div>
              <?php
              // Ambil nilai ukuran dari kolom 'size' pada tabel produk
              $colorValues = $prd["color"];

              // Pecah nilai ukuran menjadi array
              $colorArray = explode(',', $colorValues);
              ?>
              <div class="mb-1 d-flex">
                <?php foreach ($colorArray as $color): ?>
                  <?php foreach ($clr as $clrColor): ?>
                    <?php if ($color === $clrColor["color"]): ?>
                      <label for="<?= $color; ?>" class="d-flex mr-3 mb-3">
                        <span class="d-inline-block mr-2" style="top:2px; position: relative;">
                          <input type="radio" id="<?= $color; ?>" name="color" value="<?= $color; ?>" required>
                        </span>
                        <a class="d-flex color-item align-items-center">
                          <span class="color d-inline-block rounded-circle mr-2"
                            style="background-color: <?= $clrColor["codeclr"]; ?>"></span>
                          <span class="d-inline-block text-black">
                            <?= $color; ?>
                          </span>
                        </a>
                      </label>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endforeach; ?>
              </div>

              <div class="mb-5">
                <div class="input-group mb-3" style="max-width: 120px;">
                  <div class="input-group-prepend">
                    <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                  </div>
                  <input type="text" name="jumlah" class="form-control text-center" value="1" placeholder=""
                    aria-label="Example text with button addon" aria-describedby="button-addon1">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                  </div>
                </div>

              </div>
              <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true):?>
              <?php foreach ($user as $us): ?>
              <input type="hidden" name="id_customer" id="" value="<?= $us["id"]; ?>">
              <?php endforeach; ?>
              <?php endif;?>
              <input type="hidden" name="product_id" id="" value="<?= $prd["id"]; ?>">
              <input type="hidden" name="price" id="" value="<?= $prd["price"]; ?>">
              <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true):?>
              <p><button type="submit" class="buy-now btn btn-sm btn-primary" name="cart">Add To Cart</button></p>
              <?php else: ?>
                <p><button type="submit" class="buy-now btn btn-sm btn-primary" onclick="window.location='login-form-06'">Add To Cart</button></p>
                <?php endif; ?>
              </form>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Featured Products</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Tank Top</a></h3>
                    <p class="mb-0">Finding perfect t-shirt</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/shoe_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Corater</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_2.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Polo Shirt</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_3.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">T-Shirt Mockup</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/shoe_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Corater</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="site-footer border-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="row">
              <div class="col-md-12">
                <h3 class="footer-heading mb-4">Navigations</h3>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Sell online</a></li>
                  <li><a href="#">Features</a></li>
                  <li><a href="#">Shopping cart</a></li>
                  <li><a href="#">Store builder</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Mobile commerce</a></li>
                  <li><a href="#">Dropshipping</a></li>
                  <li><a href="#">Website development</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Point of sale</a></li>
                  <li><a href="#">Hardware</a></li>
                  <li><a href="#">Software</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <h3 class="footer-heading mb-4">Promo</h3>
            <a href="#" class="block-6">
              <img src="images/hero_1.jpg" alt="Image placeholder" class="img-fluid rounded mb-4">
              <h3 class="font-weight-light  mb-0">Finding Your Perfect Shoes</h3>
              <p>Promo from nuary 15 &mdash; 25, 2019</p>
            </a>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Contact Info</h3>
              <ul class="list-unstyled">
                <li class="address">203 Fake St. Mountain View, San Francisco, California, USA</li>
                <li class="phone"><a href="tel://23923929210">+2 392 3929 210</a></li>
                <li class="email">emailaddress@domain.com</li>
              </ul>
            </div>

            <div class="block-7">
              <form action="#" method="post">
                <label for="email_subscribe" class="footer-heading">Subscribe</label>
                <div class="form-group">
                  <input type="text" class="form-control py-4" id="email_subscribe" placeholder="Email">
                  <input type="submit" class="btn btn-sm btn-primary" value="Send">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;
              <script data-cfasync="false"
                src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
              <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made
              with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank"
                class="text-primary">Colorlib</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>

        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

</body>

</html>