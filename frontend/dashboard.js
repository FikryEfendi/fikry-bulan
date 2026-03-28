// ─── AUTH ───
const ADMIN_PASS = 'admin123';

function doLogin() {
  const pass = document.getElementById('loginPass').value;
  const err = document.getElementById('loginErr');
  if (pass === ADMIN_PASS) {
    document.getElementById('loginOverlay').classList.remove('show');
    document.getElementById('loginPass').value = '';
    err.style.display = 'none';
    document.getElementById('dashboardWrap').classList.add('active');
    updateStats();
    renderTamuTable();
    renderChecklist();
    updateDashCountdown();
  } else {
    err.style.display = 'block';
    document.getElementById('loginPass').value = '';
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('loginOverlay').classList.add('show');
  document.getElementById('loginPass').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') doLogin();
  });
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

// ─── DATA (sync via localStorage) ───
function loadUcapan() {
  try {
    const raw = localStorage.getItem('ucapanData');
    if (raw) return JSON.parse(raw);
  } catch(e) {}
  return [
    { nama: 'Ahmad Rizki', pesan: 'Selamat menempuh hidup baru! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Aamiin 🤍', status: 'hadir', waktu: '01 Jan 2027, 10:23' },
    { nama: 'Siti Nurhaliza', pesan: "Barakallahu lakuma wa baraka 'alaikuma. Selamat ya kak! 💛", status: 'hadir', waktu: '05 Jan 2027, 14:11' },
    { nama: 'Deni Saputra', pesan: 'Semoga langgeng hingga maut memisahkan. Doain dari jauh. 🙏', status: 'tidak', waktu: '10 Jan 2027, 09:05' },
  ];
}

function saveUcapan(data) {
  try { localStorage.setItem('ucapanData', JSON.stringify(data)); } catch(e) {}
}

// ─── DAFTAR TAMU (data admin kelola) ───
function loadTamuList() {
  try {
    const raw = localStorage.getItem('tamuList');
    if (raw) return JSON.parse(raw);
  } catch(e) {}
  return [
    { nama: 'Farhan' },
    { nama: 'Budi Santoso' },
    { nama: 'Sari Dewi' },
  ];
}

function saveTamuList(data) {
  try { localStorage.setItem('tamuList', JSON.stringify(data)); } catch(e) {}
}

let ucapanData = loadUcapan();
let tamuList = loadTamuList();

// ─── STATS ───
function updateStats() {
  ucapanData = loadUcapan();
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
// Tab yang tersedia: overview, edit, tamu, link
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
  if (tab === 'tamu') renderTamuTable();
  if (tab === 'link') renderLinkTable();
  closeSidebar();
}

// ─── TAMU TABLE (ucapan yang masuk) ───
function renderTamuTable() {
  ucapanData = loadUcapan();
  const tbody = document.getElementById('tamuBody');
  if (!tbody) return;
  tbody.innerHTML = '';
  ucapanData.forEach((t, i) => {
    const badgeClass = t.status === 'hadir' ? 'badge-hadir' : t.status === 'tidak' ? 'badge-tidak' : 'badge-belum';
    const badgeText = t.status === 'hadir' ? '✓ Hadir' : t.status === 'tidak' ? '✗ Tidak Hadir' : '— Belum';
    tbody.innerHTML += `<tr>
      <td style="color:var(--gold-dark);font-weight:600;">${i+1}</td>
      <td style="font-weight:600;">${t.nama}</td>
      <td style="max-width:260px;font-style:italic;color:var(--text-light);">${t.pesan.substring(0,80)}${t.pesan.length>80?'…':''}</td>
      <td><span class="badge ${badgeClass}">${badgeText}</span></td>
      <td style="color:var(--text-light);font-size:12px;">${t.waktu}</td>
    </tr>`;
  });
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

// ─── LINK GENERATOR ───
function renderLinkTable() {
  tamuList = loadTamuList();
  const tbody = document.getElementById('linkTableBody');
  if (!tbody) return;
  tbody.innerHTML = tamuList.map((t, i) => {
    const base = window.location.href.replace('dashboard.html', 'undangan.html');
    const link = `${base}?tamu=${encodeURIComponent(t.nama)}`;
    return `<tr>
      <td style="font-weight:600;">${t.nama}</td>
      <td style="font-family:monospace;font-size:12px;color:var(--text-light);word-break:break-all;">${link}</td>
      <td>
        <button class="btn-sm btn-sm-gold" onclick="copyLink('${encodeURIComponent(link)}')">📋 Salin</button>
        <button class="btn-sm btn-sm-red" style="margin-top:4px;" onclick="hapusTamu(${i})">✕</button>
      </td>
    </tr>`;
  }).join('');
}

function tambahTamu() {
  const input = document.getElementById('namaTamuBaru');
  if (!input) return;
  const nama = input.value.trim();
  if (!nama) return;
  tamuList.push({ nama });
  saveTamuList(tamuList);
  input.value = '';
  renderLinkTable();
}

function hapusTamu(i) {
  if (!confirm('Hapus tamu ini?')) return;
  tamuList.splice(i, 1);
  saveTamuList(tamuList);
  renderLinkTable();
}

function copyLink(encodedLink) {
  const link = decodeURIComponent(encodedLink);
  navigator.clipboard.writeText(link).then(() => {
    alert('Link berhasil disalin!');
  }).catch(() => {
    prompt('Salin link ini:', link);
  });
}

// ─── SAVE EDIT ───
function saveEdits() {
  const msg = document.getElementById('saveMsg');
  if (msg) {
    msg.style.display = 'block';
    setTimeout(() => msg.style.display = 'none', 3000);
  }
}

// ─── SIDEBAR MOBILE ───
function toggleSidebar() {
  const sidebar = document.getElementById('dashSidebar');
  const overlay = document.getElementById('sidebarOverlay');
  sidebar.classList.toggle('open');
  overlay.classList.toggle('show');
}
function closeSidebar() {
  const sidebar = document.getElementById('dashSidebar');
  const overlay = document.getElementById('sidebarOverlay');
  if (sidebar) sidebar.classList.remove('open');
  if (overlay) overlay.classList.remove('show');
}

// ─── EXPORT CSV ───
function exportCSV() {
  ucapanData = loadUcapan();
  const rows = [['Nama','Pesan','Kehadiran','Waktu']];
  ucapanData.forEach(u => rows.push([u.nama, u.pesan, u.status, u.waktu]));
  const csv = rows.map(r => r.map(v => `"${v}"`).join(',')).join('\n');
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'data-tamu-undangan.csv';
  a.click();
}