<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $page_title }}</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Cinzel:wght@400;600&family=Lato:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

{{-- ===== LOGIN OVERLAY ===== --}}
<div class="login-overlay" id="loginOverlay">
  <div class="login-box">
    <div style="font-size:40px;margin-bottom:12px;">💍</div>
    <h2>Dashboard</h2>
    <p>Masukkan username dan kata sandi untuk akses dashboard</p>

    <input type="text" class="login-input" id="loginUser" placeholder="Username" style="margin-bottom:8px;">
    <input type="password" class="login-input" id="loginPass" placeholder="Password">

    <p class="error-msg" id="loginErr">❌ Username atau Password salah. Coba lagi.</p>
    <button class="btn-gold" style="width:100%;margin-top:4px;" onclick="doLogin()">Masuk →</button>
    <p style="margin-top:14px;font-size:12px;color:var(--text-light);">
      <a href="{{ route('undangan') }}" style="color:var(--text-light);">✕ Batal</a>
    </p>
  </div>
</div>

{{-- ===== DASHBOARD WRAP ===== --}}
<div class="dashboard-wrap" id="dashboardWrap">

  {{-- HEADER --}}
  <div class="dashboard-header">
    <div style="display:flex;align-items:center;gap:14px;">
      <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>
      <h1>Wedding Dashboard</h1>
    </div>
    <div class="dash-nav">
      <button onclick="showDashTab('overview')" class="active" id="btn-overview">Overview</button>
      <button onclick="showDashTab('edit')" id="btn-edit">Edit Mempelai</button>
      <button onclick="showDashTab('acara')" id="btn-acara">Jadwal Acara</button>
      <button onclick="showDashTab('cerita')" id="btn-cerita">Love Story</button>
      <button onclick="showDashTab('galeri')" id="btn-galeri">Galeri Foto</button>
      <button onclick="showDashTab('tamu')" id="btn-tamu">Data Tamu</button>
      <button onclick="showDashTab('link')" id="btn-link">Generator Link</button>
      <button class="btn-close" onclick="window.location.href='{{ route('undangan') }}'">✕ Tutup</button>
    </div>
  </div>

  <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

  <div class="dashboard-body">

    {{-- SIDEBAR --}}
    <nav class="dash-sidebar" id="dashSidebar">
      <a href="#" class="active" id="side-overview" onclick="showDashTab('overview');return false;"><span class="menu-icon">📊</span> Overview</a>
      <a href="#" id="side-edit" onclick="showDashTab('edit');return false;"><span class="menu-icon">✏️</span> Edit Mempelai & Pengaturan</a>
      <a href="#" id="side-acara" onclick="showDashTab('acara');return false;"><span class="menu-icon">📅</span> Jadwal Acara</a>
      <a href="#" id="side-cerita" onclick="showDashTab('cerita');return false;"><span class="menu-icon">💌</span> Love Story</a>
      <a href="#" id="side-galeri" onclick="showDashTab('galeri');return false;"><span class="menu-icon">🖼️</span> Galeri Foto</a>
      <a href="#" id="side-tamu" onclick="showDashTab('tamu');return false;"><span class="menu-icon">👥</span> Data Tamu</a>
      <a href="#" id="side-link" onclick="showDashTab('link');return false;"><span class="menu-icon">🔗</span> Generator Link</a>
      <a href="{{ route('undangan') }}" style="margin-top:12px;color:#c0392b;"><span class="menu-icon">🔙</span> Kembali</a>
    </nav>

    <div class="dash-content">

      {{-- ===== TAB: OVERVIEW ===== --}}
      <div id="tab-overview">

        {{-- Stats Cards --}}
        <div class="stats-row">
          <div class="stat-card">
            <div class="stat-num" id="stat-total">0</div>
            <div class="stat-lbl">Total Undangan</div>
          </div>
          <div class="stat-card">
            <div class="stat-num" id="stat-hadir" style="color:var(--gold);">0</div>
            <div class="stat-lbl">Konfirmasi Hadir</div>
          </div>
          <div class="stat-card">
            <div class="stat-num" id="stat-tidak" style="color:var(--rose);">0</div>
            <div class="stat-lbl">Tidak Hadir</div>
          </div>
          <div class="stat-card">
            <div class="stat-num" id="stat-pending" style="color:var(--brown-light);">0</div>
            <div class="stat-lbl">Belum Konfirmasi</div>
          </div>
        </div>

        {{-- Countdown --}}
        <div class="dash-panel">
          <h3>⏳ Hitung Mundur</h3>
          @if ($sisa_hari > 0)
            <p style="font-family:'Cormorant Garamond',serif;font-size:clamp(22px,4vw,28px);color:var(--brown);" id="dash-countdown">
              {{ $sisa_hari }} hari lagi menuju hari H
            </p>
          @else
            <p style="font-family:'Cormorant Garamond',serif;font-size:clamp(22px,4vw,28px);color:var(--rose);" id="dash-countdown">
              Hari H telah tiba! 🎉
            </p>
          @endif
          <p style="font-size:13px;color:var(--text-light);margin-top:6px;">
            {{ $tanggal }} | {{ $nama_venue }}
          </p>
        </div>



      </div>{{-- /tab-overview --}}

      {{-- ===== TAB: EDIT UNDANGAN ===== --}}
      <div id="tab-edit" style="display:none;">
        <div class="dash-panel">
          <h3>⚙️ Pengaturan Umum</h3>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Judul Undangan</label>
            <input type="text" id="e-judulUndangan" value="{{ $pengaturan ? $pengaturan->judul_undangan : '' }}">
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Pengantar</label>
            <textarea id="e-pengantar">{{ $pengaturan ? $pengaturan->pengantar : '' }}</textarea>
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Dress Code</label>
            <input type="text" id="e-dresscode" value="{{ $pengaturan ? $pengaturan->dress_code : '' }}">
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Link Google Maps</label>
            <input type="text" id="e-mapsLink" value="{{ $pengaturan ? $pengaturan->maps_link : '' }}">
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Embed Google Maps (Iframe Src)</label>
            <textarea id="e-mapsEmbed">{{ $pengaturan ? $pengaturan->maps_embed : '' }}</textarea>
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Tanggal Acara Utama (YYYY-MM-DD)</label>
            <input type="date" id="e-tanggalAcara" value="{{ $pengaturan && $pengaturan->tanggal_acara ? \Carbon\Carbon::parse($pengaturan->tanggal_acara)->format('Y-m-d') : '' }}">
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Nama Venue Acara Utama</label>
            <input type="text" id="e-namaVenue" value="{{ $pengaturan ? $pengaturan->nama_venue : '' }}">
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Alamat Venue Acara Utama</label>
            <textarea id="e-alamatVenue">{{ $pengaturan ? $pengaturan->alamat_venue : '' }}</textarea>
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Foto Cover</label>
            <input type="file" id="e-fotoCover" accept="image/*">
            @if($pengaturan && $pengaturan->foto_cover)
              <p style="font-size:11px;color:var(--text-light);margin-top:4px;">Ada foto tersimpan.</p>
            @endif
          </div>
          <div class="edit-field" style="margin-bottom: 12px;">
            <label>Foto Penutup</label>
            <input type="file" id="e-fotoPenutup" accept="image/*">
            @if($pengaturan && $pengaturan->foto_penutup)
              <p style="font-size:11px;color:var(--text-light);margin-top:4px;">Ada foto tersimpan.</p>
            @endif
          </div>
          <h3>✏️ Edit Data Mempelai</h3>
          <div class="edit-row">
            <div>
              <div class="edit-field">
                <label>Nama Pria</label>
                <input type="text" id="e-namaPria" value="{{ $mempelaiPria ? $mempelaiPria->nama_lengkap : '' }}">
              </div>
              <div class="edit-field">
                <label>Nama Panggilan Pria</label>
                <input type="text" id="e-panggilanPria" value="{{ $mempelaiPria ? $mempelaiPria->nama_panggilan : '' }}">
              </div>
              <div class="edit-field">
                <label>Status Keluarga Pria</label>
                <input type="text" id="e-statusPria" value="{{ $mempelaiPria ? $mempelaiPria->status_keluarga : '' }}">
              </div>
              <div class="edit-field">
                <label>Nama Ayah Pria</label>
                <input type="text" id="e-ayahPria" value="{{ $mempelaiPria ? $mempelaiPria->nama_ayah : '' }}">
              </div>
              <div class="edit-field">
                <label>Nama Ibu Pria</label>
                <input type="text" id="e-ibuPria" value="{{ $mempelaiPria ? $mempelaiPria->nama_ibu : '' }}">
              </div>
              <div class="edit-field">
                <label>Foto Mempelai Pria</label>
                <input type="file" id="e-fotoPria" accept="image/*">
                @if($mempelaiPria && $mempelaiPria->foto)
                  <p style="font-size:11px;color:var(--text-light);margin-top:4px;">Ada foto tersimpan.</p>
                @endif
              </div>
            </div>
            <div>
              <div class="edit-field">
                <label>Nama Wanita</label>
                <input type="text" id="e-namaWanita" value="{{ $mempelaiWanita ? $mempelaiWanita->nama_lengkap : '' }}">
              </div>
              <div class="edit-field">
                <label>Nama Panggilan Wanita</label>
                <input type="text" id="e-panggilanWanita" value="{{ $mempelaiWanita ? $mempelaiWanita->nama_panggilan : '' }}">
              </div>
              <div class="edit-field">
                <label>Status Keluarga Wanita</label>
                <input type="text" id="e-statusWanita" value="{{ $mempelaiWanita ? $mempelaiWanita->status_keluarga : '' }}">
              </div>
              <div class="edit-field">
                <label>Nama Ayah Wanita</label>
                <input type="text" id="e-ayahWanita" value="{{ $mempelaiWanita ? $mempelaiWanita->nama_ayah : '' }}">
              </div>
              <div class="edit-field">
                <label>Nama Ibu Wanita</label>
                <input type="text" id="e-ibuWanita" value="{{ $mempelaiWanita ? $mempelaiWanita->nama_ibu : '' }}">
              </div>
              <div class="edit-field">
                <label>Foto Mempelai Wanita</label>
                <input type="file" id="e-fotoWanita" accept="image/*">
                @if($mempelaiWanita && $mempelaiWanita->foto)
                  <p style="font-size:11px;color:var(--text-light);margin-top:4px;">Ada foto tersimpan.</p>
                @endif
              </div>
            </div>
          </div>
        </div>
        <button class="btn-gold" onclick="saveEdits()">💾 Simpan Perubahan</button>
        <p id="saveMsg" style="display:none;color:var(--gold-dark);margin-top:12px;font-size:14px;font-style:italic;">
          ✓ Perubahan berhasil disimpan!
        </p>
      </div>

      {{-- ===== TAB: DATA TAMU ===== --}}

      {{-- ===== TAB: ACARA ===== --}}
      <div id="tab-acara" style="display:none;">
        <div class="dash-panel">
          <h3>📅 Jadwal Acara</h3>
          <p style="font-size:13px;color:var(--text-light);margin-bottom:16px;">
            Anda bisa menambah atau menghapus urutan acara di sini.
          </p>

          <div style="overflow-x:auto;">
            <table class="tamu-table">
              <thead>
                <tr>
                  <th>Nama Acara</th>
                  <th>Tanggal</th>
                  <th>Jam</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="acaraBody"></tbody>
            </table>
          </div>

          <button class="btn-gold" style="margin-top:16px;" onclick="bukaModalAcara()">+ Tambah Acara</button>
        </div>
      </div>

      {{-- ===== TAB: CERITA ===== --}}
      <div id="tab-cerita" style="display:none;">
        <div class="dash-panel">
          <h3>💌 Love Story (Perjalanan Cinta)</h3>
          <div style="overflow-x:auto;">
            <table class="tamu-table">
              <thead>
                <tr>
                  <th>Tahun</th>
                  <th>Judul</th>
                  <th>Isi Cerita</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="ceritaBody"></tbody>
            </table>
          </div>

          <button class="btn-gold" style="margin-top:16px;" onclick="bukaModalCerita()">+ Tambah Cerita</button>
        </div>
      </div>

      {{-- ===== TAB: GALERI ===== --}}
      <div id="tab-galeri" style="display:none;">
        <div class="dash-panel">
          <h3>🖼️ Galeri Foto</h3>
          <p style="font-size:13px;color:var(--text-light);margin-bottom:16px;">
            Anda bisa mengupload foto-foto untuk ditampilkan di galeri undangan.
          </p>

          <div style="display:flex; flex-wrap:wrap; gap:16px;" id="galeriGrid">
            {{-- Galeri items rendered here via JS --}}
          </div>

          <button class="btn-gold" style="margin-top:24px;" onclick="document.getElementById('modalGaleri').classList.add('show')">+ Upload Foto Baru</button>
        </div>
      </div>

      {{-- ===== TAB: DATA TAMU ===== --}}
      <div id="tab-tamu" style="display:none;">
        <div class="dash-panel">
          <h3 style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <span>👥 Daftar Tamu & Ucapan</span>
            <button class="btn-gold" style="padding:7px 18px;font-size:11px;" onclick="exportCSV()">⬇ Export CSV</button>
          </h3>
          <div style="overflow-x:auto;">
            <table class="tamu-table" id="tamuTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Pesan</th>
                  <th>Kehadiran</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tamuBody"></tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- ===== TAB: GENERATOR LINK ===== --}}
      <div id="tab-link" style="display:none;">
        <div class="dash-panel">
          <h3>🔗 Generator Link Per Tamu</h3>
          <p style="font-size:13px;color:var(--text-light);margin-bottom:16px;">
            Setiap tamu mendapat link undangan unik yang otomatis menampilkan namanya.
          </p>



          <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
            <input type="text" id="namaTamuBaru" placeholder="Nama tamu baru..."
              style="flex:1;min-width:200px;padding:10px 14px;border:1px solid rgba(201,169,110,0.35);border-radius:8px;font-size:14px;font-family:'Lato',sans-serif;outline:none;"
              onkeydown="if(event.key==='Enter')tambahTamu()">
            <button class="btn-gold" onclick="tambahTamu()">+ Tambah</button>
          </div>

          <div style="overflow-x:auto;">
            <table class="tamu-table">
              <thead>
                <tr>
                  <th>Nama Tamu</th>
                  <th>Link Undangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="linkTableBody"></tbody>
            </table>
          </div>

          <div class="generator-wrap" style="margin-top:20px;">
            <p>💡 <strong>Format link:</strong> <code style="font-size:12px;">/?tamu=NamaTamu</code></p>
            <p style="margin-top:6px;">Nama tamu akan otomatis muncul di bagian cover dan pengantar undangan.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- ===== MODAL EDIT TAMU ===== --}}
<div class="login-overlay" id="modalEditTamu">
  <div class="login-box" style="padding: 30px;">
    <h3 style="font-family:'Cinzel',serif; color:var(--brown); margin-bottom:16px;">✏️ Edit Data Tamu</h3>

    <input type="hidden" id="edit-index">

    <div style="text-align:left; margin-bottom:12px;">
      <label style="font-size:10px; letter-spacing:1.5px; text-transform:uppercase; color:var(--gold-dark);">Nama Tamu</label>
      <input type="text" id="edit-nama" class="login-input" style="margin-top:6px; margin-bottom:0;">
    </div>

    <div style="text-align:left; margin-bottom:24px;">
      <label style="font-size:10px; letter-spacing:1.5px; text-transform:uppercase; color:var(--gold-dark);">Status Kehadiran</label>
      <select id="edit-status" class="login-input" style="margin-top:6px; margin-bottom:0; background:white;">
        <option value="hadir">Hadir</option>
        <option value="tidak">Tidak Hadir</option>
        <option value="belum">Belum Konfirmasi</option>
      </select>
    </div>

    <div style="display:flex; gap:10px;">
      <button class="btn-gold" style="flex:1;" onclick="simpanEdit()">Selesai</button>
      <button class="btn-gold" style="flex:1; background:#e0e0e0; color:#333; box-shadow:none;" onclick="tutupEdit()">Batal</button>
    </div>
  </div>
</div>

{{-- ===== MODAL ACARA ===== --}}
<div class="login-overlay" id="modalAcara">
  <div class="login-box" style="padding: 30px;">
    <h3 style="font-family:'Cinzel',serif; color:var(--brown); margin-bottom:16px;">📅 Form Acara</h3>
    <input type="hidden" id="acara-id">
    <div style="text-align:left; margin-bottom:12px;">
      <label>Nama Acara</label>
      <input type="text" id="acara-nama" class="login-input" style="margin-top:6px; margin-bottom:0;">
    </div>
    <div style="text-align:left; margin-bottom:12px;">
      <label>Jam Mulai (HH:MM)</label>
      <input type="time" id="acara-mulai" class="login-input" style="margin-top:6px; margin-bottom:0;">
    </div>
    <div style="text-align:left; margin-bottom:24px;">
      <label>Jam Selesai (opsional)</label>
      <input type="time" id="acara-selesai" class="login-input" style="margin-top:6px; margin-bottom:0;">
    </div>
    <div style="display:flex; gap:10px;">
      <button class="btn-gold" style="flex:1;" onclick="simpanAcara()">Simpan</button>
      <button class="btn-gold" style="flex:1; background:#e0e0e0; color:#333; box-shadow:none;" onclick="document.getElementById('modalAcara').classList.remove('show')">Batal</button>
    </div>
  </div>
</div>

{{-- ===== MODAL CERITA ===== --}}
<div class="login-overlay" id="modalCerita">
  <div class="login-box" style="padding: 30px;">
    <h3 style="font-family:'Cinzel',serif; color:var(--brown); margin-bottom:16px;">💌 Form Cerita</h3>
    <input type="hidden" id="cerita-id">
    <div style="text-align:left; margin-bottom:12px;">
      <label>Tahun (Misal: 2021)</label>
      <input type="text" id="cerita-tahun" class="login-input" style="margin-top:6px; margin-bottom:0;">
    </div>
    <div style="text-align:left; margin-bottom:12px;">
      <label>Judul Cerita</label>
      <input type="text" id="cerita-judul" class="login-input" style="margin-top:6px; margin-bottom:0;">
    </div>
    <div style="text-align:left; margin-bottom:24px;">
      <label>Isi Cerita</label>
      <textarea id="cerita-isi" class="login-input" style="margin-top:6px; margin-bottom:0; height:80px;"></textarea>
    </div>
    <div style="display:flex; gap:10px;">
      <button class="btn-gold" style="flex:1;" onclick="simpanCerita()">Simpan</button>
      <button class="btn-gold" style="flex:1; background:#e0e0e0; color:#333; box-shadow:none;" onclick="document.getElementById('modalCerita').classList.remove('show')">Batal</button>
    </div>
  </div>
</div>

{{-- ===== MODAL GALERI ===== --}}
<div class="login-overlay" id="modalGaleri">
  <div class="login-box" style="padding: 30px;">
    <h3 style="font-family:'Cinzel',serif; color:var(--brown); margin-bottom:16px;">🖼️ Upload Foto Galeri</h3>
    <div style="text-align:left; margin-bottom:12px;">
      <label>Pilih Foto</label>
      <input type="file" id="galeri-file" class="login-input" accept="image/*" style="margin-top:6px; margin-bottom:0;">
    </div>
    <div style="text-align:left; margin-bottom:24px;">
      <label>Caption (Opsional)</label>
      <input type="text" id="galeri-caption" class="login-input" style="margin-top:6px; margin-bottom:0;">
    </div>
    <div style="display:flex; gap:10px;">
      <button class="btn-gold" style="flex:1;" onclick="simpanGaleri()">Upload</button>
      <button class="btn-gold" style="flex:1; background:#e0e0e0; color:#333; box-shadow:none;" onclick="document.getElementById('modalGaleri').classList.remove('show')">Batal</button>
    </div>
  </div>
</div>

{{-- ===== INJECT DATA PHP KE JS ===== --}}
<script>
  {{-- Base URL untuk generator link --}}
  const BASE_URL = "{{ url('/') }}";
  window.countdownTarget = @json($hari_h);
</script>
<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
