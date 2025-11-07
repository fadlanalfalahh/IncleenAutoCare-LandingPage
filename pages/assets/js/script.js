// Navbar
$(document).ready(function () {
  $(".nav-link").on("click", function (event) {
    event.preventDefault(); // Mencegah tindakan default anchor

    const target = $(this).attr("href"); // Ambil target dari href

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
  });

  // Tambahkan script untuk mengubah warna navbar saat di-scroll
  $(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
      $(".navbar").addClass("bg-dark"); // Ubah ke warna gelap saat di-scroll
    } else {
      $(".navbar").removeClass("bg-dark"); // Kembali transparan saat di posisi awal
    }

    // Deteksi posisi scroll
    let scrollPos = $(window).scrollTop();
    let offset;
    const screenWidth = $(window).width();
    if (screenWidth <= 375) {
      offset = 50; // Offset untuk layar 375px
    } else if (screenWidth <= 425) {
      offset = 60; // Offset untuk layar 425px
    } else if (screenWidth <= 768) {
      offset = 70; // Offset untuk layar 768px
    } else {
      offset = 100; // Offset default untuk layar lebih besar
    }

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

// Jumbotron
$(document).ready(function () {
  // Animasi slide down untuk h1 setelah img dengan delay tambahan
  $("#jumbotron h1")
    .css({ opacity: 0, top: "20px" })
    .delay(1200)
    .animate(
      { opacity: 1, top: "0px" },
      { duration: 2500, easing: "easeOutCubic" }
    );

  // Animasi fade in untuk p setelah h1 dengan delay tambahan
  $("#jumbotron p")
    .css({ opacity: 0, top: "20px" })
    .delay(1900)
    .animate(
      { opacity: 1, top: "0px" },
      { duration: 3000, easing: "easeOutCubic" }
    );
});
// Akhir Jumbotron

// Produk Terlaris
const swiper = new Swiper(".slider-wrapper", {
  loop: true, // Mengaktifkan looping agar slider berputar terus-menerus
  spaceBetween: 0, // Menghilangkan jarak antar slide
  slidesPerView: 3, // Menampilkan 3 gambar dalam satu waktu
  centeredSlides: false, // Pastikan slide tidak terpusat untuk menghindari potongan gambar lain

  autoplay: {
    delay: 4000,
    disableOnInteraction: false, // Tetap autoplay meskipun pengguna berinteraksi
  },

  pagination: {
    el: ".swiper-pagination",
    clickable: true, // Membuat pagination dapat diklik
  },

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  // Responsive breakpoints
  breakpoints: {
    // Untuk perangkat mobile, hanya tampilkan 1 gambar
    0: {
      slidesPerView: 1,
      spaceBetween: 0,
    },
    // Untuk tablet, tampilkan 2 gambar
    620: {
      slidesPerView: 2,
      spaceBetween: 10,
    },
    // Untuk desktop, tampilkan 3 gambar
    1024: {
      slidesPerView: 3,
      spaceBetween: 10,
    },
  },
});
// Akhir Produk Terlaris

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
