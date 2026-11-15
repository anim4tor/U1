# Jak si představuji sazbu webu U1
Předání Jiřímu Klusákovi, 1. 11. 2026. Pracovní návrh k domluvě nad provedením.

## Záměr
Navazuji na tvůj původní návrh. Chci zachovat jeho charakter, práci s realizacemi a pohybem, ale sjednotit sazbu napříč celým webem. Nejde jen o homepage: stejnou logiku mají mít služby, projekty, O nás, kariéra, kontakt, feed i dlouhé texty.

## Co jsem připravil
- Proklikávací HTML prototyp všech hlavních typů stránek, včetně detailů služeb a realizací, pozice, článku a pracovních právních stránek.
- Společnou dvanáctisloupcovou mřížku, opakované rozestupy, hierarchii písma a pravidla pro karty, výpisy, FAQ, proces a kontaktní panel.
- Rozpracované texty a jejich zasazení do konkrétních bloků. V65 opravuje zejména nábytek: U1 nemá vlastní výrobu; nábytek na míru zajišťuje s truhláři, má značky Only1 a Only2.
- Tři varianty typografické škály A/B/C a varianty sestavy loga. Výběr ještě není uzavřený.

## Co je pro mě v sazbě důležité
1. Stejný obsah má všude stejnou velikost a podobu. Nadpis bloku, název položky a její popis se musí jasně lišit. FAQ, služby, týmy a karty nesmějí mít pokaždé jinou logiku.
2. Základ tvoří šest rolí: nadpis, výrok, perex, běžný text, štítek a popisek. Základní škála je 54 / 36 / 24 / 16 / 12 px při šířce 1440 px; konečné velikosti doladíme podle variant A/B/C. Dlouhý seznam řešit výběrem či rozbalením, ne drobnějším písmem.
3. Sekce mají být čitelně oddělené barvou. Vycházet z bílé, černé a růžového akcentu U1, béžovou používat střídmě. Podstránky začínají bílou. Rytmus a kompozici posuzovat podle aktuální v65.
4. Záhlaví sekcí, odkazy a šipky mají držet společné hrany. Nevkládat zbytečné štítky ani dekorativní číslování ke každému nadpisu; čísla patří hlavně ke krokům procesu. V nadpisech se vyhýbat „Naše/Náš“.
5. U úvodu homepage vycházet z tvého řešení: střídání fotek, drobné údaje o realizaci a načítací lišta dole na fotce. Chování a proporce doladit podle originálu, ne mechanicky převzít každý detail prototypu.
6. Zachovat rozbalovací navigaci, výpisy s linkou, náhledy služeb u kurzoru, reference pod realizacemi a společný kontaktní panel. Prototyp ukazuje zamýšlené chování, finální implementaci prosím přizpůsob Kirby a mobilům.
7. Dlouhé texty musí být dobře čitelné: rozumná délka řádku, jasné mezititulky, odstavce a česká sazba. Článek bez levé autorské lišty. Nezalomené krátké předložky, čísla s jednotkami a další detaily české sazby ještě vyžadují finální průchod.

## Co ještě není schválené
- Výběr typografické varianty A/B/C a sestavy loga A až E.
- Změna oborového štítku „Výroba“ na „Průmysl“, pražská adresa a přepínání procesu podle typu spolupráce.
- Místa označená [DOPLNIT], [OVĚŘIT] a další pracovní poznámky. Reference, osobní údaje, právní texty a formuláře vyžadují finální kontrolu a napojení.
- Porovnání v64 slouží pouze k výběru typografie. Obsahově je novější v65, nepřebírat z v64 staré formulace o výrobě nábytku.

## Jak podklady číst
Začni souborem OTEVRIT.html a aktuální v65. Dokument PRAVIDLA_VELIKOSTI_v03.md upřesňuje role písma. PRAVIDLA_SAZBY_v02.md a v01 jsou starší základ: při rozporu s tímto předáním a novějšími rozhodnutími je nepřebírat doslova (zejména barevnost, štítky a článek).
HTML/CSS/JS jsou referenční prototyp, nikoli hotová Kirby šablona k nasazení. Součástí je pracovní Laboratoř pro zkoušení variant; ta nepatří do veřejného webu. Případné uložené nastavení v prohlížeči může vzhled prototypu ovlivnit, pro kontrolu použít čisté okno.
Prosím o zhodnocení proveditelnosti, upozornění na slabší místa a návrh dalšího postupu i odhadu práce.
