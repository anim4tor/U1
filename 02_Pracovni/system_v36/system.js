// U1 · systém v09 (+ vyhledávání v projektech) (základ v01 + tažení karuselů, šipky a tažení procesu, výchozí text týmů): jeden skript pro celý web. Každá část se spustí jen tam, kde najde svůj blok.
(function(){
var $=function(s,c){return (c||document).querySelector(s)},$$=function(s,c){return [].slice.call((c||document).querySelectorAll(s))};

// menu
var tg=$('.nav__toggle'),pn=$('#navpanel');
if(tg&&pn)tg.addEventListener('click',function(){var o=tg.getAttribute('aria-expanded')!=='true';tg.setAttribute('aria-expanded',o);tg.setAttribute('aria-label',o?'Zavřít menu':'Otevřít menu');pn.hidden=!o;});

// úvod homepage: střídání realizací, popisek v liště
var h=$('[data-hero]');
if(h){var imgs=$$('.hero__slides img',h),nm=$('.hero__cur [data-name]',h),yr=$('.hero__cur [data-year]',h),bar=$('.hero__bar',h),i=0,T=6000,tm,red=matchMedia('(prefers-reduced-motion: reduce)').matches;
  h.style.setProperty('--slide',T+'ms');
  var show=function(n){imgs[i].classList.remove('is-on');i=(n+imgs.length)%imgs.length;imgs[i].classList.add('is-on');nm.textContent=imgs[i].dataset.name;yr.textContent=imgs[i].dataset.year;bar.classList.remove('is-filling');void bar.offsetWidth;bar.classList.add('is-filling');clearTimeout(tm);if(!red)tm=setTimeout(function(){show(i+1)},T);};
  var nx=$('[data-hero-next]',h);if(nx)nx.addEventListener('click',function(){show(i+1)});show(0);}

// plovoucí tlačítko: při scrollu dolů se sbalí
var fab=$('[data-fab]'),last=0;
if(fab)addEventListener('scroll',function(){var y=scrollY;if(y>last&&y>100)fab.setAttribute('data-collapsed','');else if(y<last&&y<100)fab.removeAttribute('data-collapsed');last=y;},{passive:true});

// mřížka
var gb=$('#gridbtn');if(gb)gb.addEventListener('click',function(){var on=document.body.classList.toggle('show-grid');gb.setAttribute('aria-pressed',on);gb.textContent=on?'Skrýt mřížku':'Ukázat mřížku';});

// seznam v děleném bloku: najetí přepne text a fotku, klik u odkazu otevře stránku
$$('[data-prepinac]').forEach(function(sec){
  var it=$$('.seznam [role="tab"]',sec),tx=$('[data-text]',sec),im=$$('.del__foto img',sec);
  var vych=tx&&tx.dataset.vychozi,sez=$('.seznam',sec);
  if(tx){var fit=function(){var puv=tx.textContent,mx=0;tx.style.minHeight='0';[vych||puv].concat(it.map(function(x){return x.dataset.desc})).forEach(function(s){tx.textContent=s;mx=Math.max(mx,tx.offsetHeight)});tx.textContent=puv;tx.style.minHeight=mx+'px';};fit();addEventListener('resize',fit);}
  if(vych&&sez)sez.addEventListener('mouseleave',function(){it.forEach(function(x){x.setAttribute('aria-selected','false')});tx.textContent=vych;});
  it.forEach(function(t,k){var go=function(){it.forEach(function(x){x.setAttribute('aria-selected',x===t)});if(tx)tx.textContent=t.dataset.desc;im.forEach(function(m,j){m.hidden=j!==k});};
    t.addEventListener('mouseenter',go);t.addEventListener('focus',go);if(t.tagName!=='A')t.addEventListener('click',go);});
});

// záložky na celoplošné fotce
$$('[data-zalozky]').forEach(function(sec){var b=$$('button',sec),tx=$('.zalozky__text',sec);
  b.forEach(function(t){var go=function(){b.forEach(function(x){x.setAttribute('aria-selected',x===t)});tx.textContent=t.dataset.desc;};t.addEventListener('mouseenter',go);t.addEventListener('focus',go);t.addEventListener('click',go);});});

// karusely
$$('[data-karusel]').forEach(function(sec){var r=$('.rail',sec),p=$('[data-prev]',sec),n=$('[data-next]',sec),c=$('.sipky',sec);if(!r||!p)return;
  var st=function(){var k=r.firstElementChild;return k?k.getBoundingClientRect().width+parseFloat(getComputedStyle(r).columnGap||0):300};
  var up=function(){var mx=r.scrollWidth-r.clientWidth-2;p.disabled=r.scrollLeft<=2;n.disabled=r.scrollLeft>=mx;c.style.visibility=mx<=2?'hidden':'visible';};
  p.addEventListener('click',function(){r.scrollBy({left:-st(),behavior:'smooth'})});n.addEventListener('click',function(){r.scrollBy({left:st(),behavior:'smooth'})});
  r.addEventListener('scroll',up,{passive:true});addEventListener('resize',up);up();});

// karusely: posun tažením myší (dotyk a touchpad fungují nativně)
$$('.rail').forEach(function(r){var down=false,sx=0,sl=0,moved=false;
  r.addEventListener('pointerdown',function(e){if(e.pointerType!=='mouse')return;down=true;moved=false;sx=e.clientX;sl=r.scrollLeft;});
  addEventListener('pointermove',function(e){if(!down)return;var d=e.clientX-sx;if(Math.abs(d)>5){moved=true;r.classList.add('is-drag');}r.scrollLeft=sl-d;});
  addEventListener('pointerup',function(){if(!down)return;down=false;setTimeout(function(){r.classList.remove('is-drag')},0);});
  r.addEventListener('click',function(e){if(moved){e.preventDefault();moved=false;}},true);
  r.addEventListener('dragstart',function(e){e.preventDefault()});});

// proces: aktivní krok 4 sloupce, ostatní 2
var pr=$('[data-proc]');
if(pr){var row=$('.proc__rada',pr),s=[].slice.call(row.children),t=$('.proc__text',pr);
  var cols=function(a){return s.map(function(_,k){return k===a?'calc(4*var(--c) + 3*var(--gap))':'calc(2*var(--c) + var(--gap))'}).join(' ')};
  var go=function(a){s.forEach(function(x,k){x.setAttribute('aria-selected',k===a)});row.style.gridTemplateColumns=cols(a);t.textContent=s[a].dataset.desc;};
  var akt=0,go2=function(a){akt=Math.max(0,Math.min(s.length-1,a));go(akt);};
  s.forEach(function(x,k){['mouseenter','focus','click'].forEach(function(e){x.addEventListener(e,function(){akt=k;go(k)})})});
  var pp=$('[data-prev]',pr),pn2=$('[data-next]',pr);if(pp)pp.addEventListener('click',function(){go2(akt-1)});if(pn2)pn2.addEventListener('click',function(){go2(akt+1)});
  var sx=null;row.addEventListener('pointerdown',function(e){sx=e.clientX;});
  // touchpad: vodorovný tah přepne krok
  var acc=0,lock=false;row.addEventListener('wheel',function(e){if(Math.abs(e.deltaX)<=Math.abs(e.deltaY))return;e.preventDefault();if(lock)return;acc+=e.deltaX;if(Math.abs(acc)>40){go2(akt+(acc>0?1:-1));acc=0;lock=true;setTimeout(function(){lock=false},450);}},{passive:false});
  addEventListener('pointerup',function(e){if(sx===null)return;var d=e.clientX-sx;sx=null;if(Math.abs(d)>40)go2(akt+(d<0?1:-1));});
  go(0);}

// filtry karet: data-filtr="skupina:hodnota", karta data-<skupina>="a b"
$$('[data-filtry]').forEach(function(sec){var ch=$$('[data-filtr]',sec),ka=$$('[data-karta]',sec),st={};
  var up=function(){ka.forEach(function(k){k.hidden=!Object.keys(st).every(function(g){return !st[g]||(' '+(k.dataset[g]||'')+' ').indexOf(' '+st[g]+' ')>-1})})};
  ch.forEach(function(c){c.addEventListener('click',function(){var f=c.dataset.filtr.split(':');st[f[0]]=f[1]==='vse'?'':f[1];ch.filter(function(x){return x.dataset.filtr.split(':')[0]===f[0]}).forEach(function(x){x.setAttribute('aria-pressed',x===c)});up();})});
  var hs=location.hash.slice(1),b=hs&&$('[data-filtr$=":'+hs+'"]',sec);if(b)b.click();});

// vyhledávání a filtry v projektech: text + výběry, živě
$$('[data-hledani]').forEach(function(sec){
  var tg=$('[data-hledani-toggle]',sec),pn=$('.hledani',sec),inp=$('.hledani__pole input',sec),sel=$$('.vyber',sec),ka=$$('[data-karta]',sec),poc=$('.hledani__pocet',sec),nic=$('.nic',sec);
  if(tg&&pn)tg.addEventListener('click',function(){pn.hidden=!pn.hidden;tg.setAttribute('aria-expanded',!pn.hidden);if(!pn.hidden&&inp)inp.focus();});
  var norm=function(s){return (s||'').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'')};
  var up=function(){var q=norm(inp&&inp.value),n=0;ka.forEach(function(k){var ok=(!q||norm(k.textContent+' '+(k.dataset.hledat||'')).indexOf(q)>-1)&&sel.every(function(s){return !s.value||(' '+(k.dataset[s.name]||'')+' ').indexOf(' '+s.value+' ')>-1});k.hidden=!ok;if(ok)n++;});
    if(poc)poc.textContent=n+(n===1?' realizace':(n>1&&n<5?' realizace':' realizací'));if(nic)nic.hidden=n>0;};
  if(inp)inp.addEventListener('input',up);sel.forEach(function(s){s.addEventListener('change',up)});up();});

// kontaktní panel
var pop=$('[data-cpop]');
if(pop){var box=$('.cpop__box',pop),tabs=$$('[data-cpop-tab]',pop),panes=$$('[data-cpop-pane]',pop),back=null;
  var showP=function(n){tabs.forEach(function(t){if(t.classList.contains('cpop__tab'))t.setAttribute('aria-selected',t.dataset.cpopTab===n)});panes.forEach(function(p){p.hidden=p.dataset.cpopPane!==n});box.classList.toggle('is-wide',n==='poptavka');};
  var open=function(n){back=document.activeElement;pop.hidden=false;document.body.classList.add('cpop-open');showP(n||'kontakt');var f=$('[data-cpop-pane]:not([hidden]) input, .cpop__tab',pop);if(f)f.focus();};
  var close=function(){pop.hidden=true;document.body.classList.remove('cpop-open');if(back)back.focus();};
  document.addEventListener('click',function(e){var t=e.target.closest('[data-kontakt]');if(t){e.preventDefault();open(t.dataset.kontakt||'kontakt');return;}
    if(e.target.closest('[data-cpop-close]')||e.target.classList.contains('cpop__clona'))close();var tb=e.target.closest('[data-cpop-tab]');if(tb&&pop.contains(tb))showP(tb.dataset.cpopTab);});
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&!pop.hidden)close();});
  var fm=$('form',pop);if(fm)fm.addEventListener('submit',function(e){e.preventDefault();showP('hotovo');});}
})();

/* v20: záložky na stránce pozice (Náplň práce, Požadujeme, Nabízíme) */
(function(){document.querySelectorAll('[data-zalozky]').forEach(function(s){var tabs=[].slice.call(s.querySelectorAll('[data-zalozka]'));
  function vyber(t){tabs.forEach(function(x){var on=x===t;x.setAttribute('aria-selected',on?'true':'false');x.tabIndex=on?0:-1;var p=s.querySelector('[data-panel="'+x.dataset.zalozka+'"]');if(p)p.hidden=!on;});}
  tabs.forEach(function(t,i){t.tabIndex=i?-1:0;t.addEventListener('click',function(){vyber(t);});
    t.addEventListener('keydown',function(e){var k=e.key==='ArrowDown'||e.key==='ArrowRight'?1:e.key==='ArrowUp'||e.key==='ArrowLeft'?-1:0;if(!k)return;e.preventDefault();var n=tabs[(i+k+tabs.length)%tabs.length];vyber(n);n.focus();});});});})();

/* v21: náhled fotky služby u kurzoru (jen myš) */
(function(){var sek=document.querySelector('[data-nahled]');if(!sek||!matchMedia('(hover:hover) and (pointer:fine)').matches)return;
  var box=sek.querySelector('.nahled'),img=box&&box.querySelector('img');if(!img)return;var x=0,y=0,raf=0;
  function pos(){raf=0;box.style.transform='translate3d('+(x+24)+'px,'+(y-box.offsetHeight/2)+'px,0)';}
  sek.addEventListener('mousemove',function(e){x=e.clientX;y=e.clientY;if(!raf)raf=requestAnimationFrame(pos);});
  sek.querySelectorAll('a[data-foto]').forEach(function(a){a.addEventListener('mouseenter',function(){if(img.getAttribute('src')!==a.dataset.foto)img.src=a.dataset.foto;box.classList.add('is-on');});
    a.addEventListener('mouseleave',function(){box.classList.remove('is-on');});});})();

/* v31: filtry nad výpisem realizací napojené na výběr Prostory */
(function(){document.querySelectorAll('[data-chipy]').forEach(function(box){var sec=box.closest('section'),sel=sec&&sec.querySelector('select[name="'+box.dataset.chipy+'"]');if(!sel)return;
  var bt=[].slice.call(box.querySelectorAll('[data-chip]'));bt.forEach(function(b){b.addEventListener('click',function(){bt.forEach(function(x){x.setAttribute('aria-pressed',x===b?'true':'false')});sel.value=b.dataset.chip;sel.dispatchEvent(new Event('change'));});});});})();
