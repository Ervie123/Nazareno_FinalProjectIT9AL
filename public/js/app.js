/**
 * Tournament Pro — Laravel Edition
 * app.js — Global UI utilities
 */

document.addEventListener('DOMContentLoaded', () => {

  // ── Auto-dismiss flash toasts ──────────────────
  const toast = document.getElementById('flashToast');
  if (toast) {
    setTimeout(() => {
      toast.style.transition = 'opacity 0.4s';
      toast.style.opacity = '0';
      setTimeout(() => toast.remove(), 400);
    }, 3000);
  }

  // ── ESC closes any open modal ──────────────────
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal-backdrop:not(.hidden)')
        .forEach(m => m.classList.add('hidden'));
    }
  });

  // ── Click backdrop to close modal ─────────────
  document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
    backdrop.addEventListener('click', e => {
      if (e.target === backdrop) backdrop.classList.add('hidden');
    });
  });

  // ── Active nav highlight (fallback) ───────────
  const path = window.location.pathname;
  document.querySelectorAll('.nav-item').forEach(link => {
    const href = link.getAttribute('href');
    if (href && path.startsWith(href) && href !== '/') {
      link.classList.add('active');
    }
  });

});

// ── Password toggle helper ─────────────────────
function togglePw(id, btn) {
  const inp = document.getElementById(id);
  if (!inp) return;
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'password' ? '👁' : '🙈';
}
