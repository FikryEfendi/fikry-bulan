<?php
// ─── DATA UNDANGAN (variabel PHP) ───
$nama_pria        = "Muhammad Fikry Efendi";
$nama_wanita      = "Bulan Hijarati A";
$ortu_pria        = "Bapak Harry &amp; Ibu Ginny";
$ortu_wanita      = "Bapak Ron &amp; Ibu Hermione";

$tanggal_acara    = "Sabtu, 14 Februari 2027";
$tanggal_numerik  = "14.02.27";
$jam_akad         = "08:00 WIB";
$jam_resepsi      = "11:00 WIB - Selesai";
$jam_persiapan    = "07:00 WIB";
$dress_code       = "Pastel — Nude — Earthy Tone";

$nama_venue       = "Universitas Riau";
$alamat_venue     = "Kampus Bina Widya, Jl. Bangau Sakti KM. 12,5<br>Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293";
$maps_embed       = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3288.369402747278!2d101.37807147396548!3d0.4763830637627744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5aea1f427ab57:0x74d49c35acbd10e1!2sUniversitas%20Riau!5e1!3m2!1sid!2sid!4v1772437642959!5m2!1sid!2sid";
$maps_link        = "https://maps.google.com/?q=Universitas+Riau";

// Nama tamu dari URL parameter (dinamis)
$nama_tamu = isset($_GET['tamu']) ? htmlspecialchars($_GET['tamu']) : "Tamu Undangan";

// Love story (array of data)
$love_story = [
    ["tahun" => "2019", "judul" => "Pertemuan Pertama",  "isi" => "Takdir mempertemukan kami di kampus Universitas Riau. Sebuah senyum sederhana menjadi awal dari segalanya — saat itu kami belum tahu bahwa hidup kami akan berubah selamanya."],
    ["tahun" => "2020", "judul" => "Semakin Dekat",       "isi" => "Di tengah pandemi yang mengunci dunia, justru kedekatan kami semakin tak terbendung. Percakapan tanpa batas dan tawa yang menghangatkan hari-hari sulit."],
    ["tahun" => "2022", "judul" => "Menjalin Hubungan",   "isi" => "Dengan bismillah dan doa restu keluarga, kami resmi memulai hubungan. Setiap langkah dipenuhi kasih sayang dan komitmen untuk saling menjaga."],
    ["tahun" => "2027", "judul" => "Menuju Pelaminan ✦", "isi" => "Setelah perjalanan panjang yang indah, kami akhirnya siap melangkah ke babak baru — membangun keluarga sakinah, mawaddah, warahmah bersama selamanya.", "warna" => "rose"],
];

// Judul halaman (dinamis berdasarkan nama mempelai)
$page_title = "Undangan Pernikahan — " . strip_tags($nama_pria) . " &amp; " . strip_tags($nama_wanita);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?></title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Cinzel:wght@400;600&family=Lato:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="src/output.css">
<link rel="stylesheet" href="undangan.css">
</head>
<body>

<!-- ── NAVIGATION DESKTOP ── -->
<nav class="nav" id="mainNav">
  <a href="#cover">Home</a>
  <a href="#pengantar">Pengantar</a>
  <a href="#mempelai">Mempelai</a>
  <a href="#waktu">Waktu</a>
  <a href="#lokasi">Lokasi</a>
  <a href="#galeri">Galeri</a>
  <a href="#story">Cerita</a>
  <a href="#ucapan">Ucapan</a>
  <a href="#penutup">Penutup</a>
  <a href="dashboard.php" class="nav-dashboard">⬡ Dashboard</a>
</nav>

<!-- ── MOBILE NAV ── -->
<div class="mobile-nav" id="mobileNav">
  <div class="mobile-nav-bar">
    <a href="#cover" class="mobile-home-link">Home</a>
    <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleMobileMenu()">
      <span></span><span></span><span></span>
    </button>
  </div>
</div>

<!-- Mobile Menu Drawer -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay" onclick="closeMobileMenu()"></div>
<div class="mobile-menu-drawer" id="mobileMenuDrawer">
  <div class="mobile-menu-header">
    <span class="mobile-menu-title">Menu</span>
    <button onclick="closeMobileMenu()" class="mobile-menu-close">✕</button>
  </div>
  <a href="#cover" onclick="closeMobileMenu()">Home</a>
  <a href="#pengantar" onclick="closeMobileMenu()">Pengantar</a>
  <a href="#mempelai" onclick="closeMobileMenu()">Mempelai</a>
  <a href="#waktu" onclick="closeMobileMenu()">Waktu</a>
  <a href="#lokasi" onclick="closeMobileMenu()">Lokasi</a>
  <a href="#galeri" onclick="closeMobileMenu()">Galeri</a>
  <a href="#story" onclick="closeMobileMenu()">Cerita</a>
  <a href="#ucapan" onclick="closeMobileMenu()">Ucapan</a>
  <a href="#penutup" onclick="closeMobileMenu()">Penutup</a>
  <a href="dashboard.php" class="mobile-dashboard-link">⬡ Dashboard</a>
</div>

<!-- ─── COVER OPENING ─── -->
<div id="opening" class="opening-screen">
  <div class="opening-content">
    <p class="label">Undangan Pernikahan</p>
    <h1 class="opening-title">
      <?php
        // Ambil nama depan saja untuk tampilan opening
        $nama_depan_pria   = explode(' ', $nama_pria)[0];
        $nama_depan_wanita = explode(' ', $nama_wanita)[0];
        echo $nama_depan_pria . ' <span>&amp;</span> ' . $nama_depan_wanita;
      ?>
    </h1>
    <p class="opening-sub">Kepada Yth. <?php echo $nama_tamu; ?></p>
    <button class="btn-gold" onclick="bukaUndangan()">Buka Undangan</button>
  </div>
</div>

<!-- ══ 1. COVER ══ -->
<section id="cover" class="section" style="padding-top:70px;">
  <div class="card cover-card fade-up">
    <div class="cover-frame"></div>
    <span class="label">Undangan Pernikahan</span>
    <div class="guest-tag" id="guestTag">✦ Kepada Yth. <?php echo $nama_tamu; ?> ✦</div>

    <div class="ornament">— ✦ —</div>

    <div class="display-name">
      <?php echo $nama_depan_pria; ?>
      <span class="ampersand">&amp;</span>
      <?php echo $nama_depan_wanita; ?>
    </div>

    <img src="home1.png" alt="Cover Undangan" class="cover-img float">

    <div class="date-badge"><?php echo $tanggal_acara; ?></div>

    <div class="divider"><span class="divider-icon">✦</span></div>

    <div id="countdown">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
      <div class="time-box"><span id="days">00</span><small>Hari</small></div>
      <div class="time-box"><span id="hours">00</span><small>Jam</small></div>
      <div class="time-box"><span id="minutes">00</span><small>Menit</small></div>
      <div class="time-box"><span id="seconds">00</span><small>Detik</small></div>
    </div>

    <p class="body-text" style="margin-top:12px; font-style:italic; font-size:13px;">
      Mohon maaf atas kesalahan dalam penulisan nama
    </p>
  </div>
</section>

<!-- ══ 2. PENGANTAR ══ -->
<section id="pengantar" class="section">
  <div class="card bg-[#fdf8f3] border-1 border-[#c9a96e]/30 shadow-xl">
    <span class="ornament">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</span>
    <div class="divider"><span class="divider-icon">✦</span></div>
    <p class="section-title">Assalamu'alaikum Warahmatullahi Wabarakatuh</p>

    <p class="body-text" style="margin-top:16px;">
      Dengan memohon rahmat dan ridho Allah SWT serta dengan penuh syukur,
      kami bermaksud menyelenggarakan pernikahan putra-putri kami.
    </p>

    <div class="quote-box" style="margin-top:28px;">
      "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan untukmu pasangan hidup
      dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan dijadikan-Nya di antara
      kamu rasa kasih dan sayang." <br>
      <span style="font-size:14px; color:var(--gold-dark); font-style:normal; letter-spacing:1px;">— QS. Ar-Rum: 21</span>
    </div>

    <p class="body-text" style="margin-top:16px;">
      Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i,
      khususnya <strong style="color:var(--brown);" id="pengantarNama"><?php echo $nama_tamu; ?></strong>,
      berkenan hadir untuk memberikan doa restu.
    </p>
  </div>
</section>

<!-- ══ 3. MEMPELAI ══ -->
<section id="mempelai" class="section">
  <div class="card scroll-reveal">
    <span class="label">Informasi Mempelai</span>
    <p class="section-title">Dua Jiwa, Satu Ikatan</p>
    <div class="divider"><span class="divider-icon">♥</span></div>

    <div class="mempelai-grid">
      <div class="mempelai-person">
        <img src="mempelai1.png" alt="<?php echo $nama_depan_pria; ?>" class="mempelai-photo">
        <p class="big-name"><?php echo $nama_pria; ?></p>
        <p class="sub-text">Putra pertama dari<br><strong><?php echo $ortu_pria; ?></strong></p>
      </div>

      <div class="mempelai-sep">💍</div>

      <div class="mempelai-person">
        <img src="mempelai2.png" alt="<?php echo $nama_depan_wanita; ?>" class="mempelai-photo">
        <p class="big-name"><?php echo $nama_wanita; ?></p>
        <p class="sub-text">Putri pertama dari<br><strong><?php echo $ortu_wanita; ?></strong></p>
      </div>
    </div>

    <div class="divider"><span class="divider-icon">✦</span></div>
    <p class="body-text">
      Dengan penuh kebahagiaan dan doa, kedua keluarga mengundang Anda
      untuk menjadi bagian dari hari bahagia kami.
    </p>
  </div>
</section>

<!-- ══ 4. WAKTU ══ -->
<section id="waktu" class="section">
  <div class="card scroll-reveal">
    <span class="label">Jadwal Acara</span>
    <p class="section-title">Waktu Pelaksanaan</p>
    <div class="divider"><span class="divider-icon">✦</span></div>

    <div style="font-family:'Cormorant Garamond',serif; font-size:clamp(36px,8vw,48px); color:var(--brown); font-weight:300; margin:10px 0;">
      <?php echo $tanggal_numerik; ?>
    </div>
    <p class="sub-text"><?php echo $tanggal_acara; ?></p>

    <div class="timeline" style="margin-top:36px;">
      <div class="timeline-item">
        <div class="timeline-content">
          <div class="timeline-time"><?php echo $jam_persiapan; ?></div>
          <div class="timeline-label">Persiapan</div>
        </div>
        <div class="timeline-dot"></div>
        <div class="timeline-spacer" style="flex:1;"></div>
      </div>
      <div class="timeline-item">
        <div class="timeline-spacer" style="flex:1;"></div>
        <div class="timeline-dot"></div>
        <div class="timeline-content" style="text-align:left;">
          <div class="timeline-time"><?php echo $jam_akad; ?></div>
          <div class="timeline-label">Akad Nikah</div>
        </div>
      </div>
      <div class="timeline-item">
        <div class="timeline-content">
          <div class="timeline-time"><?php echo $jam_resepsi; ?></div>
          <div class="timeline-label">Resepsi</div>
        </div>
        <div class="timeline-dot" style="background:var(--rose);"></div>
        <div class="timeline-spacer" style="flex:1;"></div>
      </div>
    </div>

    <div style="margin-top:28px; padding:18px; background:rgba(201,169,110,0.08); border-radius:12px; border:1px solid rgba(201,169,110,0.2);">
      <p class="sub-text" style="margin:0;">
        <span style="color:var(--gold);font-size:16px;">✦</span> Dress Code:
        <strong><?php echo $dress_code; ?></strong>
      </p>
    </div>
  </div>
</section>

<!-- ══ 5. LOKASI ══ -->
<section id="lokasi" class="section">
  <div class="card scroll-reveal">
    <span class="label">Lokasi Acara</span>
    <p class="section-title">Tempat Pelaksanaan</p>
    <div class="divider"><span class="divider-icon">📍</span></div>

    <p class="big-name" style="font-size:26px; margin-bottom:4px;"><?php echo $nama_venue; ?></p>
    <p class="sub-text"><?php echo $alamat_venue; ?></p>

    <div class="maps-wrap">
      <iframe src="<?php echo $maps_embed; ?>" loading="lazy"></iframe>
    </div>

    <a href="<?php echo $maps_link; ?>" target="_blank" class="maps-btn">
      🗺 Buka di Google Maps
    </a>
  </div>
</section>

<!-- ══ 6. GALERI ══ -->
<section id="galeri" class="section">
  <div class="card scroll-reveal">
    <span class="label">Galeri Foto</span>
    <p class="section-title">Momen Berharga</p>
    <div class="divider"><span class="divider-icon">✦</span></div>

    <div class="gallery-grid">
      <?php
        // Generate gallery items dengan loop PHP
        $total_foto = 5;
        for ($i = 1; $i <= $total_foto; $i++) {
          $featured = ($i === 1) ? ' featured' : '';
          echo '<div class="gallery-item' . $featured . '">';
          echo '<img src="galeri' . $i . '.png" alt="Foto ' . $i . '">';
          echo '</div>';
        }
      ?>
    </div>

    <p class="sub-text" style="margin-top:16px; font-size:12px;">
      Setiap foto menyimpan cerita cinta yang tak terlupakan ✦
    </p>
  </div>
</section>

<!-- ══ 7. LOVE STORY ══ -->
<section id="story" class="section">
  <div class="card scroll-reveal">
    <span class="label">Our Love Story</span>
    <p class="section-title">Perjalanan Cinta</p>
    <div class="divider"><span class="divider-icon">💌</span></div>

    <div style="margin-top:28px; text-align:left;">
      <?php
        // Loop array love story untuk generate HTML dinamis
        foreach ($love_story as $item) {
          $warna_style = isset($item['warna']) && $item['warna'] === 'rose'
            ? 'border-left-color:var(--rose);'
            : '';
          $warna_tahun = isset($item['warna']) && $item['warna'] === 'rose'
            ? 'color:var(--rose);'
            : '';
          echo '<div class="story-item" style="' . $warna_style . '">';
          echo '  <div class="story-year" style="' . $warna_tahun . '">' . $item['tahun'] . '</div>';
          echo '  <div class="story-text">';
          echo '    <h4>' . $item['judul'] . '</h4>';
          echo '    <p>' . $item['isi'] . '</p>';
          echo '  </div>';
          echo '</div>';
        }
      ?>
    </div>
  </div>
</section>

<!-- ══ 8. UCAPAN & RSVP ══ -->
<section id="ucapan" class="section">
  <div class="card scroll-reveal">
    <span class="label">Doa &amp; Ucapan</span>
    <p class="section-title">Sampaikan Doamu</p>
    <div class="divider"><span class="divider-icon">✦</span></div>

    <div class="ucapan-list" id="ucapanList"></div>

    <div class="ucapan-form">
      <div style="font-size:12px; letter-spacing:2px; text-transform:uppercase; color:var(--gold-dark); margin-bottom:14px;">Tinggalkan Ucapan</div>
      <!-- Nama tamu dari URL otomatis terisi -->
      <input type="text" id="ucapanNama" placeholder="Nama Anda" value="<?php echo ($nama_tamu !== 'Tamu Undangan') ? $nama_tamu : ''; ?>"/>
      <textarea id="ucapanPesan" placeholder="Tulis doa dan ucapan untuk mempelai..."></textarea>
      <select id="ucapanStatus">
        <option value="">— Konfirmasi Kehadiran —</option>
        <option value="hadir">✓ Hadir</option>
        <option value="tidak">✗ Tidak Hadir</option>
      </select>
      <button class="btn-gold" onclick="kirimUcapan()">Kirim Ucapan ✦</button>
    </div>

    <p id="pesanKonfirmasi" style="margin-top:16px; color:var(--gold-dark); font-size:14px; font-style:italic;"></p>
  </div>
</section>

<!-- ══ 9. PENUTUP ══ -->
<section id="penutup" class="section">
  <div class="card scroll-reveal" style="text-align:center;">
    <span class="ornament">✦ ✦ ✦</span>
    <div class="display-name" style="font-size:clamp(44px,10vw,60px); letter-spacing:6px;">
      <?php
        // Inisial nama mempelai
        echo substr($nama_depan_pria, 0, 1) . ' &amp; ' . substr($nama_depan_wanita, 0, 1);
      ?>
    </div>
    <p class="sub-text" style="font-size:18px; margin-top:4px;">
      <?php echo $nama_depan_pria . ' &amp; ' . $nama_depan_wanita; ?>
    </p>
    <div class="divider"><span class="divider-icon">♥</span></div>

    <img src="penutup1.png" alt="Foto Mempelai"
         style="width:180px;height:180px;object-fit:cover;border-radius:50%;border:4px solid var(--gold);box-shadow:0 0 0 8px rgba(201,169,110,0.15);margin:24px auto;display:block;">

    <p class="body-text" style="margin:20px auto;">
      Semoga pernikahan ini menjadi awal perjalanan yang penuh keberkahan,
      kebahagiaan, dan cinta yang abadi hingga akhir hayat.
    </p>

    <p style="font-size:13px; color:var(--gold); letter-spacing:2px; margin:20px 0;">
      <?php echo $tanggal_acara; ?>
    </p>

    <div style="background:linear-gradient(135deg,rgba(201,169,110,0.1),rgba(185,110,130,0.08));border-radius:14px;padding:20px;margin-top:16px;">
      <p style="font-family:'Cormorant Garamond',serif;font-size:17px;font-style:italic;color:var(--brown-light);">
        Wassalamu'alaikum Warahmatullahi Wabarakatuh
      </p>
      <p style="font-size:13px;color:var(--text-light);margin-top:8px;">
        Hormat kami, Keluarga Besar <?php echo $nama_depan_pria . ' &amp; ' . $nama_depan_wanita; ?>
      </p>
    </div>

    <div class="rsvp-btns">
      <button class="btn-gold" onclick="quickRsvp('Hadir')">✓ Konfirmasi Hadir</button>
      <button class="btn-rose" onclick="quickRsvp('Tidak Hadir')">✗ Tidak Hadir</button>
    </div>
    <p id="pesanRsvp" style="margin-top:12px;font-size:14px;color:var(--gold-dark);font-style:italic;"></p>
  </div>
</section>

<!-- ─── MUSIC BTN ─── -->
<button class="music-btn" id="musicBtn" onclick="toggleMusic()" title="Musik">🎵</button>
<audio id="bgMusic" loop>
  <source src="audio2.mpeg" type="audio/mpeg">
</audio>

<script src="undangan.js"></script>
<script>
// Nama tamu dari PHP diteruskan ke JS (override URL param)
(function() {
  const namaTamuPHP = "<?php echo addslashes($nama_tamu); ?>";
  const guestTagEl = document.getElementById('guestTag');
  const pengantarNamaEl = document.getElementById('pengantarNama');
  if (guestTagEl) guestTagEl.textContent = `✦ Kepada Yth. ${namaTamuPHP} ✦`;
  if (pengantarNamaEl) pengantarNamaEl.textContent = namaTamuPHP;
})();

function toggleMobileMenu() {
  document.getElementById('mobileMenuDrawer').classList.toggle('open');
  document.getElementById('mobileMenuOverlay').classList.toggle('show');
  document.getElementById('hamburgerBtn').classList.toggle('active');
}
function closeMobileMenu() {
  document.getElementById('mobileMenuDrawer').classList.remove('open');
  document.getElementById('mobileMenuOverlay').classList.remove('show');
  document.getElementById('hamburgerBtn').classList.remove('active');
}
</script>
</body>
</html>