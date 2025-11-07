// Navbar
$(document).ready(function () {
  $(".nav-link").on("click", function (event) {
    const target = $(this).attr("href");

    // Jika link mengarah ke halaman "Home", hindari preventDefault
    if (!target.includes("../../index.php")) {
      event.preventDefault();

      // Tambahkan pengaturan offset untuk ukuran layar tertentu
      let offset;
      const screenWidth = $(window).width();
      if (screenWidth <= 375) {
        offset = -20; // Offset untuk layar 375px
      } else if (screenWidth <= 425) {
        offset = -20; // Offset untuk layar 425px
      } else if (screenWidth <= 768) {
        offset = -15; // Offset untuk layar 768px
      } else {
        offset = 70; // Offset default untuk layar lebih besar
      }

      $("html, body").animate(
        {
          scrollTop: $(target).offset().top - offset,
        },
        50, // Durasi animasi dalam milidetik (sesuaikan untuk lebih halus)
        "easeInOutCubic" // Gunakan easing untuk efek transisi lebih halus
      );

      $(".nav-link").removeClass("active"); // Hapus kelas active dari semua link
      $(this).addClass("active"); // Tambahkan kelas active ke link yang diklik

      // Tutup navbar collapse jika ukuran layar kecil
      if (screenWidth <= 768) {
        $(".navbar-collapse").collapse("hide");
      }
    }
  });

  $(window).scroll(function () {
    // Deteksi posisi scroll
    let scrollPos = $(window).scrollTop();
    let offset = 100; // Sesuaikan dengan offset navbar
    let found = false;

    $(".section").each(function () {
      // Pastikan semua konten memiliki kelas "section"
      let sectionTop = $(this).offset().top - offset;
      let sectionBottom = sectionTop + $(this).outerHeight();

      if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
        let id = $(this).attr("id");
        $(".nav-link").removeClass("active");
        $('.nav-link[href="#' + id + '"]').addClass("active");
        found = true;
      }
    });

    if (!found) {
      $(".nav-link").removeClass("active");
    }
  });
});
// Akhir Navbar

// Produk
const thumbnailSwiper = new Swiper(".thumbnail-swiper", {
  direction: "vertical",
  slidesPerView: 4,
  spaceBetween: 10,
  watchSlidesProgress: true, // Memonitor thumbnail aktif
});

// Main Swiper dengan sinkronisasi thumbnail
const mainSwiper = new Swiper(".main-swiper", {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,

  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },

  thumbs: {
    swiper: thumbnailSwiper, // Sinkronisasi dengan thumbnail
  },
});

function formatRupiah(amount) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0, // Tanpa desimal
  }).format(amount);
}

$(document).ready(function () {
  // Format harga-diskon
  $(".harga-diskon").each(function () {
    const harga = $(this).data("harga"); // Ambil nilai dari atribut data-harga
    const formattedHarga = formatRupiah(harga); // Format ke Rupiah
    $(this).html(`<strong>${formattedHarga}</strong>`); // Ganti konten HTML
  });

  // Format harga-asli
  $(".harga-asli").each(function () {
    const harga = $(this).data("harga"); // Ambil nilai dari atribut data-harga
    const formattedHarga = formatRupiah(harga); // Format ke Rupiah
    $(this).html(`<s>${formattedHarga}</s>`); // Ganti konten HTML
  });
});
// Akhir Produk

// Produk Lainnya
const swiper = new Swiper(".slider-wrapper", {
  slidesPerView: 3,
  spaceBetween: 20,
  loop: true, // Supaya carousel berputar terus

  autoplay: {
    delay: 5000,
    disableOnInteraction: false, // Tetap autoplay meskipun pengguna berinteraksi
  },

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },

  breakpoints: {
    // Untuk perangkat mobile, hanya tampilkan 1 gambar
    0: {
      slidesPerView: 1,
    },
    // Untuk tablet, tampilkan 2 gambar
    620: {
      slidesPerView: 2,
    },
    // Untuk desktop, tampilkan 3 gambar
    1024: {
      slidesPerView: 3,
    },
  },
});
// Akhir Produk Lainnya

// Tentang Kami
function typeEffect(element, speed, deleteSpeed, pause) {
  const text = element.innerHTML;
  element.innerHTML = "";
  let i = 0;
  let isDeleting = false;

  // Membuat elemen cursor
  const cursor = document.createElement("span");
  cursor.classList.add("cursor");
  cursor.innerHTML = "|";
  element.appendChild(cursor);

  function typing() {
    if (!isDeleting && i < text.length) {
      // Mengetik teks
      element.innerHTML = text.substring(0, i + 1);
      element.appendChild(cursor);
      i++;
      setTimeout(typing, speed);
    } else if (isDeleting && i > 0) {
      // Menghapus teks
      element.innerHTML = text.substring(0, i - 1);
      element.appendChild(cursor);
      i--;
      setTimeout(typing, deleteSpeed);
    } else if (i === text.length) {
      // Jeda setelah selesai mengetik sebelum menghapus
      setTimeout(() => {
        isDeleting = true;
        typing();
      }, pause); // Jeda sebelum mulai menghapus
    } else if (i === 0 && isDeleting) {
      // Jeda setelah selesai menghapus sebelum mengetik ulang
      isDeleting = false;
      setTimeout(typing, pause);
    }
  }

  typing();
}

$(document).ready(function () {
  const heading = document.querySelector("#tentangKami h2");
  typeEffect(heading, 300, 150, 2000); // Anda bisa menyesuaikan kecepatan dan jeda
});
// Akhir Tentang Kami
