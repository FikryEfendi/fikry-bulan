(function () {
  const params = new URLSearchParams(window.location.search);
  const namaTamu = params.get('tamu') || 'Tamu Undangan';
  const guestTagEl = document.getElementById('guestTag');
  const pengantarNamaEl = document.getElementById('pengantarNama');
  if (guestTagEl) guestTagEl.textContent = `✦ Kepada Yth. ${namaTamu} ✦`;
  if (pengantarNamaEl) pengantarNamaEl.textContent = namaTamu;
})();

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

async function loadUcapanDariDB() {
  const list = document.getElementById('ucapanList');
  if (!list) return;

  try {
    const response = await fetch('api_tamu.php?action=get');
    const data = await response.json();

    list.innerHTML = '';
    if (data.length === 0) {
      list.innerHTML = '<p style="text-align:center;color:var(--text-light);font-style:italic;font-size:13px;">Belum ada ucapan. Jadilah yang pertama! 💛</p>';
      return;
    }

    data.forEach(u => {
      addUcapanToList(u.nama, u.pesan || '', u.status, false);
    });
  } catch (e) {
    console.error('Gagal memuat ucapan dari database:', e);
  }
}

document.addEventListener('DOMContentLoaded', loadUcapanDariDB);

async function kirimUcapan() {
  const namaEl   = document.getElementById('ucapanNama');
  const pesanEl  = document.getElementById('ucapanPesan');
  const statusEl = document.getElementById('ucapanStatus');
  const konfirmEl = document.getElementById('pesanKonfirmasi');

  const nama   = namaEl.value.trim();
  const pesan  = pesanEl.value.trim();
  const status = statusEl.value; 

  if (!nama || !pesan || !status) {
    konfirmEl.textContent = '⚠ Mohon lengkapi semua field.';
    return;
  }

  const konfirmasi_hadir = (status === 'hadir') ? 'Hadir' : 'Tidak Hadir';

  try {
    konfirmEl.textContent = '⏳ Mengirim...';

    const response = await fetch('api_tamu.php?action=add', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        nama: nama,
        pesan: pesan,
        konfirmasi_hadir: konfirmasi_hadir
      })
    });

    const result = await response.json();

    if (result.status === 'success') {
      addUcapanToList(nama, pesan, status, true);

      namaEl.value = '';
      pesanEl.value = '';
      statusEl.value = '';
      konfirmEl.textContent = '✦ Terima kasih, ucapan Anda telah tersampaikan!';
    } else {
      konfirmEl.textContent = '✗ Gagal mengirim, coba lagi.';
    }
  } catch (e) {
    console.error('Error kirim ucapan:', e);
    konfirmEl.textContent = '✗ Terjadi kesalahan koneksi.';
  }
}

function addUcapanToList(nama, pesan, status, prepend = true) {
  const list = document.getElementById('ucapanList');
  if (!list) return;

  const emptyMsg = list.querySelector('p');
  if (emptyMsg) emptyMsg.remove();

  const el = document.createElement('div');
  el.className = 'ucapan-item';
  const badgeClass = status === 'hadir' ? 'hadir-badge' : 'tidak-badge';
  const badgeText  = status === 'hadir' ? '✓ Hadir' : '✗ Tidak Hadir';
  el.innerHTML = `
    <div class="sender">${nama}</div>
    <div class="message">${pesan}</div>
    <span class="status-badge ${badgeClass}">${badgeText}</span>
  `;

  if (prepend) {
    list.insertBefore(el, list.firstChild);
  } else {
    list.appendChild(el);
  }
}

function quickRsvp(status) {
  const el = document.getElementById('pesanRsvp');
  if (!el) return;
  el.textContent = status === 'Hadir'
    ? '✦ Terima kasih! Kami menantikan kehadiran Anda. 💛'
    : '✦ Terima kasih atas doamu yang tulus. Kami sangat menghargainya. 🙏';
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));

let musicPlaying = false;
function toggleMusic() {
  const audio = document.getElementById('bgMusic');
  const btn = document.getElementById('musicBtn');
  if (!audio || !btn) return;
  if (musicPlaying) { audio.pause(); btn.textContent = '🎵'; }
  else { audio.play().catch(() => {}); btn.textContent = '⏸'; }
  musicPlaying = !musicPlaying;
}

function bukaUndangan() {
  const opening = document.getElementById("opening");
  const audio = document.getElementById("bgMusic");

  opening.style.opacity = "0";
  setTimeout(() => {
    opening.style.display = "none";
  }, 800);
  audio.play().catch(() => {});
}
