/* =========================================================
   Interaksi sisi klien: menu mobile, scroll-spy, modal detail,
   favorit, notifikasi, animasi, dan tombol cetak.
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {

  /* ---------- 1. Bayangan navbar saat di-scroll ---------- */
  const navbar = document.getElementById('navbar');
  const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 10);
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  /* ---------- 2. Menu mobile ---------- */
  const toggle = document.getElementById('navToggle');
  const menu   = document.getElementById('navMenu');
  toggle.addEventListener('click', () => {
    const buka = menu.classList.toggle('buka');
    toggle.setAttribute('aria-expanded', String(buka));
  });
  menu.querySelectorAll('a').forEach(a =>
    a.addEventListener('click', () => {
      menu.classList.remove('buka');
      toggle.setAttribute('aria-expanded', 'false');
    })
  );

  /* ---------- 3. Scroll-spy: tandai menu sesuai bagian yang terlihat ---------- */
  const linkSpy = [...menu.querySelectorAll('[data-spy]')];
  const seksi = linkSpy
    .map(a => document.getElementById(a.dataset.spy))
    .filter(Boolean);

  if (seksi.length && 'IntersectionObserver' in window) {
    const spy = new IntersectionObserver(entries => {
      entries.forEach(en => {
        if (en.isIntersecting) {
          linkSpy.forEach(a => a.classList.toggle('aktif', a.dataset.spy === en.target.id));
        }
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    seksi.forEach(s => spy.observe(s));
  }

  /* ---------- 4. Animasi muncul saat di-scroll ---------- */
  const reveals = document.querySelectorAll('.kartu, .timeline-item, .kartu-info, .kontak-daftar li');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach(en => {
        if (en.isIntersecting) {
          en.target.classList.add('terlihat');
          obs.unobserve(en.target);
        }
      });
    }, { threshold: 0.12 });
    reveals.forEach(el => { el.classList.add('reveal'); io.observe(el); });
  }

  /* ---------- 5. Notifikasi hilang otomatis ---------- */
  const toast = document.querySelector('.toast');
  if (toast) {
    setTimeout(() => toast.classList.add('hilang'), 3500);
    setTimeout(() => toast.remove(), 4000);
  }

  /* ---------- 6. Favorit (disimpan di localStorage) ---------- */
  const KUNCI = 'favorit-sepatu';
  const bacaFavorit = () => {
    try { return JSON.parse(localStorage.getItem(KUNCI)) || []; } catch { return []; }
  };
  const simpanFavorit = daftar => {
    try { localStorage.setItem(KUNCI, JSON.stringify(daftar)); } catch { /* abaikan */ }
  };

  document.querySelectorAll('[data-suka]').forEach(btn => {
    const id = btn.dataset.suka;
    const tandai = aktif => {
      btn.classList.toggle('aktif', aktif);
      btn.setAttribute('aria-pressed', String(aktif));
    };
    tandai(bacaFavorit().includes(id));

    btn.addEventListener('click', () => {
      let daftar = bacaFavorit();
      const sudah = daftar.includes(id);
      daftar = sudah ? daftar.filter(x => x !== id) : [...daftar, id];
      simpanFavorit(daftar);
      tandai(!sudah);
    });
  });

  /* ---------- 7. Modal detail produk ---------- */
  const modal = document.getElementById('modal');
  if (modal) {
    const el = id => document.getElementById(id);
    let pemicu = null;

    const buka = data => {
      el('mdGambar').src = data.gambar;
      el('mdGambar').alt = data.nama;
      el('mdKategori').textContent = data.merek + ' · ' + data.kategori;
      el('mdNama').textContent = data.nama;
      el('mdHarga').textContent = data.harga;
      el('mdDeskripsi').textContent = data.deskripsi;
      el('mdId').value = data.id;
      el('mdWa').href = data.wa;

      const stok = el('mdStok');
      stok.textContent = data.stok;
      stok.className = 'status ' + (/habis|Semua/.test(data.stok) ? 'status-habis'
                                  : /menipis/.test(data.stok) ? 'status-menipis' : 'status-tersedia');

      const ukuran = el('mdUkuran');
      ukuran.replaceChildren();
      data.ukuran.forEach(u => {
        const b = document.createElement('button');
        b.type = 'button';
        b.textContent = u;
        b.addEventListener('click', () => {
          ukuran.querySelectorAll('button').forEach(x => x.classList.remove('aktif'));
          b.classList.add('aktif');
        });
        ukuran.appendChild(b);
      });

      const spek = el('mdSpek');
      spek.replaceChildren();
      Object.entries(data.spek).forEach(([k, v]) => {
        const dt = document.createElement('dt'); dt.textContent = k;
        const dd = document.createElement('dd'); dd.textContent = v;
        spek.append(dt, dd);
      });

      modal.hidden = false;
      document.body.style.overflow = 'hidden';
      modal.querySelector('.modal-tutup').focus();
    };

    const tutup = () => {
      modal.hidden = true;
      document.body.style.overflow = '';
      if (pemicu) pemicu.focus();
    };

    document.querySelectorAll('.btn-detail').forEach(btn =>
      btn.addEventListener('click', () => {
        pemicu = btn;
        buka(JSON.parse(btn.dataset.produk));
      })
    );
    modal.querySelectorAll('[data-tutup]').forEach(x => x.addEventListener('click', tutup));
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.hidden) tutup(); });
  }

  /* ---------- 8. Tombol cetak / simpan PDF ---------- */
  document.querySelectorAll('[data-cetak]').forEach(b =>
    b.addEventListener('click', () => window.print())
  );
});
