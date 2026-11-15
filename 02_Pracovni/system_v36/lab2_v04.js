// lab2_v04.js: kopie lab2_v03.js; za úvodem připnutý výpis. (v03: úvod stránky vždy první a viditelný.) Původní lab2.js a lab2_v02.js beze změny.
// (v02: kopie lab2.js (GPT) s opravou vkládání nových bloků)
/* Laboratoř U1 v2. Načíst místo lab.js, po lab.css připojit lab2.css. */
(function () {
'use strict';
if (document.getElementById('lab2-panel')) return;
var SKUP=[
 ['Menu',[
  ['rozl','Rozložení',[['','D1 segmentová lišta'],['rozl-d2','D2 tři plovoucí části'],['rozl-d3','D3 přes celou šířku'],['rozl-d4','D4 minimální: logo a Menu'],['rozl-d5','D5 logo uprostřed'],['rozl-d6','D6 malá pilulka']]],
  ['logo','Logo',[['','u1 + space design'],['logo-orig','původní space u1 design'],['logo-znak','jen znak u1']]],
  ['lista','Výška lišty',[['lista-50','50 px'],['lista-60','60 px'],['lista-70','70 px']]],
  ['zar','Původní logo',[['zar-ucari','text na lince odkazů'],['zar-okraje','stejné okraje nahoře a dole']]],
  ['odkzar','Odkazy',[['','na středu lišty'],['odkazy-na-logo','na lince loga']]],
  ['pozadi','Pozadí lišty',[['','naše tmavé sklo'],['pozadi-cerna','černá plná'],['pozadi-bila','bílá']]],
  ['linky','Linky mezi částmi',[['','ano'],['bez-linek','ne']]],
  ['odk','Odkazy v liště',[['','zobrazit'],['bez-odkazu','skrýt']]],
  ['cta','Tlačítko Poptat',[['','plné'],['cta-pilulka','plné pilulka'],['cta-obrys','obrys'],['cta-skryt','skrýt']]],
  ['fab','Plovoucí tlačítko',[['','jen mobil'],['fab-ukaz','vždy'],['fab-skryt','nikdy']]]]],
 ['Záhlaví podstránek',[
  ['hlava','Nadpis',[['','výchozí'],['hlava-velky','velký'],['hlava-stred','na střed (výpisy)'],['hlava-agnos','Agnos: velký na střed'],['hlava-klusak','Klusák: čára nahoře, popis vpravo']]],
  ['hlbarva','Barva záhlaví',[['','bílá'],['hlava-cerna','černá'],['hlava-bezova','béžová']]],
  ['perex','Perex',[['','zobrazit'],['bez-perexu','skrýt']]],
  ['cara','Čára pod nadpisem',[['','ano'],['bez-cary','ne']]],
  ['foto','Fotka v úvodu',[['','nízká'],['foto-vysoka','vysoká'],['foto-skryt','bez fotky']]],
  ['drobky','Drobečky',[['','skryté'],['drobky-ukaz','zobrazit']]]]],
 ['Barevnost podstránek',[
  ['barvy','Bloky',[['','bílá a černá (výchozí)'],['barvy-bt','bílá a béžová'],['barvy-b','jen bílá s mezerou'],['barvy-karty','béžová stránka, bílé karty']]]]],
 ['Skrýt sekce',[
  ['rec','Recenze',[['','zobrazit'],['skryt-recenze','skrýt']]],
  ['cl','Články',[['','zobrazit'],['skryt-clanky','skrýt']]],
  ['vy','Výzva dole',[['','zobrazit'],['skryt-vyzva','skrýt']]],
  ['pr','Proces',[['','zobrazit'],['skryt-proces','skrýt']]],
  ['mr','Tlačítko mřížky',[['','zobrazit'],['mrizka-skryt','skrýt']]]]]];

var MENU = [
 ['v33', 'v33 původní pilulka'], ['v36', 'v36 segmenty, logo u1'],
 ['v43', 'v43 vyvážené, jedno účaří'], ['v44', 'v44 původní logo, stejné okraje'],
 ['v45', 'v45 původní logo + rozložení D1 až D6']
];
var PREFIX = 'u1lab2_v1:', GLOBAL = PREFIX + 'global', PAGE = PREFIX + 'page:';
var H = document.documentElement;
var pageName = location.pathname.split('/').pop() || 'index.html';
var optionDefs = SKUP.reduce(function (a, g) { return a.concat(g[1]); }, []);
var initialOptions = {};
optionDefs.forEach(function (o) {
 initialOptions[o[0]] = (o[2].find(function (v) { return v[0] && H.classList.contains(v[0]); }) || ['', ''])[0];
});
if (!initialOptions.logo) initialOptions.logo = 'logo-orig';
if (!initialOptions.lista) initialOptions.lista = 'lista-70';
if (!initialOptions.zar) initialOptions.zar = 'zar-okraje';
function copy(x) { return JSON.parse(JSON.stringify(x)); }
function record(x) { return x && typeof x === 'object' && !Array.isArray(x); }
function color(x) { return typeof x === 'string' && /^#[0-9a-f]{6}$/i.test(x) ? x.toUpperCase() : null; }
function defaultGlobal() { return {menu:'v44', background:null, options:copy(initialOptions)}; }
function cleanGlobal(x) {
 var g = defaultGlobal();
 if (!record(x)) return g;
 if (MENU.some(function (v) { return v[0] === x.menu; })) g.menu = x.menu;
 g.background = color(x.background);
 optionDefs.forEach(function (o) {
  if (record(x.options) && o[2].some(function (v) { return v[0] === x.options[o[0]]; })) g.options[o[0]] = x.options[o[0]];
 });
 return g;
}
function cleanPage(x) {
 var p = {order:[], blocks:Object.create(null)};
 if (!record(x)) return p;
 if (Array.isArray(x.order)) p.order = x.order.filter(function (id, i, all) { return typeof id === 'string' && id.length < 300 && all.indexOf(id) === i; }).slice(0, 500);
 if (record(x.blocks)) Object.keys(x.blocks).slice(0, 500).forEach(function (id) {
  var b = x.blocks[id];
  if (!record(b) || id.length >= 300) return;
  p.blocks[id] = {visible:b.visible !== false, variant:typeof b.variant === 'string' ? b.variant.slice(0, 300) : '', color:color(b.color)};
 });
 return p;
}
var storageWarning = false;
function read(key) { try { return JSON.parse(localStorage.getItem(key)); } catch (e) { return null; } }
var globalState = cleanGlobal(read(GLOBAL)), pageState;
var blocks = new Map(), originalOrder = [], main, panel, list, status, style, trigger, sortable;
var layoutField, layoutSelect, menuSelect, backgroundInput, linkField, importField;
var extraSelects = [], importMessage = '';
function tell(message) { if (status) status.textContent = message; }
function save() {
 try { localStorage.setItem(GLOBAL, JSON.stringify(globalState)); localStorage.setItem(PAGE + pageName, JSON.stringify(pageState)); }
 catch (e) { storageWarning = true; tell('Prohlížeč nepovoluje uložení. Nastavení lze přenést odkazem.'); }
}
function reconcile(p) {
 p = cleanPage(p);
 p.order = p.order.filter(function (id) { return blocks.has(id); });
 originalOrder.forEach(function (id, k) {
  var b = blocks.get(id), s = p.blocks[id];
  // v02 (26. 10. 2026): nový blok se vloží na své místo podle stránky (za předchozí blok), ne na konec uloženého pořadí
  if (p.order.indexOf(id) < 0) { var j = k ? p.order.indexOf(originalOrder[k - 1]) : -1; p.order.splice(j + 1, 0, id); }
  if (!s) s = {visible:true, variant:b.defaultVariant, color:null};
  if (!b.nodes.some(function (n) { return n.variant === s.variant; })) s.variant = b.defaultVariant;
  p.blocks[id] = s;
 });
 Object.keys(p.blocks).forEach(function (id) { if (!blocks.has(id)) delete p.blocks[id]; });
 // v03 (26. 10. 2026): úvod stránky (fotka s H1) je vždy první a vždy viditelný, bez ohledu na staré uložené pořadí
 // v04: za úvodem připnutý i výpis (Realizace, Služby, Feed), pokud na stránce hned následuje
 var uvod = originalOrder.filter(function (id) { return blocks.get(id).nodes.some(function (n) { return n.el.matches('.hero,.phero'); }); });
 if (uvod.length) { var dalsi = originalOrder[originalOrder.indexOf(uvod[0]) + 1]; if (dalsi && blocks.get(dalsi).nodes.some(function (n) { return n.el.matches('.vypis') || !!n.el.querySelector('.vypis,.uvod--vypis'); })) uvod.push(dalsi); }
 p.order = uvod.concat(p.order.filter(function (id) { return uvod.indexOf(id) < 0; }));
 p.blocks[uvod[0]] && (p.blocks[uvod[0]].visible = true);
 return p;
}
function contrast(hex) {
 var rgb = [1,3,5].map(function (i) { var c = parseInt(hex.slice(i, i+2),16)/255; return c <= .04045 ? c/12.92 : Math.pow((c+.055)/1.055,2.4); });
 return .2126*rgb[0]+.7152*rgb[1]+.0722*rgb[2] > .179;
}
function panelTop() {
 var top = 112;
 document.querySelectorAll('.nav__home,.nav__logo,.nav__bar,header[role="banner"]').forEach(function (el) {
  var r = el.getBoundingClientRect();
  if (r.height && r.top < 150 && r.bottom < window.innerHeight - 100) top = Math.max(top, r.bottom + 12);
 });
 return Math.min(top, Math.max(16, window.innerHeight - 140));
}
function paint() {
 var css = '#lab2-panel{top:' + panelTop() + 'px;}';
 if (globalState.background) css += 'html,html body{background:' + globalState.background + '!important;}';
 pageState.order.forEach(function (id) {
  var s = pageState.blocks[id];
  if (!s.color) return;
  var light = contrast(s.color);
  css += 'html body main#obsah > [data-blok="' + CSS.escape(id) + '"]{background:' + s.color + '!important;color:' + (light?'#151314':'#FFFFFF') + '!important;--muted:' + (light?'rgba(21,19,20,.62)':'rgba(255,255,255,.66)') + ';--line:' + (light?'rgba(21,19,20,.14)':'rgba(255,255,255,.18)') + ';}';
 });
 style.textContent = css;
}
function apply(persist) {
 MENU.forEach(function (v) { H.classList.toggle('menu-' + v[0], v[0] === globalState.menu); });
 optionDefs.forEach(function (o) {
  o[2].forEach(function (v) { if (v[0]) H.classList.toggle(v[0], globalState.options[o[0]] === v[0]); });
 });
 pageState.order.forEach(function (id) {
  var b = blocks.get(id), s = pageState.blocks[id];
  b.nodes.forEach(function (n) { main.appendChild(n.el); n.el.classList.toggle('lab2-skryto', !s.visible || n.variant !== s.variant); });
 });
 paint();
 if (persist !== false) save();
}
function el(tag, cls, text) { var n = document.createElement(tag); if (cls) n.className = cls; if (text !== undefined) n.textContent = text; return n; }
function button(text, action, label) { var b = el('button','',text); b.type = 'button'; if (action) b.dataset.action = action; if (label) b.setAttribute('aria-label',label); return b; }
function select(values, label) { var s = el('select'); s.setAttribute('aria-label',label); values.forEach(function (v) { var o = el('option','',v[1]); o.value = v[0]; s.appendChild(o); }); return s; }
function field(label, control) { var l = el('label','lab2-field'); l.append(el('span','',label),control); return l; }
function colorInput(label) { var i = el('input'); i.type='color'; i.setAttribute('aria-label',label); return i; }
function section(title) { var s = el('section','lab2-section'); s.appendChild(el('h3','',title)); panel.appendChild(s); return s; }
function renderRows() {
 list.replaceChildren();
 pageState.order.forEach(function (id, index) {
  var b = blocks.get(id), s = pageState.blocks[id], row = el('li','lab2-block'); row.dataset.block = id;
  var head = el('div','lab2-row');
  var handle = el('span','lab2-handle','⋮⋮'); handle.title='Přetáhnout blok'; handle.setAttribute('aria-hidden','true');
  var check = el('input'); check.type='checkbox'; check.checked=s.visible; check.dataset.control='visible';
  var show = field('Zobrazit', check); show.classList.add('lab2-show'); check.setAttribute('aria-label','Zobrazit: ' + b.name);
  head.append(handle, el('strong','lab2-name',b.name),show);
  var up = button('↑','up','Posunout nahoru: ' + b.name), down = button('↓','down','Posunout dolů: ' + b.name);
  up.disabled=index===0; down.disabled=index===pageState.order.length-1;
  head.append(up,down); row.appendChild(head);
  if (b.nodes.length > 1) {
   var variants = select(b.nodes.map(function (n) { return [n.variant,n.name]; }), 'Varianta: ' + b.name);
   variants.value=s.variant; variants.dataset.control='variant'; row.appendChild(field('Varianta',variants));
  }
  var colors = select([['','Výchozí'],['#FFFFFF','Bílá'],['#0B0A0A','Černá'],['#EDECE7','Béžová'],['custom','Vlastní']], 'Barva: ' + b.name);
  colors.value = !s.color ? '' : ['#FFFFFF','#0B0A0A','#EDECE7'].indexOf(s.color)>=0 ? s.color : 'custom'; colors.dataset.control='color';
  var custom = colorInput('Vlastní barva: ' + b.name); custom.value=s.color || '#EDECE7'; custom.dataset.control='custom'; custom.hidden=colors.value!=='custom';
  row.append(field('Barva bloku',colors),custom); list.appendChild(row);
 });
}
function sync() {
 menuSelect.value=globalState.menu; layoutField.hidden=globalState.menu!=='v45'; layoutSelect.value=globalState.options.rozl;
 backgroundInput.value=globalState.background || '#FFFFFF';
 extraSelects.forEach(function (s) { s.value=globalState.options[s.dataset.option]; });
}
function change() { apply(); sync(); }
function move(id, target) {
 var i=pageState.order.indexOf(id); if (i<0 || target<0 || target>=pageState.order.length) return;
 pageState.order.splice(i,1); pageState.order.splice(target,0,id); change(); renderRows();
 tell('Blok ' + blocks.get(id).name + ' je na pozici ' + (target+1) + '.');
}
function allConfig() {
 var pages=Object.create(null);
 try { for (var i=0;i<localStorage.length;i++) { var key=localStorage.key(i); if (key.indexOf(PAGE)===0) pages[key.slice(PAGE.length)]=cleanPage(read(key)); } } catch (e) {}
 pages[pageName]=copy(pageState);
 return {version:2, global:copy(globalState), pages:pages};
}
function encode(config) {
 var bytes=new TextEncoder().encode(JSON.stringify(config)), binary='';
 bytes.forEach(function (b) { binary+=String.fromCharCode(b); });
 return btoa(binary).replace(/\+/g,'-').replace(/\//g,'_').replace(/=+$/,'');
}
function decode(value) {
 if (!value || value.length>1500000 || !/^[A-Za-z0-9_-]+$/.test(value)) throw new Error('Neplatný kód');
 var base=value.replace(/-/g,'+').replace(/_/g,'/'); while(base.length%4) base+='=';
 var raw=atob(base), bytes=Uint8Array.from(raw,function (c) { return c.charCodeAt(0); });
 var data=JSON.parse(new TextDecoder('utf-8',{fatal:true}).decode(bytes));
 if (!record(data) || data.version!==2 || !record(data.global) || !record(data.pages) || Object.keys(data.pages).length>500) throw new Error('Neplatná konfigurace');
 return data;
}
function importConfig(value) {
 var token=value.trim();
 if (!/^[A-Za-z0-9_-]+$/.test(token)) token=new URL(token,location.href).searchParams.get('lab');
 var data=decode(token), pages=Object.create(null);
 Object.keys(data.pages).forEach(function (key) { if (key.length<500) pages[key]=cleanPage(data.pages[key]); });
 globalState=cleanGlobal(data.global);
 pageState=reconcile(pages[pageName]);
 try {
  var oldKeys=[]; for(var i=0;i<localStorage.length;i++) if(localStorage.key(i).indexOf(PAGE)===0) oldKeys.push(localStorage.key(i));
  // Resetuje pouze vlastní nastavení laboratoře, žádné soubory ani cizí úložiště.
  oldKeys.forEach(function (key) { localStorage.removeItem(key); });
  Object.keys(pages).forEach(function (key) { localStorage.setItem(PAGE+key,JSON.stringify(pages[key])); });
 } catch (e) { storageWarning=true; }
 apply();
}
function clearLinkParameter() {
 try { var u=new URL(location.href); u.searchParams.delete('lab'); history.replaceState(null,'',u.href); } catch(e) {}
}
function openPanel(open) {
 panel.hidden=!open; trigger.setAttribute('aria-expanded',String(open));
 if(open) { paint(); panel.querySelector('[data-action="close"]').focus(); } else trigger.focus();
}
function setupSortable() {
 if (!window.Sortable) return;
 sortable = new window.Sortable(list, {
  handle:'.lab2-handle', draggable:'.lab2-block', animation:0,
  ghostClass:'lab2-ghost', chosenClass:'lab2-chosen', forceFallback:false,
  onEnd:function (event) {
   var order=Array.from(list.children).map(function (r) { return r.dataset.block; });
   pageState.order=order; change(); renderRows();
   tell('Pořadí bloků bylo změněno přetažením.');
  }
 });
 list.classList.add('lab2-sortable');
}
function init() {
 main=document.getElementById('obsah');
 if (!main || document.getElementById('lab2-panel')) return;
 Array.from(main.children).forEach(function (node) {
  if (!node.hasAttribute('data-blok')) return;
  var id=node.dataset.blok;
  if (!blocks.has(id)) { blocks.set(id,{name:node.dataset.nazev || id,nodes:[],defaultVariant:null}); originalOrder.push(id); }
  var b=blocks.get(id), variant=node.getAttribute('data-varianta') || '';
  b.nodes.push({el:node,variant:variant,name:node.dataset.variantaNazev || variant || 'Výchozí'});
  if (b.defaultVariant===null || node.hasAttribute('data-vychozi')) b.defaultVariant=variant;
 });
 pageState=reconcile(read(PAGE+pageName));
 style=el('style'); style.id='lab2-styl'; document.head.appendChild(style);
 var token=new URLSearchParams(location.search).get('lab');
 if(token) { try { importConfig(token); importMessage='Nastavení z odkazu bylo načteno.'; clearLinkParameter(); } catch(e) { importMessage='Odkaz neobsahuje platné nastavení laboratoře.'; } }
 panel=el('aside','lab2'); panel.id='lab2-panel'; panel.hidden=true; panel.setAttribute('aria-labelledby','lab2-title');
 var header=el('div','lab2-header'), title=el('h2','','Laboratoř'); title.id='lab2-title'; header.append(title,button('Zavřít','close')); panel.appendChild(header);
 var menu=section('Menu'); menuSelect=select(MENU,'Varianta menu'); menuSelect.id='lab2-menu'; menu.appendChild(field('Varianta menu',menuSelect));
 layoutSelect=select(optionDefs[0][2],'Rozložení menu'); layoutSelect.id='lab2-layout'; layoutField=field('Rozložení',layoutSelect); menu.appendChild(layoutField);
 var colors=section('Barvy'); backgroundInput=colorInput('Pozadí stránky'); backgroundInput.id='lab2-background'; colors.appendChild(field('Pozadí stránky',backgroundInput));
 var presets=el('div','lab2-presets'); [['#FFFFFF','Bílá'],['#EDECE7','Béžová'],['#0B0A0A','Černá']].forEach(function (v) { var b=button(v[1],'background'); b.dataset.color=v[0]; presets.appendChild(b); }); presets.appendChild(button('Výchozí','background-default')); colors.appendChild(presets);
 var blockSection=section('Bloky této stránky'); blockSection.appendChild(el('p','lab2-note','Pořadí změňte úchytem ⋮⋮ nebo tlačítky ↑ ↓.'));
 list=el('ol','lab2-blocks'); list.id='lab2-blocks'; blockSection.appendChild(list);
 if (!originalOrder.length) blockSection.appendChild(el('p','','Na této stránce nejsou označené bloky.'));
 var details=el('details','lab2-extra'); details.appendChild(el('summary','','Další volby')); panel.appendChild(details);
 SKUP.forEach(function (group) {
  var g=el('section','lab2-section'); g.appendChild(el('h3','',group[0]));
  group[1].forEach(function (o) { var s=select(o[2],o[1]); s.dataset.option=o[0]; extraSelects.push(s); g.appendChild(field(o[1],s)); }); details.appendChild(g);
 });
 var sharing=section('Přenést nastavení'); sharing.appendChild(button('Zkopírovat nastavení','export'));
 linkField=el('textarea'); linkField.id='lab2-export'; linkField.readOnly=true; linkField.rows=3; sharing.appendChild(field('Odkaz s nastavením',linkField));
 importField=el('textarea'); importField.id='lab2-import'; importField.rows=3; importField.placeholder='Sem vložte odkaz s nastavením'; sharing.append(field('Vložit nastavení',importField),button('Načíst','import'));
 var reset=section('Obnovit nastavení'); reset.append(button('Výchozí pro tuto stránku','reset-page'),button('Výchozí vše','reset-all'));
 status=el('p','lab2-status'); status.id='lab2-status'; status.setAttribute('role','status'); status.setAttribute('aria-live','polite'); panel.appendChild(status);
 trigger=button('Laboratoř'); trigger.id='lab2-trigger'; trigger.className='lab2-trigger'; trigger.setAttribute('aria-controls',panel.id); trigger.setAttribute('aria-expanded','false');
 document.body.append(panel,trigger);
 trigger.addEventListener('click',function () { openPanel(panel.hidden); });
 document.addEventListener('keydown',function (e) { if (e.key==='Escape' && !panel.hidden) { e.preventDefault(); openPanel(false); } });
 panel.addEventListener('input',function (e) {
  var t=e.target;
  if (t===backgroundInput) { globalState.background=color(t.value); change(); }
  if (t.dataset.control==='custom') { var id=t.closest('[data-block]').dataset.block; pageState.blocks[id].color=color(t.value); change(); }
 });
 panel.addEventListener('change',function (e) {
  var t=e.target, row=t.closest('[data-block]');
  if(t===menuSelect) globalState.menu=t.value;
  else if(t===layoutSelect) globalState.options.rozl=t.value;
  else if(t.dataset.option) globalState.options[t.dataset.option]=t.value;
  else if(row) {
   var s=pageState.blocks[row.dataset.block];
   if(t.dataset.control==='visible') s.visible=t.checked;
   if(t.dataset.control==='variant') s.variant=t.value;
   if(t.dataset.control==='color') {
    var custom=row.querySelector('[data-control="custom"]'); custom.hidden=t.value!=='custom';
    s.color=t.value==='custom' ? color(custom.value) : color(t.value);
   }
  }
  change();
 });
 panel.addEventListener('click',async function (e) {
  var b=e.target.closest('button[data-action]'); if(!b) return;
  var action=b.dataset.action, row=b.closest('[data-block]');
  if(action==='close') openPanel(false);
  if(action==='background' || action==='background-default') { globalState.background=color(b.dataset.color); change(); }
  if(action==='up' || action==='down') {
   var id=row.dataset.block; move(id,pageState.order.indexOf(id)+(action==='up'?-1:1));
   var moved=Array.from(list.children).find(function (r) { return r.dataset.block===id; });
   var next=moved.querySelector('[data-action="'+action+'"]'); if(next.disabled) next=moved.querySelector('[data-action="'+(action==='up'?'down':'up')+'"]'); next.focus();
  }
  if(action==='export') {
   var url=new URL(location.href); url.searchParams.set('lab',encode(allConfig())); linkField.value=url.href;
   try { await navigator.clipboard.writeText(url.href); tell('Odkaz byl zkopírován do schránky.'); }
   catch(e) { linkField.focus(); linkField.select(); tell('Odkaz je připraven v poli. Zkopírujte jej ručně.'); }
  }
  if(action==='import') {
   try { importConfig(importField.value); clearLinkParameter(); sync(); renderRows(); tell('Nastavení bylo načteno.'); }
   catch(e) { tell('Nastavení nelze načíst. Vložte platný odkaz z laboratoře.'); }
  }
  if(action==='reset-page' || action==='reset-all') {
   pageState=reconcile(null);
   if(action==='reset-all') {
    globalState=defaultGlobal();
    try { var keys=[]; for(var i=0;i<localStorage.length;i++) if(localStorage.key(i).indexOf(PAGE)===0) keys.push(localStorage.key(i)); keys.forEach(function (key) { localStorage.removeItem(key); }); } catch(e) {}
   }
   clearLinkParameter(); change(); renderRows(); tell(action==='reset-all'?'Všechna nastavení laboratoře byla obnovena.':'Nastavení této stránky bylo obnoveno.');
  }
 });
 apply(); sync(); renderRows(); if(importMessage) tell(importMessage); else if(storageWarning) tell('Nastavení nelze uložit v prohlížeči. Použijte odkaz.');
 window.addEventListener('resize',paint);
 window.addEventListener('storage',function (e) { if(e.key===GLOBAL || e.key===PAGE+pageName || e.key===null) { globalState=cleanGlobal(read(GLOBAL)); pageState=reconcile(read(PAGE+pageName)); apply(false); sync(); renderRows(); } });
 if(window.Sortable) setupSortable();
 else {
  var script=el('script'); script.src='https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js'; script.async=true;
  script.onload=setupSortable; script.onerror=function () { tell('Přetahování není dostupné. Pořadí změňte tlačítky ↑ ↓.'); }; document.head.appendChild(script);
 }
}
if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',init,{once:true}); else init();
})();
