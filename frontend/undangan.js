// ─── TAMU DARI URL PARAMETER ───
(function () {
  const params = new URLSearchParams(window.location.search);
  const namaTamu = params.get('tamu') || 'Tamu Undangan';
  const guestTagEl = document.getElementById('guestTag');
  const pengantarNamaEl = document.getElementById('pengantarNama');
  if (guestTagEl) guestTagEl.textContent = `✦ Kepada Yth. ${namaTamu} ✦`;
  if (pengantarNamaEl) pengantarNamaEl.textContent = namaTamu;
})();

// ─── COUNTDOWN ───
function updateCountdown() {
  const target = new Date('2027-02-14T08:00:00');
  const now = new Date();
  const diff = target - now;
  if (diff <= 0) {
    ['days','hours','minutes','seconds'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.textContent = '00';
    });
    return;
  }
  const d = Math.floor(diff / 86400000);
  const h = Math.floor((diff % 86400000) / 3600000);
  const m = Math.floor((diff % 3600000) / 60000);
  const s = Math.floor((diff % 60000) / 1000);
  const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = String(val).padStart(2,'0'); };
  set('days', d); set('hours', h); set('minutes', m); set('seconds', s);
}
setInterval(updateCountdown, 1000);
updateCountdown();

// ─── UCAPAN DATA (shared via localStorage untuk demo) ───
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

let ucapanData = loadUcapan();

// render awal ucapan
(function renderUcapanAwal() {
  const list = document.getElementById('ucapanList');
  if (!list) return;
  list.innerHTML = '';
  ucapanData.forEach(u => addUcapanToList(u.nama, u.pesan, u.status));
})();

function kirimUcapan() {
  const nama = document.getElementById('ucapanNama').value.trim();
  const pesan = document.getElementById('ucapanPesan').value.trim();
  const status = document.getElementById('ucapanStatus').value;
  const konfirmEl = document.getElementById('pesanKonfirmasi');
  if (!nama || !pesan || !status) {
    konfirmEl.textContent = '⚠ Mohon lengkapi semua field.';
    return;
  }
  const now = new Date();
  const waktu = now.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' })
    + ', ' + now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
  const entry = { nama, pesan, status, waktu };
  ucapanData.push(entry);
  saveUcapan(ucapanData);
  addUcapanToList(nama, pesan, status);
  document.getElementById('ucapanNama').value = '';
  document.getElementById('ucapanPesan').value = '';
  document.getElementById('ucapanStatus').value = '';
  konfirmEl.textContent = '✦ Terima kasih, ucapan Anda telah tersampaikan!';
}

function addUcapanToList(nama, pesan, status) {
  const list = document.getElementById('ucapanList');
  if (!list) return;
  const el = document.createElement('div');
  el.className = 'ucapan-item';
  const badgeClass = status === 'hadir' ? 'hadir-badge' : 'tidak-badge';
  const badgeText = status === 'hadir' ? '✓ Hadir' : '✗ Tidak Hadir';
  el.innerHTML = `<div class="sender">${nama}</div><div class="message">${pesan}</div><span class="status-badge ${badgeClass}">${badgeText}</span>`;
  list.insertBefore(el, list.firstChild);
}

function quickRsvp(status) {
  const el = document.getElementById('pesanRsvp');
  if (!el) return;
  el.textContent = status === 'Hadir'
    ? '✦ Terima kasih! Kami menantikan kehadiran Anda. 💛'
    : '✦ Terima kasih atas doamu yang tulus. Kami sangat menghargainya. 🙏';
}

// ─── SCROLL REVEAL ───
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));

// ─── MUSIC ───
let musicPlaying = false;
function toggleMusic() {
  const audio = document.getElementById('bgMusic');
  const btn = document.getElementById('musicBtn');
  if (!audio || !btn) return;
  if (musicPlaying) { audio.pause(); btn.textContent = '🎵'; }
  else { audio.play().catch(() => {}); btn.textContent = '⏸'; }
  musicPlaying = !musicPlaying;
}