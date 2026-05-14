<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $page_title }}</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Cinzel:wght@400;600&family=Lato:wght@300;400&display=swap" rel="stylesheet">
{{-- Jika pakai Tailwind via Vite: --}}
{{-- @vite(['resources/css/app.css']) --}}
<link rel="stylesheet" href="{{ asset('css/undangan.css') }}">
</head>
<body>

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
  <a href="{{ route('dashboard') }}" class="nav-dashboard">⬡ Dashboard</a>
</nav>

<div class="mobile-nav" id="mobileNav">
  <div class="mobile-nav-bar">
    <a href="#cover" class="mobile-home-link">Home</a>
    <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleMobileMenu()">
      <span></span><span></span><span></span>
    </button>
  </div>
</div>

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
  <a href="{{ route('dashboard') }}" class="mobile-dashboard-link">⬡ Dashboard</a>
</div>

{{-- ===== OPENING SCREEN ===== --}}
<div id="opening" class="opening-screen">
  <div class="opening-content">
    <p class="label">Undangan Pernikahan</p>
    <h1 class="opening-title">
      {{ $nama_depan_pria }} <span>&amp;</span> {{ $nama_depan_wanita }}
    </h1>
    <p class="opening-sub">Kepada Yth. {{ $nama_tamu }}</p>
    <button class="btn-gold" onclick="bukaUndangan()">Buka Undangan</button>
  </div>
</div>

{{-- ===== COVER ===== --}}
<section id="cover" class="section" style="padding-top:70px;">
  <div class="card cover-card fade-up">
    <div class="cover-frame"></div>
    <span class="label">Undangan Pernikahan</span>
    <div class="guest-tag" id="guestTag">✦ Kepada Yth. {{ $nama_tamu }} ✦</div>

    <div class="ornament">— ✦ —</div>

    <div class="display-name">
      {{ $nama_depan_pria }}
      <span class="ampersand">&amp;</span>
      {{ $nama_depan_wanita }}
    </div>

    @php
      $coverUrl = ($pengaturan && $pengaturan->foto_cover) ? asset('storage/' . $pengaturan->foto_cover) : asset('images/home1.png');
    @endphp
    <img src="{{ $coverUrl }}" alt="Cover Undangan" class="cover-img float">

    <div class="date-badge">{{ $tanggal_acara }}</div>

    <div class="divider"><span class="divider-icon">✦</span></div>

    <div id="countdown">
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

{{-- ===== PENGANTAR ===== --}}
<section id="pengantar" class="section">
  <div class="card bg-[#fdf8f3] border-1 border-[#c9a96e]/30 shadow-xl">
    <span class="ornament">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</span>
    <div class="divider"><span class="divider-icon">✦</span></div>
    <p class="section-title">Assalamu'alaikum Warahmatullahi Wabarakatuh</p>

    <p class="body-text" style="margin-top:16px;">
      {{ $pengaturan->pengantar ?? 'Dengan memohon rahmat dan ridho Allah SWT serta dengan penuh syukur, kami bermaksud menyelenggarakan pernikahan putra-putri kami.' }}
    </p>

    <div class="quote-box" style="margin-top:28px;">
      "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan untukmu pasangan hidup
      dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan dijadikan-Nya di antara
      kamu rasa kasih dan sayang." <br>
      <span style="font-size:14px; color:var(--gold-dark); font-style:normal; letter-spacing:1px;">— QS. Ar-Rum: 21</span>
    </div>

    <p class="body-text" style="margin-top:16px;">
      Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i,
      khususnya <strong style="color:var(--brown);" id="pengantarNama">{{ $nama_tamu }}</strong>,
      berkenan hadir untuk memberikan doa restu.
    </p>
  </div>
</section>

{{-- ===== MEMPELAI ===== --}}
<section id="mempelai" class="section">
  <div class="card scroll-reveal">
    <span class="label">Informasi Mempelai</span>
    <p class="section-title">Dua Jiwa, Satu Ikatan</p>
    <div class="divider"><span class="divider-icon">♥</span></div>

    <div class="mempelai-grid">
      <div class="mempelai-person">
        @php
          $priaUrl = ($mempelai_pria && $mempelai_pria->foto) ? asset('storage/' . $mempelai_pria->foto) : asset('images/mempelai1.png');
        @endphp
        <img src="{{ $priaUrl }}" alt="{{ $nama_depan_pria }}" class="mempelai-photo">
        <p class="big-name">{{ $nama_pria }}</p>
        <p class="sub-text">{{ $mempelai_pria ? $mempelai_pria->status_keluarga : 'Putra pertama dari' }}<br><strong>{{ $mempelai_pria ? $mempelai_pria->nama_ayah . ' & ' . $mempelai_pria->nama_ibu : '' }}</strong></p>
      </div>

      <div class="mempelai-sep">💍</div>

      <div class="mempelai-person">
        @php
          $wanitaUrl = ($mempelai_wanita && $mempelai_wanita->foto) ? asset('storage/' . $mempelai_wanita->foto) : asset('images/mempelai2.png');
        @endphp
        <img src="{{ $wanitaUrl }}" alt="{{ $nama_depan_wanita }}" class="mempelai-photo">
        <p class="big-name">{{ $nama_wanita }}</p>
        <p class="sub-text">{{ $mempelai_wanita ? $mempelai_wanita->status_keluarga : 'Putri pertama dari' }}<br><strong>{{ $mempelai_wanita ? $mempelai_wanita->nama_ayah . ' & ' . $mempelai_wanita->nama_ibu : '' }}</strong></p>
      </div>
    </div>

    <div class="divider"><span class="divider-icon">✦</span></div>
    <p class="body-text">
      Dengan penuh kebahagiaan dan doa, kedua keluarga mengundang Anda
      untuk menjadi bagian dari hari bahagia kami.
    </p>
  </div>
</section>

{{-- ===== WAKTU ===== --}}
<section id="waktu" class="section">
  <div class="card scroll-reveal">
    <span class="label">Jadwal Acara</span>
    <p class="section-title">Waktu Pelaksanaan</p>
    <div class="divider"><span class="divider-icon">✦</span></div>

    <div style="font-family:'Cormorant Garamond',serif; font-size:clamp(36px,8vw,48px); color:var(--brown); font-weight:300; margin:10px 0;">
      {{ $tanggal_numerik }}
    </div>
    <p class="sub-text">{{ $tanggal_acara }}</p>

    <div class="timeline" style="margin-top:36px;">
      @foreach ($semua_acara as $index => $item)
        <div class="timeline-item">
          @if ($index % 2 == 0)
            <div class="timeline-content">
              <div class="timeline-time">{{ $item->jam_mulai }} {{ $item->jam_selesai ? '- ' . $item->jam_selesai : '' }}</div>
              <div class="timeline-label">{{ $item->nama_acara }}</div>
            </div>
            <div class="timeline-dot" style="{{ $index === count($semua_acara)-1 ? 'background:var(--rose);' : '' }}"></div>
            <div class="timeline-spacer" style="flex:1;"></div>
          @else
            <div class="timeline-spacer" style="flex:1;"></div>
            <div class="timeline-dot" style="{{ $index === count($semua_acara)-1 ? 'background:var(--rose);' : '' }}"></div>
            <div class="timeline-content" style="text-align:left;">
              <div class="timeline-time">{{ $item->jam_mulai }} {{ $item->jam_selesai ? '- ' . $item->jam_selesai : '' }}</div>
              <div class="timeline-label">{{ $item->nama_acara }}</div>
            </div>
          @endif
        </div>
      @endforeach
    </div>

    <div style="margin-top:28px; padding:18px; background:rgba(201,169,110,0.08); border-radius:12px; border:1px solid rgba(201,169,110,0.2);">
      <p class="sub-text" style="margin:0;">
        <span style="color:var(--gold);font-size:16px;">✦</span> Dress Code:
        <strong>{{ $dress_code }}</strong>
      </p>
    </div>
  </div>
</section>

{{-- ===== LOKASI ===== --}}
<section id="lokasi" class="section">
  <div class="card scroll-reveal">
    <span class="label">Lokasi Acara</span>
    <p class="section-title">Tempat Pelaksanaan</p>
    <div class="divider"><span class="divider-icon">📍</span></div>

    <p class="big-name" style="font-size:26px; margin-bottom:4px;">{{ $nama_venue }}</p>
    <p class="sub-text">{!! $alamat_venue !!}</p>

    <div class="maps-wrap">
      <iframe src="{{ $maps_embed }}" loading="lazy"></iframe>
    </div>

    <a href="{{ $maps_link }}" target="_blank" class="maps-btn">
      🗺 Buka di Google Maps
    </a>
  </div>
</section>

{{-- ===== GALERI ===== --}}
<section id="galeri" class="section">
  <div class="card scroll-reveal">
    <span class="label">Galeri Foto</span>
    <p class="section-title">Momen Berharga</p>
    <div class="divider"><span class="divider-icon">✦</span></div>

    <div class="gallery-grid">
      @foreach ($galeri as $index => $item)
        <div class="gallery-item{{ $index === 0 ? ' featured' : '' }}">
          <img src="{{ asset($item->path_foto) }}" alt="{{ $item->caption ?? 'Galeri ' . ($index + 1) }}">
        </div>
      @endforeach
    </div>

    <p class="sub-text" style="margin-top:16px; font-size:12px;">
      Setiap foto menyimpan cerita cinta yang tak terlupakan ✦
    </p>
  </div>
</section>

{{-- ===== LOVE STORY ===== --}}
<section id="story" class="section">
  <div class="card scroll-reveal">
    <span class="label">Our Love Story</span>
    <p class="section-title">Perjalanan Cinta</p>
    <div class="divider"><span class="divider-icon">💌</span></div>

    <div style="margin-top:28px; text-align:left;">
      @foreach ($love_story as $item)
        @php
          $warna_style = isset($item->warna) && $item->warna === 'rose'
            ? 'border-left-color:var(--rose);'
            : '';
          $warna_tahun = isset($item->warna) && $item->warna === 'rose'
            ? 'color:var(--rose);'
            : '';
        @endphp
        <div class="story-item" style="{{ $warna_style }}">
          <div class="story-year" style="{{ $warna_tahun }}">{{ $item->tahun }}</div>
          <div class="story-text">
            <h4>{{ $item->judul }}</h4>
            <p>{{ $item->isi }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== UCAPAN ===== --}}
<section id="ucapan" class="section">
  <div class="card scroll-reveal">
    <span class="label">Doa &amp; Ucapan</span>
    <p class="section-title">Sampaikan Doamu</p>
    <div class="divider"><span class="divider-icon">✦</span></div>

    <div class="ucapan-list" id="ucapanList"></div>

    <div class="ucapan-form">
      <div style="font-size:12px; letter-spacing:2px; text-transform:uppercase; color:var(--gold-dark); margin-bottom:14px;">Tinggalkan Ucapan</div>
      <input type="text" id="ucapanNama"
        placeholder="Nama Anda"
        value="{{ $nama_tamu !== 'Tamu Undangan' ? $nama_tamu : '' }}"/>
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

{{-- ===== PENUTUP ===== --}}
<section id="penutup" class="section">
  <div class="card scroll-reveal" style="text-align:center;">
    <span class="ornament">✦ ✦ ✦</span>
    <div class="display-name" style="font-size:clamp(44px,10vw,60px); letter-spacing:6px;">
      {{ substr($nama_depan_pria, 0, 1) }} &amp; {{ substr($nama_depan_wanita, 0, 1) }}
    </div>
    <p class="sub-text" style="font-size:18px; margin-top:4px;">
      {{ $nama_depan_pria }} &amp; {{ $nama_depan_wanita }}
    </p>
    <div class="divider"><span class="divider-icon">♥</span></div>

    @php
      $penutupUrl = ($pengaturan && $pengaturan->foto_penutup) ? asset('storage/' . $pengaturan->foto_penutup) : asset('images/penutup1.png');
    @endphp
    <img src="{{ $penutupUrl }}" alt="Foto Mempelai"
         style="width:180px;height:180px;object-fit:cover;border-radius:50%;border:4px solid var(--gold);box-shadow:0 0 0 8px rgba(201,169,110,0.15);margin:24px auto;display:block;">

    <p class="body-text" style="margin:20px auto;">
      Semoga pernikahan ini menjadi awal perjalanan yang penuh keberkahan,
      kebahagiaan, dan cinta yang abadi hingga akhir hayat.
    </p>

    <p style="font-size:13px; color:var(--gold); letter-spacing:2px; margin:20px 0;">
      {{ $tanggal_acara }}
    </p>

    <div style="background:linear-gradient(135deg,rgba(201,169,110,0.1),rgba(185,110,130,0.08));border-radius:14px;padding:20px;margin-top:16px;">
      <p style="font-family:'Cormorant Garamond',serif;font-size:17px;font-style:italic;color:var(--brown-light);">
        Wassalamu'alaikum Warahmatullahi Wabarakatuh
      </p>
      <p style="font-size:13px;color:var(--text-light);margin-top:8px;">
        Hormat kami, Keluarga Besar {{ $nama_depan_pria }} &amp; {{ $nama_depan_wanita }}
      </p>
    </div>

    <p id="pesanRsvp" style="margin-top:12px;font-size:14px;color:var(--gold-dark);font-style:italic;"></p>
  </div>
</section>

<button class="music-btn" id="musicBtn" onclick="toggleMusic()" title="Musik">🎵</button>
<audio id="bgMusic" loop>
  <source src="{{ asset('audio/audio2.mpeg') }}" type="audio/mpeg">
</audio>

<script src="{{ asset('js/undangan.js') }}"></script>
<script>
(function() {
  {{-- Inject nama tamu dari server ke JS dengan aman --}}
  const namaTamuPHP = @json($nama_tamu);
  window.countdownTarget = @json($hari_h);
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
