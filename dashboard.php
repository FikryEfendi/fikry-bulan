<?php
// ─── KONFIGURASI DASHBOARD ───
$page_title   = "Dashboard — Undangan Fikry & Bulan";
$nama_pria    = "Muhammad Fikry Efendi";
$nama_wanita  = "Bulan Hijarati A";
$ortu_pria    = "Bapak Harry & Ibu Ginny";
$ortu_wanita  = "Bapak Ron & Ibu Hermione";
$tanggal      = "Sabtu, 14 Februari 2027";
$jam_akad     = "08:00 WIB";
$jam_resepsi  = "11:00 WIB - Selesai";
$dress_code   = "Pastel — Nude — Earthy Tone";
$nama_venue   = "Universitas Riau, Kampus Bina Widya, Jl. Bangau Sakti KM. 12,5, Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293";

// Daftar tamu awal (data statis PHP, nanti bisa sinkron dari database)
$daftar_tamu_awal = ["Farhan", "Budi Santoso", "Sari Dewi"];

// Checklist persiapan pernikahan
$checklist = [
    ["text" => "Booking venue",            "done" => true],
    ["text" => "Catering & dekorasi",      "done" => true],
    ["text" => "Undangan terkirim",        "done" => true],
    ["text" => "Baju pengantin fitting",   "done" => false],
    ["text" => "Foto pre-wedding",         "done" => false],
    ["text" => "Konfirmasi MC & hiburan",  "done" => false],
    ["text" => "Seserahan & mas kawin",    "done" => true],
    ["text" => "Honeymoon booking",        "done" => false],
];

// Hitung jumlah checklist yang sudah selesai
$checklist_selesai = count(array_filter($checklist, fn($c) => $c['done']));
$checklist_total   = count($checklist);

// Tanggal hari H untuk hitung mundur di sisi server
$hari_h        = new DateTime('2027-02-14 08:00:00');
$sekarang      = new DateTime();
$selisih       = $sekarang->diff($hari_h);
$sisa_hari_php = ($selisih->invert === 0) ? $selisih->days : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?></title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Cinzel:wght@400;600&family=Lato:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="dashboard.css">
</head>
<body>

<!-- ─── LOGIN OVERLAY ─── -->
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
      <a href="index.php" style="color:var(--text-light);">✕ Batal</a>
    </p>
  </div>
</div>

<!-- ─── DASHBOARD WRAP ─── -->
<div class="dashboard-wrap" id="dashboardWrap">

  <!-- HEADER -->
  <div class="dashboard-header">
    <div style="display:flex;align-items:center;gap:14px;">
      <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>
      <h1>Wedding Dashboard</h1>
    </div>
    <div class="dash-nav">
      <button onclick="showDashTab('overview')" class="active" id="btn-overview">Overview</button>
      <button onclick="showDashTab('edit')" id="btn-edit">Edit Undangan</button>
      <button onclick="showDashTab('tamu')" id="btn-tamu">Data Tamu</button>
      <button onclick="showDashTab('link')" id="btn-link">Generator Link</button>
      <button class="btn-close" onclick="window.location.href='index.php'">✕ Tutup</button>
    </div>
  </div>

  <!-- SIDEBAR OVERLAY (mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

  <div class="dashboard-body">

    <!-- SIDEBAR -->
    <nav class="dash-sidebar" id="dashSidebar">
      <a href="#" class="active" id="side-overview" onclick="showDashTab('overview');return false;"><span class="menu-icon">📊</span> Overview</a>
      <a href="#" id="side-edit" onclick="showDashTab('edit');return false;"><span class="menu-icon">✏️</span> Edit Undangan</a>
      <a href="#" id="side-tamu" onclick="showDashTab('tamu');return false;"><span class="menu-icon">👥</span> Data Tamu</a>
      <a href="#" id="side-link" onclick="showDashTab('link');return false;"><span class="menu-icon">🔗</span> Generator Link</a>
      <a href="index.php" style="margin-top:12px;color:#c0392b;"><span class="menu-icon">🔙</span> Kembali</a>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="dash-content">

      <!-- ══ TAB: OVERVIEW ══ -->
      <div id="tab-overview">
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
            <div class="stat-num" id="stat-tidak" style="color:var(--rose);">1</div>
            <div class="stat-lbl">Tidak Hadir</div>
          </div>
          <div class="stat-card">
            <div class="stat-num" id="stat-pending" style="color:var(--brown-light);">0</div>
            <div class="stat-lbl">Belum Konfirmasi</div>
          </div>
        </div>

        <div class="dash-panel">
          <h3>⏳ Hitung Mundur</h3>
          <?php
            // PHP menghitung sisa hari dan menampilkan info statis
            if ($sisa_hari_php > 0) {
              echo '<p style="font-family:\'Cormorant Garamond\',serif;font-size:clamp(22px,4vw,28px);color:var(--brown);" id="dash-countdown">' . $sisa_hari_php . ' hari lagi menuju hari H</p>';
            } else {
              echo '<p style="font-family:\'Cormorant Garamond\',serif;font-size:clamp(22px,4vw,28px);color:var(--rose);" id="dash-countdown">Hari H telah tiba! 🎉</p>';
            }
          ?>
          <p style="font-size:13px;color:var(--text-light);margin-top:6px;">
            <?php echo $tanggal; ?> | <?php echo $nama_venue; ?>
          </p>
        </div>

        <div class="dash-panel">
          <h3>📋 Checklist Persiapan
            <span style="font-size:11px;font-family:'Lato',sans-serif;font-weight:400;letter-spacing:0;color:var(--text-light);margin-left:8px;">
              <?php echo $checklist_selesai . '/' . $checklist_total; ?> selesai
            </span>
          </h3>
          <?php
            // Loop PHP untuk render checklist
            foreach ($checklist as $i => $item) {
              $checked  = $item['done'] ? 'checked' : '';
              $style    = $item['done']
                ? 'color:var(--text-light);text-decoration:line-through;'
                : 'color:var(--text);';
              echo '<div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid rgba(201,169,110,0.1);">';
              echo '  <input type="checkbox" ' . $checked . ' onchange="checklistItems[' . $i . '].done=this.checked;renderChecklist()" style="width:16px;height:16px;accent-color:var(--gold);">';
              echo '  <span style="font-size:14px;' . $style . '">' . $item['text'] . '</span>';
              echo '</div>';
            }
          ?>
        </div>
      </div>

      <!-- ══ TAB: EDIT UNDANGAN ══ -->
      <div id="tab-edit" style="display:none;">
        <div class="dash-panel">
          <h3>✏️ Edit Data Mempelai</h3>
          <div class="edit-row">
            <div>
              <div class="edit-field">
                <label>Nama Pria</label>
                <input type="text" id="e-namaPria" value="<?php echo $nama_pria; ?>">
              </div>
              <div class="edit-field">
                <label>Putra dari</label>
                <input type="text" id="e-ortuPria" value="<?php echo $ortu_pria; ?>">
              </div>
            </div>
            <div>
              <div class="edit-field">
                <label>Nama Wanita</label>
                <input type="text" id="e-namaWanita" value="<?php echo $nama_wanita; ?>">
              </div>
              <div class="edit-field">
                <label>Putri dari</label>
                <input type="text" id="e-ortuWanita" value="<?php echo $ortu_wanita; ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="dash-panel">
          <h3>📅 Edit Waktu & Lokasi</h3>
          <div class="edit-row">
            <div>
              <div class="edit-field">
                <label>Tanggal Akad</label>
                <input type="text" id="e-tanggal" value="<?php echo $tanggal; ?>">
              </div>
              <div class="edit-field">
                <label>Jam Akad</label>
                <input type="text" id="e-akad" value="<?php echo $jam_akad; ?>">
              </div>
            </div>
            <div>
              <div class="edit-field">
                <label>Jam Resepsi</label>
                <input type="text" id="e-resepsi" value="<?php echo $jam_resepsi; ?>">
              </div>
              <div class="edit-field">
                <label>Dress Code</label>
                <input type="text" id="e-dresscode" value="<?php echo $dress_code; ?>">
              </div>
            </div>
          </div>
          <div class="edit-field">
            <label>Alamat Lokasi</label>
            <textarea id="e-lokasi"><?php echo $nama_venue; ?></textarea>
          </div>
        </div>

        <div class="dash-panel">
          <h3>👤 Nama Tamu Undangan</h3>
          <div class="edit-field">
            <label>Nama Tamu (Statis)</label>
            <input type="text" id="e-namaTamu" value="Farhan" placeholder="Nama tamu untuk link statis">
          </div>
          <button class="btn-gold" onclick="saveEdits()">💾 Simpan Perubahan</button>
          <p id="saveMsg" style="display:none;color:var(--gold-dark);margin-top:12px;font-size:14px;font-style:italic;">✓ Perubahan berhasil disimpan!</p>
        </div>
      </div>

      <!-- ══ TAB: DATA TAMU ══ -->
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
                  <th>Waktu</th>
                  <th>Aksi</th> </tr>
              </thead>
              <tbody id="tamuBody"></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ══ TAB: GENERATOR LINK ══ -->
      <div id="tab-link" style="display:none;">
        <div class="dash-panel">
          <h3>🔗 Generator Link Per Tamu</h3>
          <p style="font-size:13px;color:var(--text-light);margin-bottom:16px;">
            Setiap tamu mendapat link undangan unik yang otomatis menampilkan namanya.
          </p>

          <!-- Daftar tamu awal dari PHP -->
          <?php if (!empty($daftar_tamu_awal)): ?>
          <div style="background:rgba(201,169,110,0.06);border:1px solid rgba(201,169,110,0.2);border-radius:10px;padding:14px 16px;margin-bottom:16px;">
            <p style="font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:var(--gold-dark);margin-bottom:10px;">
              Tamu dari server (<?php echo count($daftar_tamu_awal); ?> orang)
            </p>
            <?php foreach ($daftar_tamu_awal as $tamu_php): ?>
              <p style="font-size:13px;color:var(--text);padding:4px 0;border-bottom:1px solid rgba(201,169,110,0.1);">
                ✦ <?php echo $tamu_php; ?>
              </p>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <!-- Tambah tamu -->
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
            <p>💡 <strong>Format link:</strong> <code style="font-size:12px;">index.php?tamu=NamaTamu</code></p>
            <p style="margin-top:6px;">Nama tamu akan otomatis muncul di bagian cover dan pengantar undangan.</p>
          </div>
        </div>
      </div>

    </div><!-- /dash-content -->
  </div><!-- /dashboard-body -->
</div><!-- /dashboard-wrap -->
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
<script>
// Data tamu awal dari PHP diteruskan ke JavaScript
const tamuDariPHP = <?php echo json_encode($daftar_tamu_awal); ?>;
</script>
<script src="dashboard.js"></script>
</body>
</html>