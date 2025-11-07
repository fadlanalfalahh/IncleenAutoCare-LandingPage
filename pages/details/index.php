<?php
include '../../config/koneksi.php';

// Ambil parameter slug dari URL
$slugParam = isset($_GET['slug']) ? $db->real_escape_string($_GET['slug']) : '';

if (empty($slugParam)) {
  http_response_code(404);
  echo "Produk tidak ditemukan.";
  exit;
}

// Ambil produk berdasarkan slug
$queryProduk = $db->query("SELECT * FROM produks WHERE slug = '$slugParam' LIMIT 1");
$produk = $queryProduk ? $queryProduk->fetch_assoc() : null;

// Jika produk tidak ditemukan
if (!$produk) {
  http_response_code(404);
  echo "Produk tidak ditemukan.";
  exit;
}

$current_id = $produk['id']; // id produk aktif

// Ambil ulasan
$queryUlasan = $db->query("SELECT * FROM ulasan");
$ulasanArray = [];
while ($ulasan = $queryUlasan->fetch_assoc()) {
  $ulasanArray[] = $ulasan;
}
shuffle($ulasanArray);
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

  <!-- SwiperJS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <title><?php echo htmlspecialchars($produk['nama']); ?></title>
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
</head>

<body>
  <!-- Navbar -->
  <nav id="navbar" class="navbar navbar-expand-lg navbar-dark shadow-sm bg-dark">
    <div class="container">
      <a class="navbar-brand" href="../../index.php">
        <img src="../assets/img/logo2.png" alt="incleen.autocare" width="200">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#produkLainnya">Produk Lainnya</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#tentangKami">Tentang Kami</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Akhir Navbar -->

  <!-- Produk -->
  <section id="Produk">
    <div id="produk" class="container mt-5">
      <div class="row">
        <!-- Kolom Gabungan Navigasi Gambar Kecil dan Card Utama -->
        <div class="col-md-7">
          <div class="d-flex">
            <!-- Thumbnail Swiper -->
            <div class="swiper-container d-none d-lg-block thumbnail-swiper me-2">
              <div class="swiper-wrapper">
                <?php
                $gambarList = ['gambar1', 'gambar2', 'gambar3', 'gambar4'];
                foreach ($gambarList as $gambar) {
                  if (!empty($produk[$gambar])) {
                    $src = $baseImagePath . htmlspecialchars($produk[$gambar]);
                    echo '
              <div class="swiper-slide">
                <img src="' . $src . '" class="img-thumbnail" alt="incleen.autocare">
              </div>
            ';
                  }
                }
                ?>
              </div>
            </div>
            <!-- End Thumbnail Swiper -->

            <!-- Card Utama -->
            <div class="card card-product">
              <!-- Wrapper Swiper untuk slider gambar produk utama -->
              <div class="swiper-container main-swiper">
                <div class="swiper-wrapper">
                  <?php
                  foreach ($gambarList as $gambar) {
                    if (!empty($produk[$gambar])) {
                      $src = $baseImagePath . htmlspecialchars($produk[$gambar]);
                      echo '
                <div class="swiper-slide">
                  <img src="' . $src . '" class="card-img-top img-fluid" alt="incleen.autocare">
                </div>
              ';
                    }
                  }
                  ?>
                </div>

                <!-- Tampilkan navigasi hanya jika ada lebih dari satu gambar -->
                <?php if (!empty($produk['gambar2']) || !empty($produk['gambar3']) || !empty($produk['gambar4'])) : ?>
                  <div class="swiper-pagination"></div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Kolom Deskripsi Produk -->
        <div class="col-md-5">
          <h1 class="mt-4 mt-md-0 mb-4"><?php echo htmlspecialchars($produk['nama']); ?></h1>
          <div class="harga-container d-flex align-items-center">
            <h2 class="harga-diskon me-2" data-harga="<?php echo $produk['harga_diskon']; ?>">
              <strong><?php echo htmlspecialchars($produk['harga_diskon']); ?></strong>
            </h2>
            <h2 class="harga-asli text-muted me-1" data-harga="<?php echo $produk['harga_asli']; ?>">
              <s><?php echo htmlspecialchars($produk['harga_asli']); ?></s>
            </h2>
            <?php
            // Menghapus karakter non-numerik sebelum mengonversi
            $harga_asli = intval(preg_replace("/[^0-9]/", "", $produk['harga_asli']));
            $harga_diskon = intval(preg_replace("/[^0-9]/", "", $produk['harga_diskon']));

            // Mengecek apakah harga_asli tidak nol sebelum melakukan pembagian
            if ($harga_asli > 0) {
              $diskon_persen = (($harga_asli - $harga_diskon) / $harga_asli) * 100;
              echo '<span class="diskon-badge text-danger">-' . round($diskon_persen) . '%</span>';
            } else {
              echo '<h2 class="text-danger ms-3">Harga tidak valid</h2>';
            }
            ?>
          </div>

          <div class="rating mb-3" style="font-size: 1rem;">
            <span class="fa fa-star" style="color: #FFD700;"></span>
            <span class="fa fa-star" style="color: #FFD700;"></span>
            <span class="fa fa-star" style="color: #FFD700;"></span>
            <span class="fa fa-star" style="color: #FFD700;"></span>
            <span class="fa fa-star" style="color: #FFD700;"></span>
            <span>|</span>
            <small style="font-size: 1rem;">10RB+ Ulasan</small>
            <span>|</span>
            <small style="font-size: 1rem;">10RB+ Terjual</small>
          </div>
          <p class="text-justify mb-4"><?php echo htmlspecialchars($produk['des_singkat']); ?></p>
          <hr>
          <h3 class="text-center mb-3">Beli disini</h3>
          <div class="text-center">
            <div class="mb-2">
              <a href="<?php echo htmlspecialchars($produk['link_shopee']); ?>" target="_blank">
                <button class="btn btn-shopee w-50 btn-lg">
                  <img width="30" height="30" src="https://img.icons8.com/ios/50/shopee.png" alt="shopee" class="me-2">Shopee
                </button>
              </a>
            </div>
            <div class="mb-2">
              <a href="<?php echo htmlspecialchars($produk['link_lazada']); ?>" target="_blank">
                <button class="btn btn-lazada w-50 btn-lg">
                  <img width="30" height="30" src="https://img.icons8.com/plasticine/100/lazada.png" alt="lazada" class="me-2">Lazada
                </button>
              </a>
            </div>
            <div>
              <a href="<?php echo htmlspecialchars($produk['link_tiktok']); ?>" target="_blank">
                <button class="btn btn-tiktok w-50 btn-lg">
                  <img width="30" height="30" src="https://img.icons8.com/color/48/tiktok--v1.png" alt="tiktok" class="me-2">Tiktok
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Produk -->

  <!-- Deskripsi dan Ulasan Pelanggan -->
  <section id="deskripsiUlasan">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h2 class="mb-4">Deskripsi Produk</h2>
          <hr>
          <p><?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
        </div>
        <div class="col-md-4">
          <div class="accordion d-md-none" id="accordionExample">
            <div class="accordion-item border-0">
              <h2 class="accordion-header px-0">
                <button class="accordion-button collapsed text-dark fs-3 bg-transparent px-0" style="font-weight: 500;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Ulasan
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body px-0">
                  <div class="card-container" style="overflow-y: scroll; max-height: 580px;">
                    <?php
                    // Loop untuk menampilkan setiap ulasan dalam urutan acak
                    foreach ($ulasanArray as $ulasan) {
                      echo '<div class="card mb-3" style="border: 1px solid #ddd; padding: 15px;">';
                      echo '<p><i class="fas fa-user me-2"></i> <strong>' . htmlspecialchars($ulasan['nama']) . '</strong></p>';
                      echo '<p>"' . htmlspecialchars($ulasan['ulasan']) . '"</p>';
                      echo '</div>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="ulasan-desktop" class="d-none d-md-block">
            <h2 class="mb-4">Ulasan</h2>
            <hr>
            <div class="card-container" style="overflow-y: scroll; max-height: 580px;">
              <?php
              // Loop untuk menampilkan setiap ulasan dalam urutan acak
              foreach ($ulasanArray as $ulasan) {
                echo '<div class="card mb-3" style="border: 1px solid #ddd; padding: 15px;">';
                echo '<p><i class="fas fa-user me-2"></i> <strong>' . htmlspecialchars($ulasan['nama']) . '</strong></p>';
                echo '<p>"' . htmlspecialchars($ulasan['ulasan']) . '"</p>';
                echo '</div>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Deskripsi dan Ulasan Pelanggan-->

  <!-- Produk Lainnya -->
  <section id="produkLainnya" class="section">
    <div class="container">
      <div class="row text-center">
        <div class="col">
          <h2>Produk Lainnya</h2>
        </div>
      </div>

      <div class="swiper">
        <!-- Wrapper Swiper -->
        <div class="slider-wrapper mt-5">
          <div class="swiper-wrapper">
            <?php
            $queryAll = $db->query("SELECT * FROM produks");
            while ($produkLainnya = $queryAll->fetch_assoc()) {
              if ($produkLainnya['id'] != $current_id) {
            ?>
                <div class="swiper-slide">
                  <div id="imgcard" class="card mb-5">
                    <img src="<?php echo $baseImagePath . htmlspecialchars($produkLainnya['gambar1']); ?>" class="card-img-top" alt="incleen.autocare">
                    <div class="content">
                      <div class="card-body">
                        <a href="../details/index.php?slug=<?php echo urlencode($produkLainnya['slug']); ?>" class="btn btn-outline-dark">Lihat Produk</a>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
              }
            }
            ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Produk Lainnya -->

  <!-- Tentang Kami -->
  <section id="tentangKami" class="section py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <img src="../assets/img/(25).JPG" class="img-fluid rounded shadow" alt="incleen.autocare">
        </div>
        <div class="col-md-6">
          <h2 class="mb-4">Tentang Kami</h2>
          <p class="text-justify">
            Selamat datang di <strong>incleen.autocare</strong>, pusat perawatan kendaraan premium yang didirikan dengan semangat lokal dan kualitas global. Kami hadir untuk memberikan solusi terbaik bagi perawatan kendaraan Anda, memastikan kendaraan Anda selalu tampil prima dengan produk perawatan unggulan buatan Indonesia.
          </p>
          <p class="text-justify">
            Di <strong>incleen.autocare</strong>, kualitas adalah prioritas utama. Setiap produk dirancang untuk memenuhi standar tertinggi dalam hal keamanan, efisiensi, dan keramahan lingkungan. Kami percaya bahwa perawatan kendaraan seharusnya tidak hanya menjaga tampilan luar, tetapi juga meningkatkan performa dan umur panjang kendaraan.
          </p>
          <p class="text-justify">
            Kami bangga mendukung gerakan <em>Made in Indonesia</em> dengan menghadirkan rangkaian produk yang dikembangkan khusus oleh para ahli di bidang perawatan otomotif. Dari pembersih eksterior hingga perlindungan interior, produk kami dirancang untuk memberikan hasil yang memuaskan tanpa kompromi.
          </p>
          <p class="text-justify">
            Dengan komitmen terhadap inovasi dan kepuasan pelanggan, kami terus berupaya untuk mempersembahkan produk perawatan yang aman, efektif, dan ramah lingkungan. Percayakan perawatan kendaraan Anda kepada <strong>incleen.autocare</strong> untuk hasil terbaik dan pengalaman yang mengesankan.
          </p>
          <p class="text-justify">
            Terima kasih telah mempercayai kami. Bersama-sama, mari mendukung produk lokal berkualitas yang mampu bersaing di pasar internasional.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Tentang Kami -->

  <!-- Kontak Kami -->
  <section id="kontakKami" class="py-5">
    <div class="container">
      <div class="row text-center">
        <div class="col">
          <h2>Kontak Kami</h2>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-6 mb-4">
          <h3>Informasi Kontak</h3>
          <p>Alamat: Jl. Inpeksi Citarum Majalaya, Majalaya, Kec. Majalaya, Kabupaten Bandung Jawa Barat</p>
          <p>Email: admin@incleenautocare.com</p>
          <div class="d-flex justify-content-start mt-3">
            <a href="https://api.whatsapp.com/send?phone=6282119041464" target="_blank" class="me-3">
              <i class="fab fa-whatsapp fa-2x" style="color: black;"></i>
            </a>
            <a href="https://www.instagram.com/incleen.autocare/" target="_blank" class="me-3">
              <i class="fab fa-instagram fa-2x" style="color: black;"></i>
            </a>
            <a href="https://www.tiktok.com/@incleen.autocare/" target="_blank">
              <i class="fab fa-tiktok fa-2x" style="color: black;"></i>
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d247.48043974571635!2d107.75564955604492!3d-7.046015421231174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1730491984632!5m2!1sid!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Kontak Kami -->

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="script.js?v=<?php echo time(); ?>"></script>
</body>

</html>