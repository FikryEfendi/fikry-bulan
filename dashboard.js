// ─── AUTH ───
const ADMIN_USER = 'admin';
const ADMIN_PASS = 'admin123';

function doLogin() {
  const user = document.getElementById('loginUser').value;
  const pass = document.getElementById('loginPass').value;
  const err = document.getElementById('loginErr');
  
  if (user === ADMIN_USER && pass === ADMIN_PASS) {
    document.getElementById('loginOverlay').classList.remove('show');
    document.getElementById('loginUser').value = '';
    document.getElementById('loginPass').value = '';
    err.style.display = 'none';
    document.getElementById('dashboardWrap').classList.add('active');
    updateStats();
    updateDashCountdown();
  } else {
    err.style.display = 'block';
    document.getElementById('loginPass').value = '';
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('loginOverlay').classList.add('show');
  
  // Tombol enter pindah ke password & login
  document.getElementById('loginUser').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') document.getElementById('loginPass').focus();
  });
  document.getElementById('loginPass').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') doLogin();
  });

  // Tarik data dari database saat halaman pertama kali dimuat
  fetchUcapan();
  renderChecklist();
});

// ─── COUNTDOWN (for dashboard) ───
function updateDashCountdown() {
  const target = new Date('2027-02-14T08:00:00');
  const now = new Date();
  const diff = target - now;
  const d = Math.max(0, Math.floor(diff / 86400000));
  const el = document.getElementById('dash-countdown');
  if (el) el.textContent = `${d} hari lagi menuju hari H`;
}
setInterval(updateDashCountdown, 60000);

// ─── DATA (Sync via DATABASE API) ───
let ucapanData = []; // Array utama untuk semua data

async function fetchUcapan() {
  try {
    const response = await fetch('api_tamu.php?action=get');
    ucapanData = await response.json();
    
    // Tiap kali narik data, render ulang kedua tabel dan stats
    renderTamuTable();
    renderLinkTable();
    updateStats();
  } catch (error) {
    console.error('Gagal mengambil data:', error);
  }
}

// ─── STATS ───
function updateStats() {
  const total = ucapanData.length;
  const hadir = ucapanData.filter(u => u.status === 'hadir').length;
  const tidak = ucapanData.filter(u => u.status === 'tidak').length;
  const pending = total - hadir - tidak;
  
  document.getElementById('stat-total').textContent = total;
  document.getElementById('stat-hadir').textContent = hadir;
  document.getElementById('stat-tidak').textContent = tidak;
  document.getElementById('stat-pending').textContent = pending;
}

// ─── TABS ───
const ALL_TABS = ['overview', 'edit', 'tamu', 'link'];

function showDashTab(tab) {
  ALL_TABS.forEach(t => {
    const panel = document.getElementById('tab-' + t);
    const btn = document.getElementById('btn-' + t);
    const sideLink = document.getElementById('side-' + t);
    if (panel) panel.style.display = t === tab ? 'block' : 'none';
    if (btn) btn.className = t === tab ? 'active' : '';
    if (sideLink) sideLink.className = t === tab ? 'active' : '';
  });
  closeSidebar();
}

// ─── TAB: TAMU TABLE ───
function renderTamuTable() {
  const tbody = document.getElementById('tamuBody');
  if (!tbody) return;
  tbody.innerHTML = '';
  
  ucapanData.forEach((t, i) => {
    const badgeClass = t.status === 'hadir' ? 'badge-hadir' : t.status === 'tidak' ? 'badge-tidak' : 'badge-belum';
    const badgeText = t.status === 'hadir' ? '✓ Hadir' : t.status === 'tidak' ? '✗ Tidak Hadir' : '— Belum';
    
    // Hindari error jika t.pesan null dari DB
    const pesanAman = t.pesan ? t.pesan : ''; 

    tbody.innerHTML += `<tr>
      <td style="color:var(--gold-dark);font-weight:600;">${i+1}</td>
      <td style="font-weight:600;">${t.nama}</td>
      <td style="max-width:260px;font-style:italic;color:var(--text-light);">${pesanAman.substring(0,80)}${pesanAman.length>80?'…':''}</td>
      <td><span class="badge ${badgeClass}">${badgeText}</span></td>
      <td style="color:var(--text-light);font-size:12px;">${t.waktu}</td>
      <td>
        <button class="btn-sm btn-sm-gold" onclick="bukaEdit(${i})">✏️ Edit</button>
        <button class="btn-sm btn-sm-red" style="margin-top:4px;" onclick="hapusTamu(${t.id})">🗑️ Hapus</button>
      </td>
    </tr>`;
  });
}

// ─── TAB: LINK GENERATOR ───
function renderLinkTable() {
  const tbody = document.getElementById('linkTableBody');
  if (!tbody) return;
  
  const baseUrl = "http://localhost/DPW-praktikum-kelas-A/index.php";

  tbody.innerHTML = ucapanData.map((t) => {
    const link = `${baseUrl}?tamu=${encodeURIComponent(t.nama.trim())}`;
    return `<tr>
      <td style="font-weight:600;">${t.nama}</td>
      <td style="font-family:monospace;font-size:12px;color:var(--text-light);word-break:break-all;">
        <a href="${link}" target="_blank" style="color:inherit; text-decoration:none;">${link}</a>
      </td>
      <td>
        <button class="btn-sm btn-sm-gold" onclick="copyLink('${encodeURIComponent(link)}')">📋 Salin</button>
        <button class="btn-sm btn-sm-red" style="margin-top:4px;" onclick="hapusTamu(${t.id})">✕</button>
      </td>
    </tr>`;
  }).join('');
}

// ─── CRUD: TAMBAH DATA ───
async function tambahTamu() {
  const input = document.getElementById('namaTamuBaru');
  if (!input) return;
  const nama = input.value.trim();
  
  if (!nama) {
    alert("Masukkan nama tamu!");
    return;
  }

  await fetch('api_tamu.php?action=add', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ nama: nama })
  });

  input.value = ''; 
  fetchUcapan(); 
}

// ─── CRUD: EDIT DATA ───
function bukaEdit(index) {
  const tamu = ucapanData[index];
  
  // Mengisi data modal dari array yang terpilih
  document.getElementById('edit-index').value = tamu.id; 
  document.getElementById('edit-nama').value = tamu.nama;
  document.getElementById('edit-status').value = tamu.status;
  
  document.getElementById('modalEditTamu').classList.add('show');
}

function tutupEdit() {
  document.getElementById('modalEditTamu').classList.remove('show');
}

async function simpanEdit() {
  const idTamu = document.getElementById('edit-index').value;
  const namaBaru = document.getElementById('edit-nama').value;
  const statusBaru = document.getElementById('edit-status').value;

  if (namaBaru.trim() === '') {
    alert("Nama tidak boleh kosong!");
    return;
  }

  await fetch('api_tamu.php?action=update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: idTamu, nama: namaBaru, status: statusBaru })
  });

  tutupEdit();
  fetchUcapan(); 
}

// ─── CRUD: HAPUS DATA ───
async function hapusTamu(idTamu) {
  if (!confirm('Yakin ingin menghapus tamu ini dari database?')) return;

  await fetch('api_tamu.php?action=delete', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: idTamu })
  });

  fetchUcapan(); 
}

// ─── CHECKLIST ───
const checklistItems = [
  { text: 'Booking venue', done: true },
  { text: 'Catering & dekorasi', done: true },
  { text: 'Undangan terkirim', done: true },
  { text: 'Baju pengantin fitting', done: false },
  { text: 'Foto pre-wedding', done: false },
  { text: 'Konfirmasi MC & hiburan', done: false },
  { text: 'Seserahan & mas kawin', done: true },
  { text: 'Honeymoon booking', done: false },
];

function renderChecklist() {
  const el = document.getElementById('checklist');
  if (!el) return;
  el.innerHTML = checklistItems.map((item, i) => `
    <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid rgba(201,169,110,0.1);">
      <input type="checkbox" ${item.done ? 'checked' : ''} onchange="checklistItems[${i}].done=this.checked;renderChecklist()" style="width:16px;height:16px;accent-color:var(--gold);">
      <span style="font-size:14px;color:${item.done ? 'var(--text-light)' : 'var(--text)'};text-decoration:${item.done ? 'line-through' : 'none'};">${item.text}</span>
    </div>`).join('');
}

// ─── UTILITIES ───
function copyLink(encodedLink) {
  const link = decodeURIComponent(encodedLink);
  navigator.clipboard.writeText(link).then(() => {
    alert('Link berhasil disalin!');
  }).catch(() => {
    prompt('Salin link ini:', link);
  });
}

function saveEdits() {
  const msg = document.getElementById('saveMsg');
  if (msg) {
    msg.style.display = 'block';
    setTimeout(() => msg.style.display = 'none', 3000);
  }
}

// ─── EXPORT CSV ───
function exportCSV() {
  // Karena datanya pakai DB, kita looping dari ucapanData yang sudah di-fetch
  const rows = [['Nama','Pesan','Kehadiran','Waktu']];
  ucapanData.forEach(u => {
    const pesan = u.pesan ? u.pesan : '';
    rows.push([u.nama, pesan, u.status, u.waktu]);
  });
  
  const csv = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'data-tamu-undangan.csv';
  a.click();
}

// ─── SIDEBAR MOBILE ───
function toggleSidebar() {
  document.getElementById('dashSidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
  const sidebar = document.getElementById('dashSidebar');
  const overlay = document.getElementById('sidebarOverlay');
  if (sidebar) sidebar.classList.remove('open');
  if (overlay) overlay.classList.remove('show');
}