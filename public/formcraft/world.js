/* FormCraft prototypes: shared behaviour.
   - Mounts the scroll-craft engine.
   - Stamps land when they scroll into view (the signature move).
   - Tiny demo interactions so each prototype can be clicked through. */
(function () {
  'use strict';
  var reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (window.ScrollCraft) ScrollCraft.mount(document.body);

  // Stamps: land once, the first time they enter the viewport.
  var stamps = document.querySelectorAll('[data-stamp]');
  if ('IntersectionObserver' in window && !reduce) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('is-landing'); io.unobserve(e.target); }
      });
    }, { threshold: .6 });
    stamps.forEach(function (s) { s.style.opacity = '0'; io.observe(s); s.addEventListener('animationstart', function () { s.style.opacity = ''; }); });
  }

  // Re-stamp on demand (status change demos): <button data-restamp="#id" data-text="YAYINDA">
  document.querySelectorAll('[data-restamp]').forEach(function (b) {
    b.addEventListener('click', function () {
      var s = document.querySelector(b.getAttribute('data-restamp'));
      if (!s) return;
      s.textContent = b.getAttribute('data-text');
      s.className = 'stamp ' + (b.getAttribute('data-class') || '');
      void s.offsetWidth; if (!reduce) s.classList.add('is-landing');
    });
  });

  // Copy public link demo.
  document.querySelectorAll('[data-copy]').forEach(function (b) {
    b.addEventListener('click', function () {
      var t = b.getAttribute('data-copy');
      if (navigator.clipboard) navigator.clipboard.writeText(t).catch(function () {});
      var old = b.textContent; b.textContent = 'Kopyalandı'; setTimeout(function () { b.textContent = old; }, 1400);
    });
  });

  document.querySelectorAll('[data-prototype-link]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      location.assign(form.getAttribute('action'));
    });
  });

  // Filter the sample forms by name and status.
  document.querySelectorAll('[data-filter]').forEach(function (g) {
    var search = document.querySelector('[data-form-search]');
    var empty = document.querySelector('[data-filter-empty]');
    function refresh() {
      var status = g.querySelector('[aria-pressed="true"]').dataset.f;
      var query = search ? search.value.trim().toLocaleLowerCase('tr') : '';
      var items = Array.from(document.querySelectorAll('[data-status]'));
      items.forEach(function (item) {
        var matches = !query || item.querySelector('h3').textContent.toLocaleLowerCase('tr').includes(query);
        item.hidden = !matches || (status !== 'all' && item.dataset.status !== status);
      });
      if (empty) empty.hidden = items.some(function (item) { return !item.hidden; });
    }
    g.addEventListener('click', function (e) {
      var button = e.target.closest('button[data-f]');
      if (!button) return;
      g.querySelectorAll('button').forEach(function (item) { item.setAttribute('aria-pressed', String(item === button)); });
      refresh();
    });
    if (search) search.addEventListener('input', refresh);
  });

  // Dialog openers: <button data-open="#dlg">
  document.querySelectorAll('[data-open]').forEach(function (b) {
    b.addEventListener('click', function () { var d = document.querySelector(b.getAttribute('data-open')); if (d && d.showModal) d.showModal(); });
  });
})();
