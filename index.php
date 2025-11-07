<?php
include 'config/koneksi.php';
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<!-- Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
		rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="pages/assets/css/style.css?v=<?php echo time(); ?>">

	<!-- SwiperJS CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

	<title>incleen.autocare</title>
	<link rel="icon" type="image/png" href="pages/assets/img/logo.png">
</head>

<body>
	<!-- Navbar -->
	<nav id="navbar" class="navbar navbar-expand-lg navbar-dark shadow-sm">
		<div class="container">
			<a class="navbar-brand" href="index.php">
				<img src="pages/assets/img/logo2.png" alt="incleen.autocare" width="200">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="#jumbotron">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#produkKami">Produk Kami</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#produkTerlaris">Produk Terlaris</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#tentangKami">Tentang Kami</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- Akhir Navbar -->

	<!-- Jumbotron -->
	<section id="jumbotron" class="section jumbotron text-center">
		<div class="container">
			<div class="row">
				<div class="col-3">
					<h1 class="display-4 text-dark">Perawatan Kendaraan Premium</h1>
					<p class="text-dark">Made in Indonesia | Lokal Produk</p>
				</div>
			</div>
		</div>
	</section>
	<!-- Akhir Jumbotron -->

	<!-- Produk Kami-->
	<section id="produkKami" class="section">
		<div class="container">
			<div class="row text-center">
				<div class="col">
					<h2>Produk Kami</h2>
				</div>
			</div>
			<div class="row mt-5">
				<?php
				$queryAll = $db->query("SELECT * FROM produks");
				while ($produk = $queryAll->fetch_assoc()) {
				?>
					<div class="col-6 col-md-4 col-lg-3">
						<div id="imgcard" class="card mb-5">
							<img src="<?php echo $baseImagePath . htmlspecialchars($produk['gambar1']); ?>" class="card-img-top" alt="incleen.autocare">
							<div class="content">
								<div class="card-body">
									<a href="pages/details/index.php?slug=<?php echo urlencode($produk['slug']); ?>" class="btn btn-outline-dark">Lihat Produk</a>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- Akhir Produk Kami-->

	<!-- Produk Terlaris -->
	<section id="produkTerlaris" class="section">
		<div class="container">
			<div class="row text-center">
				<div class="col">
					<h2>Produk Terlaris</h2>
				</div>
			</div>
			<div class="swiper">
				<div class="slider-wrapper mt-5">
					<div class="card-list swiper-wrapper">
						<?php
						$query = $db->query("SELECT * FROM produks WHERE terlaris = 1 LIMIT 3");
						while ($row = $query->fetch_assoc()) {
							$gambar = !empty($row['gambar1'])
								? $baseImagePath . htmlspecialchars($row['gambar1'])
								: $baseUrl . "/pages/assets/img/default.jpg";
						?>
							<div class="card-item swiper-slide">
								<img src="<?php echo $gambar; ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>">
							</div>
						<?php } ?>

						<?php
						// Bagian kedua swiper (duplikat untuk efek looping)
						$query = $db->query("SELECT * FROM produks WHERE terlaris = 1 LIMIT 3");
						while ($row = $query->fetch_assoc()) {
							$gambar = !empty($row['gambar1'])
								? $baseImagePath . htmlspecialchars($row['gambar1'])
								: $baseUrl . "/pages/assets/img/default.jpg";
						?>
							<div class="card-item swiper-slide">
								<img src="<?php echo $gambar; ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>">
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Akhir Produk Terlaris -->

	<!-- Tentang Kami -->
	<section id="tentangKami" class="section py-5">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 mb-4 mb-md-0">
					<img src="pages/assets/img/(25).JPG" class="img-fluid rounded shadow" alt="incleen.autocare">
				</div>
				<div class="col-md-6">
					<h2 class="mb-4">Tentang Kami</h2>
					<p class="text-justify">
						Selamat datang di <strong>incleen.autocare</strong>, pusat perawatan kendaraan premium yang
						didirikan dengan semangat lokal dan kualitas global. Kami hadir untuk memberikan solusi terbaik
						bagi perawatan kendaraan Anda, memastikan kendaraan Anda selalu tampil prima dengan produk
						perawatan unggulan buatan Indonesia.
					</p>
					<p class="text-justify">
						Di <strong>incleen.autocare</strong>, kualitas adalah prioritas utama. Setiap produk dirancang
						untuk memenuhi standar tertinggi dalam hal keamanan, efisiensi, dan keramahan lingkungan. Kami
						percaya bahwa perawatan kendaraan seharusnya tidak hanya menjaga tampilan luar, tetapi juga
						meningkatkan performa dan umur panjang kendaraan.
					</p>
					<p class="text-justify">
						Kami bangga mendukung gerakan <em>Made in Indonesia</em> dengan menghadirkan rangkaian produk
						yang dikembangkan khusus oleh para ahli di bidang perawatan otomotif. Dari pembersih eksterior
						hingga perlindungan interior, produk kami dirancang untuk memberikan hasil yang memuaskan tanpa
						kompromi.
					</p>
					<p class="text-justify">
						Dengan komitmen terhadap inovasi dan kepuasan pelanggan, kami terus berupaya untuk
						mempersembahkan produk perawatan yang aman, efektif, dan ramah lingkungan. Percayakan perawatan
						kendaraan Anda kepada <strong>incleen.autocare</strong> untuk hasil terbaik dan pengalaman yang
						mengesankan.
					</p>
					<p class="text-justify">
						Terima kasih telah mempercayai kami. Bersama-sama, mari mendukung produk lokal berkualitas yang
						mampu bersaing di pasar internasional.
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
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d247.48043974571635!2d107.75564955604492!3d-7.046015421231174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1730491984632!5m2!1sid!2sid"
						width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
		</div>
	</section>
	<!-- Akhir Kontak Kami -->

	<!-- Script -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
	</script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
	<script src="pages/assets/js/script.js?v=<?php echo time(); ?>"></script>
</body>

</html>