# Pravidla sazby webu U1, v02 (20. 10. 2026)
Platí pro celý web. Nahrazuje nahodilou sazbu verzí 1 a 2 (audit: ~/AI/Pracovna/U1/Sazba_webu_2026/audit_v01/POROVNANI_verzi_v01.md).
Pravidla štítků z PRAVIDLA_SAZBY_v01.md platí dál. Co tu není povolené, je zakázané. Žádné inline styly, žádné výjimky pro jednu stránku.

## 1. Mřížka a jednotka
- 12 sloupců, okraj 4u, mezera 2u. u = 20 px na 1440 (plynule, min. 14 px).
- Povolené dělení: 12 | 8+4 | 7+5 | 6+6 | 4+4+4 | 3+3+3+3. Jiné šířky prvků nejsou.
- Textový sloupec (souvislý text) má vždy 6 sloupců. Nikdy širší.

## 2. Role písma (Manrope). Jedna role = jedna přesná kombinace
| Role | Velikost / řádkování | Řez | Kde |
|---|---|---|---|
| Nadpis | 54 / 1,05 | 500, prostrkání -0,025em | H1 všech stránek, H2 sekcí, čísla v přehledu |
| Výrok | 36 / 1,15 | 500 | text Studia, citace, mezititulky v textovém sloupci, navigace patičky není |
| Perex | 24 / 1,3 | 500 | úvodní perex, názvy karet a položek, otázky FAQ, název v patičce |
| Text | 16 / 1,5 | 500 (tučně jen `strong` 700 v souvislém textu) | odstavce, seznamy, tabulky, odkazy, formuláře |
| Štítek | 12 / 1,5 | 600, verzálky, +0,08em | štítek sekce, tlačítka, menu, nadpisy sloupců patičky, filtry |
| Popisek | 12 / 1,5 | 500 | datum, rok, lokalita, údaje v tabulce parametrů, popisky fotek, právní řádek |
Jiná velikost, řádkování nebo řez se nesmí objevit. Barva: text plná, vedlejší text `--muted`, akcent jen pro aktivní položku, odkaz v textu a tlačítko.

## 3. Mezery (násobky u)
- Sekce: nahoře i dole 5u. Výjimky jen dvě: úvod homepage (celá výška okna) a pás log 2,5u.
- Úvod podstránky: nahoře 9u (místo pro menu), dole 5u.
- Štítek → nadpis 1u. Nadpis → perex 1u. Záhlaví sekce → obsah 3u. Skupina → skupina uvnitř sekce 4u.
- Fotka → popisek 1u. Popisek → název 0,5u. Název → text 0,5u. Odstavec → odstavec 1u. Mezititulek v textu: nad 3u, pod 1u.
- Karty v mřížce: vodorovně 2u, svisle 3u.

## 4. Komponenty (jen tyto)
1. **Menu**: beze změny (sloupce 4 až 9).
2. **Úvod homepage**: střídající se fotky realizací, lišta a titulek dole. Jen na homepage.
3. **Úvod podstránky**: drobečky (popisek) · H1 (nadpis) přes 1 až 7 · perex (text, muted) v 8 až 12 na účaří posledního řádku H1 · volitelně fotka přes 12 sloupců v poměru 2:1. Fotku mají služba, realizace, o nás, kariéra, kontakt. Bez fotky jsou výpisy (realizace, služby, feed) a právní stránky.
4. **Záhlaví sekce**: (štítek) · H2 přes 1 až 7 · perex v 8 až 12 na účaří, nebo šipky karuselu vpravo na účaří. Vždy stejné, nikdy na střed.
5. **Dělený blok (TYP 1)**: text 6 | fotka 6 (4:3), záhlaví nahoře, seznam na spodní hraně fotky. Seznam položek: perex 24, aktivní akcent; dlouhý seznam (nad 6) ve 2 sloupcích textem 16.
6. **Položky (TYP 2)**: záhlaví sekce vlevo 1 až 5 | položky 2 × 3 sloupce v 7 až 12: číslo nebo ikona (popisek), název (perex), text (text).
7. **Karty (TYP 3)**: 3 karty po 4 sloupcích. Fotka 4:3 · popisek · název (perex) · volitelně text. Jedna anatomie karty pro realizace, služby, články i pozice s fotkou.
8. **Karusel**: karta 3 sloupce, stejná anatomie jako TYP 3. Fotka 4:3, jen karusel realizací na homepage 3:4.
9. **Celoplošná fotka (TYP 4)**: hodnoty, záložky výrokem 36.
10. **Pás (TYP 5)**: štítek 1 až 3 | obsah 4 až 12.
11. **Textová stránka**: levý sloupec 1 až 4 (parametry, obsah článku, kontakt k pozici; přilepený při scrollu) | text v 6 až 11. Platí pro detail realizace, detail služby, pozici, článek a právní stránky. Fotky v textové stránce: přes 12 sloupců 2:1, nebo dvojice 6 | 6 4:3.
12. **Tabulka parametrů**: řádky s linkou, popisek | text, v levém sloupci textové stránky.
13. **Řádky**: název (perex) 1 až 6 | údaj (popisek) 7 až 10 | šipka 12 (pozice, ocenění).
14. **FAQ**: záhlaví sekce, otázky (perex) v 6 až 11 rozbalovací, odpovědi text.
15. **Výzva**: portrét 3 | nadpis 6 | tlačítko 3, na černé. Tlačítko otevírá kontaktní panel.
16. **Kontaktní panel**: vyskakuje vpravo dole, záložky Kontakt | Poptávka (štítek), obsah perex a text. Jediný formulář webu.
17. **Patička**: černá. Logo a claim (perex) 1 až 4 · 4 sloupce po 2 (nadpis štítek, odkazy text) · právní řádek popisek.
Tlačítka: dva druhy, výška 2,4u, text ve stylu štítek: plné (akcent) a obrysové. Kruhové šipky 2,6u. Filtry 2u.

## 5. Fotky
Poměry jen tři: 4:3 (výchozí, karty, dělený blok, fotky v textu), 3:4 (karusel realizací na homepage a portréty), 2:1 (fotka v úvodu podstránky a široká fotka v textu). Rádius 0,5u, sekce 1u.

## 6. Pozadí a rytmus
Stránka teplá šedá, sekce jako zaoblené karty. Střídat bílá a teplá. Černá jen pro: vybrané realizace a řešení na homepage, ocenění, jednu zvýrazněnou sekci podstránky a výzvu. Dvě černé sekce nikdy za sebou, kromě výzvy a patičky.

## 7. Konec každé stránky
Stejný všude: karusel Článků (kromě článku samotného a právních stránek) · výzva · patička.

## 8. Kontrola
Každá verze projde skriptem auditu (audit.mjs): povolených kombinací písma je 6 (+ `strong`), odsazení sekcí 3 hodnoty (5u, úvod podstránky, pás), 0 inline stylů, poměry fotek 3. Výsledek se zapisuje k verzi.
