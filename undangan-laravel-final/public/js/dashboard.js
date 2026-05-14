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
  
  document.getElementById('loginUser').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') document.getElementById('loginPass').focus();
  });
  document.getElementById('loginPass').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') doLogin();
  });

  fetchUcapan();
  fetchAcara();
  fetchCerita();
  fetchGaleri();
});

let galeriData = [];

async function fetchGaleri() {
  try {
    const res = await fetch('/api/galeri');
    galeriData = await res.json();
    renderGaleriGrid();
  } catch(e) { console.error('Gagal memuat galeri', e); }
}

function renderGaleriGrid() {
  const grid = document.getElementById('galeriGrid');
  if (!grid) return;
  grid.innerHTML = galeriData.map(g => `
    <div style="position:relative; width:150px; height:150px; border-radius:8px; overflow:hidden; border:1px solid rgba(201,169,110,0.3);">
      <img src="${BASE_URL}/${g.path_foto}" style="width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.6); color:white; font-size:11px; padding:4px; text-align:center; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${g.caption || '-'}</div>
      <button onclick="hapusGaleri(${g.id})" style="position:absolute; top:4px; right:4px; background:var(--rose); color:white; border:none; border-radius:50%; width:24px; height:24px; cursor:pointer; font-size:10px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 4px rgba(0,0,0,0.3);">✕</button>
    </div>
  `).join('');
}

async function simpanGaleri() {
  const fileInput = document.getElementById('galeri-file');
  const file = fileInput.files[0];
  if (!file) {
    alert("Pilih foto terlebih dahulu!");
    return;
  }

  const formData = new FormData();
  formData.append('foto', file);
  formData.append('caption', document.getElementById('galeri-caption').value);

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  await fetch('/api/galeri/add', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    body: formData
  });

  document.getElementById('modalGaleri').classList.remove('show');
  fileInput.value = '';
  document.getElementById('galeri-caption').value = '';
  fetchGaleri();
}

async function hapusGaleri(id) {
  if(!confirm('Hapus foto ini?')) return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  await fetch('/api/galeri/delete', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify({ id })
  });
  fetchGaleri();
}

function updateDashCountdown() {
  const target = new Date(window.countdownTarget || '2027-02-14T08:00:00');
  const now = new Date();
  const diff = target - now;
  const d = Math.max(0, Math.floor(diff / 86400000));
  const el = document.getElementById('dash-countdown');
  if (el) el.textContent = `${d} hari lagi menuju hari H`;
}
setInterval(updateDashCountdown, 60000);

let ucapanData = [];

async function fetchUcapan() {
  try {
    const response = await fetch('/api/tamu');
    ucapanData = await response.json();
    
    renderTamuTable();
    renderLinkTable();
    updateStats();
  } catch (error) {
    console.error('Gagal mengambil data tamu:', error);
  }
}

let acaraData = [];
let ceritaData = [];

async function fetchAcara() {
  try {
    const res = await fetch('/api/acara');
    acaraData = await res.json();
    renderAcaraTable();
  } catch(e) { console.error('Gagal memuat acara', e); }
}

async function fetchCerita() {
  try {
    const res = await fetch('/api/cerita');
    ceritaData = await res.json();
    renderCeritaTable();
  } catch(e) { console.error('Gagal memuat cerita', e); }
}

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

const ALL_TABS = ['overview', 'edit', 'acara', 'cerita', 'galeri', 'tamu', 'link'];

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

function renderTamuTable() {
  const tbody = document.getElementById('tamuBody');
  if (!tbody) return;
  tbody.innerHTML = '';
  
  ucapanData.forEach((t, i) => {
    const badgeClass = t.status === 'hadir' ? 'badge-hadir' : t.status === 'tidak' ? 'badge-tidak' : 'badge-belum';
    const badgeText = t.status === 'hadir' ? '✓ Hadir' : t.status === 'tidak' ? '✗ Tidak Hadir' : '-';
    
    const pesanAman = t.pesan ? t.pesan : ''; 

    tbody.innerHTML += `<tr>
      <td style="color:var(--gold-dark);font-weight:600;">${i+1}</td>
      <td style="font-weight:600;">${t.nama}</td>
      <td style="max-width:260px;font-style:italic;color:var(--text-light);">${pesanAman.substring(0,80)}${pesanAman.length>80?'…':''}</td>
      <td><span class="badge ${badgeClass}">${badgeText}</span></td>
      <td>
        <button class="btn-sm btn-sm-gold" onclick="bukaEdit(${i})">✏️ Edit</button>
        <button class="btn-sm btn-sm-red" style="margin-top:4px;" onclick="hapusTamu(${t.id})">🗑️ Hapus</button>
      </td>
    </tr>`;
  });
}

function renderAcaraTable() {
  const tbody = document.getElementById('acaraBody');
  if (!tbody) return;
  tbody.innerHTML = acaraData.map((a, i) => `<tr>
    <td><strong>${a.nama_acara}</strong></td>
    <td>${a.jam_mulai} ${a.jam_selesai ? '- '+a.jam_selesai : ''}</td>
    <td>
      <button class="btn-sm btn-sm-gold" onclick="bukaModalAcara(${i})">✏️</button>
      <button class="btn-sm btn-sm-red" onclick="hapusAcara(${a.id})">🗑️</button>
    </td>
  </tr>`).join('');
}

function bukaModalAcara(index = -1) {
  const modal = document.getElementById('modalAcara');
  if (index >= 0) {
    const a = acaraData[index];
    document.getElementById('acara-id').value = a.id;
    document.getElementById('acara-nama').value = a.nama_acara;
    document.getElementById('acara-mulai').value = a.jam_mulai || '';
    document.getElementById('acara-selesai').value = a.jam_selesai || '';
  } else {
    document.getElementById('acara-id').value = '';
    document.getElementById('acara-nama').value = '';
    document.getElementById('acara-mulai').value = '';
    document.getElementById('acara-selesai').value = '';
  }
  modal.classList.add('show');
}

async function simpanAcara() {
  const id = document.getElementById('acara-id').value;
  const data = {
    id: id || null,
    nama_acara: document.getElementById('acara-nama').value,
    jam_mulai: document.getElementById('acara-mulai').value,
    jam_selesai: document.getElementById('acara-selesai').value,
  };
  const url = id ? '/api/acara/update' : '/api/acara/add';
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify(data)
  });
  document.getElementById('modalAcara').classList.remove('show');
  fetchAcara();
}

async function hapusAcara(id) {
  if(!confirm('Hapus acara ini?')) return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  await fetch('/api/acara/delete', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify({ id })
  });
  fetchAcara();
}

function renderLinkTable() {
  const tbody = document.getElementById('linkTableBody');
  if (!tbody) return;
  
  const baseUrl = window.location.origin + "/";

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

async function tambahTamu() {
  const input = document.getElementById('namaTamuBaru');
  if (!input) return;
  const nama = input.value.trim();
  
  if (!nama) {
    alert("Masukkan nama tamu!");
    return;
  }

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const response = await fetch('/api/tamu/add-admin', {
      method: 'POST',
      headers: { 
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({ nama: nama })
    });

    if (!response.ok) {
      const errorData = await response.json();
      console.error("Gagal tambah tamu:", errorData);
      alert("Gagal menyimpan data! Cek console browser.");
      return;
    }

    input.value = ''; 
    fetchUcapan(); 

  } catch (error) {
    console.error("Terjadi kesalahan jaringan:", error);
    alert("Terjadi kesalahan jaringan.");
  }
}

function bukaEdit(index) {
  const tamu = ucapanData[index];
  
  document.getElementById('edit-index').value = tamu.id; 
  document.getElementById('edit-nama').value = tamu.nama;
  document.getElementById('edit-status').value = tamu.status;
  
  document.getElementById('modalEditTamu').classList.add('show');
}

function tutupEdit() {
  document.getElementById('modalEditTamu').classList.remove('show');
}

function renderCeritaTable() {
  const tbody = document.getElementById('ceritaBody');
  if (!tbody) return;
  tbody.innerHTML = ceritaData.map((c, i) => `<tr>
    <td><strong>${c.tahun}</strong></td>
    <td>${c.judul}</td>
    <td>${c.isi.substring(0, 50)}...</td>
    <td>
      <button class="btn-sm btn-sm-gold" onclick="bukaModalCerita(${i})">✏️</button>
      <button class="btn-sm btn-sm-red" onclick="hapusCerita(${c.id})">🗑️</button>
    </td>
  </tr>`).join('');
}

function bukaModalCerita(index = -1) {
  const modal = document.getElementById('modalCerita');
  if (index >= 0) {
    const c = ceritaData[index];
    document.getElementById('cerita-id').value = c.id;
    document.getElementById('cerita-tahun').value = c.tahun;
    document.getElementById('cerita-judul').value = c.judul;
    document.getElementById('cerita-isi').value = c.isi;
  } else {
    document.getElementById('cerita-id').value = '';
    document.getElementById('cerita-tahun').value = '';
    document.getElementById('cerita-judul').value = '';
    document.getElementById('cerita-isi').value = '';
  }
  modal.classList.add('show');
}

async function simpanCerita() {
  const id = document.getElementById('cerita-id').value;
  const data = {
    id: id || null,
    tahun: document.getElementById('cerita-tahun').value,
    judul: document.getElementById('cerita-judul').value,
    isi: document.getElementById('cerita-isi').value,
  };
  const url = id ? '/api/cerita/update' : '/api/cerita/add';
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify(data)
  });
  document.getElementById('modalCerita').classList.remove('show');
  fetchCerita();
}

async function hapusCerita(id) {
  if(!confirm('Hapus cerita ini?')) return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  await fetch('/api/cerita/delete', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify({ id })
  });
  fetchCerita();
}

async function simpanEdit() {
  const idTamu = document.getElementById('edit-index').value;
  const namaBaru = document.getElementById('edit-nama').value;
  const statusBaru = document.getElementById('edit-status').value;

  if (namaBaru.trim() === '') {
    alert("Nama tidak boleh kosong!");
    return;
  }

  await fetch('/api/tamu/update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: idTamu, nama: namaBaru, status: statusBaru })
  });

  tutupEdit();
  fetchUcapan(); 
}

async function hapusTamu(idTamu) {
  if (!confirm('Yakin ingin menghapus tamu ini dari database?')) return;

  await fetch('/api/tamu/delete', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: idTamu })
  });

  fetchUcapan(); 
}



function copyLink(encodedLink) {
  const link = decodeURIComponent(encodedLink);
  navigator.clipboard.writeText(link).then(() => {
    alert('Link berhasil disalin!');
  }).catch(() => {
    prompt('Salin link ini:', link);
  });
}

async function saveEdits() {
  const formData = new FormData();
  formData.append('namaPria', document.getElementById('e-namaPria').value);
  formData.append('panggilanPria', document.getElementById('e-panggilanPria').value);
  formData.append('statusPria', document.getElementById('e-statusPria').value);
  formData.append('ayahPria', document.getElementById('e-ayahPria').value);
  formData.append('ibuPria', document.getElementById('e-ibuPria').value);

  formData.append('namaWanita', document.getElementById('e-namaWanita').value);
  formData.append('panggilanWanita', document.getElementById('e-panggilanWanita').value);
  formData.append('statusWanita', document.getElementById('e-statusWanita').value);
  formData.append('ayahWanita', document.getElementById('e-ayahWanita').value);
  formData.append('ibuWanita', document.getElementById('e-ibuWanita').value);

  formData.append('judulUndangan', document.getElementById('e-judulUndangan')?.value || '');
  formData.append('pengantar', document.getElementById('e-pengantar')?.value || '');
  formData.append('dresscode', document.getElementById('e-dresscode')?.value || '');
  formData.append('mapsLink', document.getElementById('e-mapsLink')?.value || '');
  formData.append('mapsEmbed', document.getElementById('e-mapsEmbed')?.value || '');
  formData.append('tanggalAcara', document.getElementById('e-tanggalAcara')?.value || '');
  formData.append('namaVenue', document.getElementById('e-namaVenue')?.value || '');
  formData.append('alamatVenue', document.getElementById('e-alamatVenue')?.value || '');

  const fotoCover = document.getElementById('e-fotoCover')?.files[0];
  if (fotoCover) formData.append('fotoCover', fotoCover);

  const fotoPenutup = document.getElementById('e-fotoPenutup')?.files[0];
  if (fotoPenutup) formData.append('fotoPenutup', fotoPenutup);

  const fotoPria = document.getElementById('e-fotoPria')?.files[0];
  if (fotoPria) formData.append('fotoPria', fotoPria);

  const fotoWanita = document.getElementById('e-fotoWanita')?.files[0];
  if (fotoWanita) formData.append('fotoWanita', fotoWanita);

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const response = await fetch('/api/dashboard/update', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      body: formData
    });

    if (response.ok) {
      const msg = document.getElementById('saveMsg');
      if (msg) {
        msg.style.display = 'block';
        setTimeout(() => msg.style.display = 'none', 3000);
      }
    } else {
      alert("Gagal menyimpan data.");
    }
  } catch(e) {
    console.error(e);
    alert("Terjadi kesalahan jaringan.");
  }
}

function exportCSV() {
  const rows = [['Nama','Pesan','Kehadiran']];
  ucapanData.forEach(u => {
    const pesan = u.pesan ? u.pesan : '';
    rows.push([u.nama, pesan, u.status]);
  });
  
  const csv = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'data-tamu-undangan.csv';
  a.click();
}

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