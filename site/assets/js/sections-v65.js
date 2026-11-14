/**
 * U1 · Interaktivita sekcí v65
 * Podporuje:
 *  - [data-hero] (hero slider)
 *  - [data-prepinac] (dělený blok služeb a týmů)
 *  - [data-proc] (5 kroků procesu)
 *  - [data-karusel] (karusel s šipkami a tažením)
 */
(function() {
  function initSections() {
    var $ = function(s, c) { return (c || document).querySelector(s); };
    var $$ = function(s, c) { return [].slice.call((c || document).querySelectorAll(s)); };

    // 1. HERO SLIDER
    var h = $('[data-hero]');
    if (h) {
      var imgs = $$('.hero__slides img', h);
      var nm = $('.hero__cur [data-name]', h) || $('.hero__name', h);
      var yr = $('.hero__cur [data-year]', h) || $('.hero__year', h);
      var bar = $('.hero__bar', h);
      var i = 0, T = 6000, tm;
      var red = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      h.style.setProperty('--slide', T + 'ms');

      var show = function(n) {
        if (!imgs.length) return;
        imgs[i].classList.remove('is-on');
        i = (n + imgs.length) % imgs.length;
        imgs[i].classList.add('is-on');
        if (nm) nm.textContent = imgs[i].dataset.name || '';
        if (yr) yr.textContent = imgs[i].dataset.year || '';
        if (bar) {
          bar.classList.remove('is-filling');
          void bar.offsetWidth; // trigger reflow
          bar.classList.add('is-filling');
        }
        clearTimeout(tm);
        if (!red) {
          tm = setTimeout(function() { show(i + 1); }, T);
        }
      };

      var nx = $('[data-hero-next]', h) || $('.hero__next', h);
      if (nx) {
        nx.addEventListener('click', function() { show(i + 1); });
      }
      if (imgs.length > 1) {
        show(0);
      }
    }

    // 2. DĚLENÝ BLOK ([data-prepinac])
    $$('[data-prepinac]').forEach(function(sec) {
      var it = $$('.seznam [role="tab"]', sec);
      var tx = $('[data-text]', sec);
      var im = $$('.del__foto img', sec);
      var vych = tx && tx.dataset.vychozi;
      var sez = $('.seznam', sec);

      if (tx) {
        var fit = function() {
          var puv = tx.textContent;
          var mx = 0;
          tx.style.minHeight = '0';
          [vych || puv].concat(it.map(function(x) { return x.dataset.desc; })).forEach(function(s) {
            if (!s) return;
            tx.textContent = s;
            mx = Math.max(mx, tx.offsetHeight);
          });
          tx.textContent = puv;
          tx.style.minHeight = mx + 'px';
        };
        fit();
        window.addEventListener('resize', fit);
      }

      if (vych && sez) {
        sez.addEventListener('mouseleave', function() {
          it.forEach(function(x) { x.setAttribute('aria-selected', 'false'); });
          tx.textContent = vych;
        });
      }

      it.forEach(function(t, k) {
        var go = function() {
          it.forEach(function(x) { x.setAttribute('aria-selected', x === t ? 'true' : 'false'); });
          if (tx && t.dataset.desc) tx.textContent = t.dataset.desc;
          im.forEach(function(m, j) { m.hidden = (j !== k); });
        };
        t.addEventListener('mouseenter', go);
        t.addEventListener('focus', go);
        if (t.tagName !== 'A') t.addEventListener('click', go);
      });
    });

    // 3. PROCES ([data-proc])
    var pr = $('[data-proc]');
    if (pr) {
      var row = $('.proc__rada', pr);
      var s = row ? [].slice.call(row.children) : [];
      var t = $('[data-proc-text]', pr) || $('.proc__text', pr);

      var cols = function(a) {
        return s.map(function(_, k) {
          return k === a ? 'calc(4*var(--c) + 3*var(--gap))' : 'calc(2*var(--c) + var(--gap))';
        }).join(' ');
      };

      var go = function(a) {
        s.forEach(function(x, k) { x.setAttribute('aria-selected', k === a ? 'true' : 'false'); });
        if (window.innerWidth > 760) {
          row.style.gridTemplateColumns = cols(a);
        } else {
          row.style.gridTemplateColumns = '';
        }
        if (t && s[a] && s[a].dataset.desc) {
          t.textContent = s[a].dataset.desc;
        }
      };

      var akt = 0;
      s.forEach(function(x, k) {
        ['mouseenter', 'focus', 'click'].forEach(function(e) {
          x.addEventListener(e, function() {
            akt = k;
            go(k);
          });
        });
      });

      if (s.length) go(0);
    }

    // 4. KARUSELY ([data-karusel])
    $$('[data-karusel]').forEach(function(sec) {
      var r = $('.rail', sec);
      var p = $('[data-prev]', sec);
      var n = $('[data-next]', sec);
      var c = $('.sipky', sec);
      if (!r || !p || !n) return;

      var step = function() {
        var k = r.firstElementChild;
        return k ? k.getBoundingClientRect().width + parseFloat(getComputedStyle(r).columnGap || 16) : 320;
      };

      var updateButtons = function() {
        var mx = r.scrollWidth - r.clientWidth - 2;
        p.disabled = r.scrollLeft <= 2;
        n.disabled = r.scrollLeft >= mx;
        if (c) c.style.visibility = mx <= 2 ? 'hidden' : 'visible';
      };

      p.addEventListener('click', function() {
        r.scrollBy({ left: -step(), behavior: 'smooth' });
      });
      n.addEventListener('click', function() {
        r.scrollBy({ left: step(), behavior: 'smooth' });
      });

      r.addEventListener('scroll', updateButtons, { passive: true });
      window.addEventListener('resize', updateButtons);
      updateButtons();

      // Tažení myší
      var isDown = false, startX = 0, scrollLeft = 0, isMoved = false;
      r.addEventListener('pointerdown', function(e) {
        if (e.pointerType !== 'mouse') return;
        isDown = true;
        isMoved = false;
        startX = e.clientX;
        scrollLeft = r.scrollLeft;
      });
      window.addEventListener('pointermove', function(e) {
        if (!isDown) return;
        var walk = e.clientX - startX;
        if (Math.abs(walk) > 5) {
          isMoved = true;
          r.classList.add('is-drag');
        }
        r.scrollLeft = scrollLeft - walk;
      });
      window.addEventListener('pointerup', function() {
        if (!isDown) return;
        isDown = false;
        setTimeout(function() { r.classList.remove('is-drag'); }, 0);
      });
      r.addEventListener('click', function(e) {
        if (isMoved) {
          e.preventDefault();
          isMoved = false;
        }
      }, true);
      r.addEventListener('dragstart', function(e) { e.preventDefault(); });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSections);
  } else {
    initSections();
  }
})();

