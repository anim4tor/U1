# Pravidla sazby webu U1 — štítky nad nadpisy sekcí

Zdroj: rešerše `~/AI/Pracovna/U1/Web/resers_stitky_sekci_v01.md` (Revana + 6 studií + design systémy), homepage_v02.

## Pravidlo (platí pro celý web)

1. Štítek dát jen tam, kde doplní kategorii, fázi nebo orientaci, kterou nadpis sám neříká.
2. Vynechat u hero, u samovysvětlujícího nadpisu, u opakovaných karet a u CTA, kde by jen zopakoval text tlačítka nebo nadpisu.
3. Štítek max 1–3 krátká slova, bez tečky, jednotná kapitalizace.
4. Na stránce používat jeden vizuální styl štítku a nasazovat ho střídmě, ne u každé sekce automaticky.
5. Číslo u štítku jen tam, kde vyjadřuje skutečné pořadí (např. kroky postupu). Dekorativní číslování sekcí (01, 02, 03…) se nepoužívá.
6. Krátká linka je volitelný oddělovač štítku, ne povinná součást — používat místo čísla tam, kde štítek zůstává, ale pořadí nic neznamená.
7. Štítek je vizuální doplněk, nikdy náhrada sémantického nadpisu (h2 apod.).

## Homepage — rozhodnutí podle pravidla (v03)

| Sekce | Štítek | Proč |
|---|---|---|
| Úvod (hero) | ne | Hero claim je samovysvětlující, pravidlo 2 |
| Studio (o nás) | ano | Sekce nemá h2, jen odstavec — štítek je jediná orientace, pravidlo 1 |
| Vybrané realizace | ne | H2 „Vybrané realizace" už kategorii říká, štítek by ji jen opakoval, pravidlo 2 |
| Náš proces | ne (u sekce) | H2 „Náš proces" je samovysvětlující; čísla kroků 1–5 zůstávají, protože vyjadřují skutečné pořadí, pravidlo 5 |
| Naše řešení | ne | H2 „Naše řešení" už kategorii říká, pravidlo 2 |
| Napsali o nás | ano | Sekce nemá h2, štítek je jediný nadpis nad logy, pravidlo 1 |
| Naše týmy | ne | H2 „Naše týmy" už kategorii říká, pravidlo 2 |
| Články | ne | H2 „Články" už kategorii říká, „Feed" by byl jen interní žargon navíc, pravidlo 2 |
| Kontakt (výzva) | ano | Nadpis je motivační věta, neříká, že jde o kontakt/CTA sekci, pravidlo 1 |

Zůstávající štítky (Studio, Napsali o nás, Kontakt) jsou bez čísla, s krátkou linkou (pravidlo 5 a 6).
