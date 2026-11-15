const fs = require('fs');
const path = require('path');

const servicesData = {
  '1_offices': {
    title: 'Kanceláře na klíč',
    category: 'Celý projekt',
    excerpt: '<p>Navrhneme, postavíme a vybavíme vaše kanceláře. Za celý projekt odpovídáme my.</p>',
    intro: '<p>Design & Build u nás znamená návrh a realizaci kanceláří v jedné spolupráci. Jedna smlouva propojí architekturu, stavbu, projektové řízení a vybavení.</p>',
    details: '<p>Začneme společným zadáním: jak vaše firma pracuje a k čemu má nový prostor sloužit. Náš návrh interiéru pak naváže na stavební realizaci a nábytek. Architekti, projektoví manažeři a stavební tým se na projektu podílejí pod jednou střechou.</p><p>Práci ukazujeme na konkrétních realizacích. Pro Direct pojišťovnu v Brně jsme navrhli a realizovali přibližně 2 700 m² kanceláří. Vzniklo 275 stálých míst, 35 sdílených pracovních míst a 24 zasedacích a focus místností. Projekt získal ocenění Kanceláře roku v kategorii Velké kanceláře.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Architektonický návrh interiéru',
        text: 'Koncept, space planning, dispoziční uspořádání a 3D vizualizace přizpůsobené dynamice růstu firmy.'
      },
      {
        title: 'Stavební realizaci a fit-out',
        text: 'Přestavba od holého betonu i refit stávajících prostor, SDK příčky, sklo, podlahy i technické instalace.'
      },
      {
        title: 'Projektové řízení a koordinaci profesí',
        text: 'Kompletní dohled nad rozpočtem, harmonogramem a návazností jednotlivých stavebních a technických řemesel.'
      },
      {
        title: 'Dodávku vybavení a nábytku',
        text: 'Pracovní místa, zasedačky, recepce i relax zóny, včetně autorských řad Only1 a Only2 a zakázkových atypů.'
      },
      {
        title: 'Jednu smlouvu na celý rozsah',
        text: 'Jediný partner, který přebírá plnou právní i realizační garanci za termín, cenu a výslednou kvalitu.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Co znamenají kanceláře na klíč?',
        answer: 'Kanceláře na klíč (model Design & Build) představují kompletní převzetí projektu jedním partnerem. Zajišťujeme vše od úvodní studie a architektonického návrhu přes stavební povolení, výběr materiálů a stavbu až po výrobu nábytku a finální nastěhování.'
      },
      {
        question: 'Kolik stojí kanceláře na klíč?',
        answer: 'Cena se odvíjí od výchozího stavu budovy (shell & core vs. rekonstrukce stávajících kanceláří) a standardu materiálů. Pohybuje se typicky od 15 000 do 35 000 Kč za m². Už v úvodní studii nastavujeme reálný rozpočtový strop, který je pro nás závazný.'
      },
      {
        question: 'Pro jak velké firmy kanceláře realizujete?',
        answer: 'Realizujeme kanceláře pro rostoucí firmy od cca 200 m² až po rozsáhlé korporátní centrály o rozloze 3 000+ m² pro stovky zaměstnanců.'
      },
      {
        question: 'Můžeme využít jen návrh nebo stavební realizaci?',
        answer: 'Ano. Ačkoliv největší úsporu času i nákladů přináší kompletní dodávka pod jednou smlouvou, rádi pro vás zajistíme i samostatný architektonický návrh nebo čistě stavební fit-out podle projektu vašeho architekta.'
      },
      {
        question: 'Jaký je rozdíl mezi Design & Build a klasickým postupem?',
        answer: 'V klasickém postupu najímáte zvlášť architekta a zvlášť generálního dodavatele, což často vede k prodlužování termínů, vícenákladům a přehazování odpovědnosti. V modelu Design & Build odpovídá za celý proces jeden tým od prvního náčrtu po předání klíčů.'
      },
      {
        question: 'Jak dlouho trvá realizace kanceláří na klíč?',
        answer: 'Celý proces od úvodního briefu po nastěhování obvykle trvá 4 až 8 měsíců v závislosti na ploše, technické náročnosti a nutnosti stavebního povolení.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/direct-pojistovna', 'projects/fcc', 'projects/hartmann-rico']
  },

  '2_interior-design': {
    title: 'Návrh interiérů',
    category: 'Celý projekt',
    excerpt: '<p>Navrhneme, jak bude vaše kancelář uspořádaná a jak bude vypadat. Vycházíme z toho, jak vaše firma doopravdy pracuje.</p>',
    intro: '<p>Vycházíme z práce, pro kterou prostor vzniká. Společné jednání, soustředění a každodenní provoz mají v návrhu své místo.</p>',
    details: '<p>S vámi projdeme potřeby týmu a podobu společného zázemí. Z nich vychází uspořádání pracovišť, místností i vybavení. Materiály a barvy řešíme společně s nábytkem a akustikou.</p><p>U Direct pojišťovny jsme zelenou firemní barvu spojili s terakotou, dřevem a živými rostlinami. Součástí kanceláří jsou zasedací i tiché focus místnosti. Návrh pro vás připravíme samostatně nebo na něj navážeme realizací v rámci kanceláří na klíč.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Analýza pracovního prostředí a space planning',
        text: 'Zmapování týmových potřeb, ergonomie, toků pohybu a akustických zón pro klidnou i týmovou práci.'
      },
      {
        title: 'Architektonická studie a 3D vizualizace',
        text: 'Konceptuální návrh, prostorové modely a fotorealistické vizualizace klíčových zón a zasedaček.'
      },
      {
        title: 'Materiálové a barevné řešení interiéru',
        text: 'Vzorkování povrchů, podlah, stěrek, akustických prvků a textilií s ohledem na identitu značky.'
      },
      {
        title: 'Projektová dokumentace pro provedení stavby',
        text: 'Výkresy dispozic, návaznosti elektroinstalací, světel, příček a výrobní výkresy atypického nábytku.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Můžete návrh také postavit?',
        answer: 'Ano, navrhování s vědomím stavební proveditelnosti je naší největší výhodou. Na vytvořený návrh plynule navážeme realizací vlastním stavebním týmem i výrobou nábytku.'
      },
      {
        question: 'Co si připravit pro zadání návrhu?',
        answer: 'Pro začátek nám stačí stavební půdorys v DWG nebo PDF, aktuální počet zaměstnanců, plánovaný růst firmy na další 2–3 roky a představa o fungování jednotlivých týmů.'
      },
      {
        question: 'Co je space planning?',
        answer: 'Space planning je strategické rozvržení prostoru tak, aby podporovalo efektivní komunikaci, eliminovalo rušivé vlivy a nabízelo vyvážený poměr mezi zónami pro soustředění a neformální setkávání.'
      },
      {
        question: 'Co obsahuje návrh interiéru kanceláře?',
        answer: 'Kompletní návrh zahrnuje dispoziční řešení, studii materiálů a barev, vizualizace, specifikaci osvětlení, akustiky a zařizovacích předmětů a prováděcí výkresy pro truhláře a stavbu.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/direct-pojistovna', 'projects/ortho-dent', 'projects/plzensky-prazdroj']
  },

  '3_project-management': {
    title: 'Projektové řízení',
    category: 'Celý projekt',
    excerpt: '<p>Koordinujeme práci profesí, které váš interiér staví a vybavují. Od prvního výkresu po předání klíčů.</p>',
    intro: '<p>Návrh, stavební realizace a dodávky nábytku se potkávají v jednom projektu. Projektovým řízením propojujeme jejich provedení.</p>',
    details: '<p>Na stavbě navazujeme práci jednotlivých profesí na návrh interiéru. Koordinaci propojujeme s dodávkami vybavení a nábytku na míru. V modelu kanceláří na klíč odpovídáme za celý dohodnutý rozsah.</p><p>V CTParku Borská pole jsme koordinovali dva projekty na jedné stavbě. Podle návrhu externího architekta vznikly kanceláře z holého betonu za pět měsíců. Realizace probíhala od května do října.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Projektové řízení realizace interiéru',
        text: 'Jeden dedikovaný projektový manažer jako váš jediný kontaktní partner po celou dobu stavby.'
      },
      {
        title: 'Koordinaci stavebních profesí a subdodavatelů',
        text: 'Přesné řízení časových návazností stavebníků, sádrokartonářů, sklenářů, vzduchotechniků i elektrikářů.'
      },
      {
        title: 'Kontrolu harmonogramu a nákladů',
        text: 'Průběžné vyhodnocování prostavěnosti a důsledné hlídání schváleného rozpočtu bez nemilých překvapení.'
      },
      {
        title: 'Přejímací řízení a kolaudační součinnost',
        text: 'Odstranění drobných vad a nedodělků před předáním, kompletace revizních zpráv a dokumentace skutečného provedení.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Je projektové řízení součástí kanceláří na klíč?',
        answer: 'Ano, v modelu kanceláří na klíč je kompletní projektový management automaticky zahrnut v ceně. Přebíráme veškerou koordinaci, takže vy nemusíte trávit čas na stavbě.'
      },
      {
        question: 'Koordinujete i realizaci podle externího návrhu?',
        answer: 'Určitě. Často řídíme realizace interiérů, které navrhlo jiné renomované architektonické studio. Hlídáme, aby výsledek do detailu odpovídal autorskému záměru.'
      },
      {
        question: 'Jak nás informujete o nákladech a změnách?',
        answer: 'Každý týden probíhají kontrolní dny s písemným zápisem a fotodokumentací. Jakékoliv klientské změny jsou předem naceněny a realizují se až po vašem schválení.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/ctpark-borska-pole', 'projects/direct-pojistovna', 'projects/hartmann-rico']
  },

  '4_fit-out': {
    title: 'Fit-out a stavební úpravy',
    category: 'Celý projekt',
    excerpt: '<p>Stavíme nové prostory a přestavujeme stávající. Samostatně nebo v rámci kanceláří na klíč.</p>',
    intro: '<p>Fit-out zajistíme samostatně nebo jako součást kanceláří na klíč. Rozsah stavební realizace vychází z projektu a stavu prostoru.</p>',
    details: '<p>Realizujeme kanceláře od holého betonu (shell & core) i úpravy již používaných interiérů. Stavební práce propojujeme s projektovým řízením a koordinací profesí. Navazujeme na vlastní návrh nebo na projekt architektonického studia.</p><p>V CTParku Borská pole v Plzni jsme podle externího návrhu postavili kanceláře za pět měsíců. U Direct pojišťovny v Brně jsme spojili rekonstrukci a novostavbu do jednoho funkčního celku.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Fit-out nových prostor (Shell & Core)',
        text: 'Kompletní vestavba kanceláří od základních betonových konstrukcí přes instalace až po finální povrchy.'
      },
      {
        title: 'Refit a rekonstrukce stávajících kanceláří',
        text: 'Modernizace dispozic, výměna podlah, úpravy akustiky a osvětlení za provozu či v etapách.'
      },
      {
        title: 'Stavební realizaci podle vlastního i externího návrhu',
        text: 'Precizní provedení detailů s respektem k autorskému záměru a technickým normám budovy.'
      },
      {
        title: 'Inženýring a jednání se správou budovy',
        text: 'Zajištění vstupů, požární ochrany, koordinace s technickým dozorem pronajímatele a revize.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Jaký je rozdíl mezi fit-outem a refitem?',
        answer: 'Fit-out je kompletní stavební dobudování nového surového prostoru (shell & core). Refit je přestavba a modernizace stávajících, již dříve využívaných kanceláří.'
      },
      {
        question: 'Máte zkušenost s realizací od holého betonu?',
        answer: 'Ano, máme desítky úspěšných realizací ve špičkových administrativních budovách a business parcích po celé ČR (např. CTParky, Vlněna, Titanium).'
      },
      {
        question: 'Realizujete fit-out i podle projektu jiného architekta?',
        answer: 'Ano, velmi úzce a rádi spolupracujeme s externími architekty a designovými studii, kterým garantujeme přesné dodržení jejich projektu.'
      },
      {
        question: 'Patří k fit-outu také návrh a nábytek?',
        answer: 'Může i nemusí. Pokud máte zájem pouze o stavební fit-out, zrealizujeme jej samostatně. V rámci kanceláří na klíč však zajistíme i návrh a kompletní nábytkové vybavení.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/ctpark-borska-pole', 'projects/fcc', 'projects/direct-pojistovna']
  },

  '5_interior-tailoring': {
    title: 'Nábytek Only1, Only2 a atypy na míru',
    category: 'Nábytek a vybavení',
    excerpt: '<p>Navrhneme nábytek přesně pro váš prostor, od pracovních míst po recepci. Vlastní oceněné řady Only1 a Only2 i zakázková výroba.</p>',
    intro: '<p>Atypický nábytek připravujeme s ověřenými truhláři, se kterými dlouhodobě spolupracujeme. Návrh, technické detaily, výrobu i montáž hlídáme sami, takže nábytek sedí na stavbu i na rozpočet.</p>',
    details: '<p>Nábytek dodáme jako součást kanceláří na klíč, k projektu jiného architektonického studia, nebo samostatně. Only1 a Only2 jsou vlastní nábytkové řady U1. Řada Only2 získala na Designbloku cenu Nejlepší novinka výrobce.</p><p>Pro Plzeňský Prazdroj jsme zajistili atypický nábytek, recepci s rozřezaným pivním kegem a designové podhledy. V Restauraci Evropa v Praze jsme vytvořili truhlářské obklady, kazetový podhled a bar z trapézového plechu. Nábytek jsme dodali i pro kliniku Ortho Dent ve spolupráci s HUA HUA Architects.</p>',
    includesHeadline: 'Co zajistíme',
    includes: [
      {
        title: 'Atypický nábytek a recepce na míru',
        text: 'Výroba dominantních recepcí, barů, kuchyněk, skříňových stěn a akustických obkladů s prověřenými truhláři.'
      },
      {
        title: 'Autorské nábytkové řady Only1 a Only2',
        text: 'Designové stoly, kontejnery a doplňky oceněné na Designbloku, vyvinuté speciálně pro komerční interiéry.'
      },
      {
        title: 'Truhlářské prvky pro komerční interiéry',
        text: 'Kombinace masivu, dýhy, kovu, skla a moderních kompaktních desek s důrazem na extrémní odolnost.'
      },
      {
        title: 'Kompletní montáž a záruční servis',
        text: 'Vlastní zkušení montážníci, čisté předání a dlouhodobý servis vybavení.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Kdo nábytek na míru vyrábí?',
        answer: 'Výrobu koordinujeme přímo my ve spolupráci s dlouhodobě prověřenými českými truhlářskými mistry a výrobci kovových konstrukcí. Na každý detail dohlíží naši konstruktéři.'
      },
      {
        question: 'Co umíte dodat na míru?',
        answer: 'Prakticky jakýkoliv atypický prvek – od monumentálních recepcí a barových pultů přes akustické obklady stěn, vestavěné kuchyňky až po atypické zasedací stoly s integrovanou kabeláží.'
      },
      {
        question: 'Co jsou Only1 a Only2?',
        answer: 'Jde o vlastní autorské nábytkové řady navržené v U1. Vyznačují se minimalistickou geometrií, vysokou odolností a flexibilitou. Řada Only2 získala prestižní cenu na Designbloku za Nejlepší novinku výrobce.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/volareza-restaurace-evropa', 'projects/plzensky-prazdroj', 'projects/ortho-dent']
  },

  '6_realizace-pro-architekty': {
    title: 'Realizace pro architekty',
    category: 'Celý projekt',
    excerpt: '<p>Postavíme interiér přesně podle vašeho návrhu. Vy držíte autorství, my držíme řemeslo a termín.</p>',
    intro: '<p>Můžete nám svěřit čistě stavební realizaci nebo ji rozšířit o nábytek na míru. Rozsah spolupráce vymezíme podle vašeho projektu.</p>',
    details: '<p>Na dodaný návrh navážeme fit-outem a koordinací stavebních profesí. Zajistíme také nábytek na míru s ověřenými truhláři pro atypické prvky. Při prezentaci projektu striktně oddělujeme autora návrhu od naší role v realizaci.</p><p>V CTParku Borská pole jsme postavili kanceláře podle externího návrhu. Pro Ortho Dent jsme ve spolupráci s HUA HUA Architects dodali nábytek, elektromontáže a podlahy s maximálním respektem k architektonickému detailu.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Čistě stavební realizaci podle projektu studia',
        text: 'Spolehlivý generální dodavatel pro váš architektonický koncept bez kompromisů v kvalitě.'
      },
      {
        title: 'Koordinaci stavebních profesí a subdodávek',
        text: 'Přebíráme starosti s koordinací profesí, harmonogramem a technickými návaznostmi na stavbě.'
      },
      {
        title: 'Dodávku atypického nábytku na míru',
        text: 'Přesné technické rozkreslení a výroba vámi navržených atypických prvků s našimi prověřenými truhláři.'
      },
      {
        title: 'Respekt k autorství a férová prezentace',
        text: 'Plně ctíme vaše autorská práva – v referencích a médiích vždy uvádíme architektonické studio jako autora návrhu.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Realizujete interiéry podle návrhu jiného studia?',
        answer: 'Ano, je to významná část naší práce. Fungujeme jako spolehlivý partner pro architektonická studia, která hledají generálního dodavatele schopného zrealizovat i ty nejnáročnější detaily.'
      },
      {
        question: 'Komu zůstává autorství návrhu?',
        answer: 'Autorství vždy a bezezbytku zůstává vám. My vystupujeme výhradně v roli dodavatele stavby a interiéru.'
      },
      {
        question: 'Můžete zajistit také nábytek na míru?',
        answer: 'Ano, máme bohaté zázemí konstruktérů a prověřených truhlářů, kteří přesně podle vašich výkresů vyrobí recepce, obklady i nábytkové solitérní kusy.'
      },
      {
        question: 'Zajistíte i technické dopracování návrhu?',
        answer: 'Ano, rádi vám pomůžeme s technickou proveditelností, výběrem stavebních materiálů, detaily návazností nebo optimalizací rozpočtu.'
      }
    ],
    workModel: 'Dodavatel stavby a interiérů',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/ortho-dent', 'projects/ctpark-borska-pole']
  },

  '7_ceilings': {
    title: 'Stropy a akustické podhledy',
    category: 'Stavba a technika',
    excerpt: '<p>Akustická pohoda, designové podhledy i netradiční materiály – od plechovek po dřevěné lamely.</p>',
    intro: '<p>Realizujeme akustické podhledy a atypické stropy podle návrhu interiéru. U původních podhledů s vámi probereme možnost dalšího využití.</p>',
    details: '<p>Atypické stropní prvky na míru. V Direct pojišťovně jsme repasovali původní akustické podhledy a znovu je začlenili do interiéru, čímž jsme ušetřili finance i životní prostředí.</p><p>Pro Plzeňský Prazdroj jsme zajistili originální podhledy z pivních plechovek. V Restauraci Evropa jsme uplatnili truhlářskou výrobu při provedení kazetového podhledu. Atypická řešení tak propojujeme s výrobou na míru a realizací interiéru.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Akustické podhledy a prostorové absorbéry',
        text: 'Závěsné panely, basové pasti a podhledy z minerálních vláken pro snížení doby dozvuku v kanceláři.'
      },
      {
        title: 'Repase a upcycling původních podhledů',
        text: 'Ekologické a úsporné čištění, lakování a opětovné využití stávajících rastrových konstrukcí.'
      },
      {
        title: 'Atypické stropní instalace na míru',
        text: 'Lamelové stropy, tahokov, otevřené industriální stropy i unikátní designové instalace.'
      },
      {
        title: 'Integraci technologií a svítidel do stropů',
        text: 'Bezchybné zapuštění vzduchotechnických vyústek, sprinklerů, čidel a lineárních svítidel.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Lze původní podhledy zachovat a repasovat?',
        answer: 'Ano, pokud je nosný rastr v pořádku, můžeme stávající minerální či kazetové desky repasovat, opatřit novým nástřikem nebo zkombinovat s novými akustickými panely, což výrazně šetří rozpočet.'
      },
      {
        question: 'Realizujete stropy také mimo kanceláře?',
        answer: 'Ano, akustické a atypické stropy realizujeme v restauracích (např. Restaurace Evropa), na klinikách, v showroomech i ve veřejných prostorech.'
      },
      {
        question: 'Mohou být podhledy součástí větší rekonstrukce?',
        answer: 'Běžně jsou stropy a podhledy klíčovou součástí komplexního fit-outu, kde je koordinujeme s rozvody vzduchotechniky, elektroinstalací a osvětlením.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/plzensky-prazdroj', 'projects/direct-pojistovna', 'projects/volareza-restaurace-evropa']
  },

  '8_electrical': {
    title: 'Elektroinstalace a osvětlení',
    category: 'Stavba a technika',
    excerpt: '<p>Od rozvodů v podlahách po svítidla na míru. Technologie sladěná s architekturou interiéru.</p>',
    intro: '<p>Elektromontáže zajišťujeme v rámci realizace interiéru podle projektu. Propojujeme silnoproud, slaboproud a designové osvětlení.</p>',
    details: '<p>Elektromontáže můžeme propojit s dodávkou nábytku a podlah. Rozsah spolupráce vymezíme podle vašeho projektu.</p><p>Pro Ortho Dent v brněnské Vlněně jsme dodali elektromontáže, nábytek a podlahy ve spolupráci s HUA HUA Architects. Součástí interiéru jsou na míru vyráběná svítidla inspirovaná bavlnkou. Realizujeme také projekty externích studií s kompletní garancí revizí.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Silnoproudé a slaboproudé rozvody',
        text: 'Kabeláže, podlahové krabice (florpoxy), datové sítě, serverovny a záložní zdroje UPS.'
      },
      {
        title: 'Návrh a dodávku designového osvětlení',
        text: 'Pracovní, nepřímé i akcentové osvětlení, LED profily na míru a chytré řízení osvětlení (DALI).'
      },
      {
        title: 'Chytré ovládání zasedaček a AV technika',
        text: 'Rezervační systémy místností, audio-video technika a automatizace scén osvětlení.'
      },
      {
        title: 'Výchozí revizní zprávy a dokumentace',
        text: 'Kompletní certifikace, revize elektroinstalací a předání dokumentace skutečného provedení stavby.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Realizujete elektroinstalace i podle externího návrhu?',
        answer: 'Ano, elektroinstalace běžně provádíme podle projektové dokumentace zpracované externím projektantem či architektem.'
      },
      {
        question: 'Dodáváte také designová a atypická svítidla?',
        answer: 'Dodáváme kompletní portfolio technických i dekorativních svítidel renomovaných evropských značek a umíme zajistit i výrobu atypických svítidel na zakázku.'
      },
      {
        question: 'Zahrnuje dodávka kompletní revize a protokoly?',
        answer: 'Samozřejmostí každé naší zakázky je vystavení výchozí revizní zprávy nutné ke kolaudaci a bezpečnému provozu budovy.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/ortho-dent', 'projects/ctpark-borska-pole']
  },

  '9_equipment': {
    title: 'Vybavení interiérů',
    category: 'Nábytek a vybavení',
    excerpt: '<p>Kompletní dodávka nábytku, svítidel i doplňků sladěná do jednoho funkčního celku.</p>',
    intro: '<p>Recepce, zasedací místnosti a společné zázemí mají každý svůj účel. Jejich vybavení propojujeme s návrhem celé kanceláře.</p>',
    details: '<p>Vybavení kanceláří zahrnujeme do kanceláří na klíč. Návrh, stavbu a nábytek tak řešíme společně. Atypické prvky pro konkrétní interiér zajišťujeme s prověřenými truhláři.</p><p>Rozsah společného zázemí ukazuje Direct pojišťovna: čtyři kuchyňky, multifunkční místnost a 24 zasedacích a focus místností. Pro Hartmann Rico jsme modernizovali vstupní halu, recepci, zasedací místnost a jídelnu. Naše práce tak zahrnuje veškeré části firemního zázemí.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Vybavení zasedacích místností a focus roomů',
        text: 'Reprezentativní stoly s kabelovými průchodkami, pohodlná konferenční křesla a tabule.'
      },
      {
        title: 'Kuchyňky, kavárny a jídelní zóny',
        text: 'Odolné kuchyňské linky, vestavěné spotřebiče, barové stoličky a jídelní sezení.'
      },
      {
        title: 'Relaxační zóny a telefonní budky',
        text: 'Modulární pohovky, křesla, akustické budky pro soukromé hovory a zeleň.'
      },
      {
        title: 'Doplňky, navigace a orientační systém',
        text: 'Závěsy, koberce, odpadkové koše na tříděný odpad a firemní branding v prostoru.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Jak se liší vybavení interiéru od dodávky nábytku?',
        answer: 'Vybavení interiéru zahrnuje celistvé řešení – nejen stoly a židle, ale i akustické prvky, kuchyňské zázemí, vestavné skříně, osvětlení, stínění a doplňky potřebné k okamžitému užívání.'
      },
      {
        question: 'Umíte vybavit i reprezentativní recepci nebo jídelnu?',
        answer: 'Ano, máme bohaté zkušenosti s náročnými společnými zónami, jako jsou firemní restaurace, kavárny, reprezentativní recepce i eventové sály.'
      },
      {
        question: 'Lze vybavení zahrnout do jedné smlouvy se stavbou?',
        answer: 'Ano, v tom spočívá výhoda modelu na klíč. Získáte jednu smlouvu, jeden harmonogram a jedinou záruku na stavební práce i veškeré vybavení.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/volareza-restaurace-evropa', 'projects/direct-pojistovna', 'projects/hartmann-rico']
  },

  '10_flooring': {
    title: 'Podlahy a krytiny',
    category: 'Stavba a technika',
    excerpt: '<p>Koberce, vinyl i stěrky vybrané s ohledem na provoz, zátěž a akustiku kanceláře.</p>',
    intro: '<p>Podlahy dodáváme jako součást realizace kanceláří i dalších interiérů. Navazujeme na architektonický návrh a požadavky na provoz.</p>',
    details: '<p>Podlahy dodáváme také při spolupráci s architektonickými studii. Navazujeme na jejich návrh a dohodnutý rozsah realizace.</p><p>V CTParku Borská pole jsme při realizaci kanceláří použili prémiové kobercové čtverce Shaw Contract. Podlahy jsme dodali také pro Ortho Dent v Brně, kde jsme spolupracovali s HUA HUA Architects. Vedle podlah jsme pro kliniku zajistili nábytek a elektromontáže.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Zátěžové kobercové čtverce a role',
        text: 'Akustické koberce navržené speciálně pro kancelářský provoz s vysokou odolností proti opotřebení.'
      },
      {
        title: 'Vinylové dílce (LVT) a designové stěrky',
        text: 'Praktické a odolné podlahy do kuchyněk, chodeb a recepcí s věrnou texturou dřeva či betonu.'
      },
      {
        title: 'Příprava podkladu a samonivelační stěrky',
        text: 'Broušení, penetrace a nivelace podkladů pro dokonale rovný a stabilní povrch.'
      },
      {
        title: 'Zdvojené podlahy pro vedení instalací',
        text: 'Systémové zdvojené podlahy umožňující flexibilní vedení kabelů přímo pod pochozí vrstvou.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Dodáváte podlahy také podle návrhu jiného studia?',
        answer: 'Ano, dodávku a pokládku podlah realizujeme přesně podle materiálové specifikace vašeho architekta.'
      },
      {
        question: 'Jaké podlahové krytiny do kanceláří doporučujete?',
        answer: 'Do kanceláří doporučujeme kombinaci zátěžových kobercových čtverců (pro akustiku a komfort v pracovních zónách) a vinylu LVT či litých stěrek (do chodeb a kuchyněk pro snadnou údržbu).'
      },
      {
        question: 'Lze podlahy řešit současně s ostatními pracemi?',
        answer: 'Ano, pokládku přesně časujeme v rámci harmonogramu stavby po dokončení prašných prací a malířských úprav.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/ctpark-borska-pole', 'projects/fcc', 'projects/ortho-dent']
  },

  '11_furniture': {
    title: 'Kancelářský nábytek',
    category: 'Nábytek a vybavení',
    excerpt: '<p>Pracovní stoly, ergonomické židle, akustické budky a úložné systémy prověřených značek.</p>',
    intro: '<p>Nábytkovou dodávku propojujeme s uspořádáním interiéru. Vedle vybavení pracovních míst řešíme také recepce a společné zázemí.</p>',
    details: '<p>Nábytek na míru dodáváme s ověřenými truhláři. Nábytek můžeme zahrnout do celého projektu kanceláří nebo dodat samostatně. Konkrétní rozsah vychází z vašeho návrhu a zadání.</p><p>Pro Plzeňský Prazdroj jsme zajistili dodávku typového i atypického nábytku a recepci. Nábytek jsme dodali také pro kliniku Ortho Dent a desítky dalších prostor po celé republice.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Výškově stavitelné a ergonomické stoly',
        text: 'Elektricky polohovatelné stoly umožňující střídání práce vsedě a vestoje pro zdraví zaměstnanců.'
      },
      {
        title: 'Prémiové ergonomické pracovní židle',
        text: 'Certifikované pracovní židle s širokými možnostmi nastavení a dlouhou zárukou.'
      },
      {
        title: 'Akustické budky a mikrokanceláře',
        text: 'Odhlučněné telefonní budky pro 1, 2 nebo 4 osoby s ventilací a elektrickými zásuvkami.'
      },
      {
        title: 'Úložné systémy, skříňky a lockery',
        text: 'Zamykatelné osobní skříňky (lockery) pro flexibilní kanceláře a systémové úložné stěny.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Můžeme si objednat nábytek bez celé stavby?',
        answer: 'Ano, dodávku nového kancelářského nábytku, židlí nebo akustických budek realizujeme i samostatně pro již zařízené kanceláře.'
      },
      {
        question: 'Jaký kancelářský nábytek dodáváte?',
        answer: 'Dodáváme vlastní oceňované řady Only1 a Only2, zakázkový truhlářský nábytek na míru i typové produkty od předních evropských výrobců ergonomických židlí a akustických budek.'
      },
      {
        question: 'Nabízíte kancelářský nábytek také k pronájmu?',
        answer: 'Pro vybrané projekty a dočasné prostory nabízíme možnost operativního financování a pronájmu nábytkového vybavení.'
      },
      {
        question: 'Můžeme nábytek zahrnout do kanceláří na klíč?',
        answer: 'Ano, to je nejpřirozenější cesta – nábytek je pak od začátku navržen v souladu s dispozicemi a technologiemi prostoru.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/fcc', 'projects/direct-pojistovna', 'projects/plzensky-prazdroj']
  },

  '12_air-conditioning': {
    title: 'Vzduchotechnika a chlazení',
    category: 'Stavba a technika',
    excerpt: '<p>Čerstvý vzduch a stabilní klima. Koordinujeme profesi, která rozhoduje o komfortu lidí v kanceláři.</p>',
    intro: '<p>Vzduchotechnika, chlazení a vytápění jsou klíčem ke spokojenosti zaměstnanců. Zajišťujeme jejich úpravy v návaznosti na nové dispozice interiéru.</p>',
    details: '<p>Při změně dispozic kanceláří, vzniku nových zasedaček nebo uzavřených kanceláří je nutné přizpůsobit vzduchotechniku a chlazení. Zajišťujeme koordinaci s technickým vybavením budovy i přesné dimenzování pro počet osob v místnosti.</p><p>K zadání přiložte půdorys a popis plánovaného využití místností. Pokud máte dokumentaci stávajícího TZB budovy, připojte ji také. Zajišťujeme fit-out kanceláří podle vlastního i externího návrhu s garancí správné funkce.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Úpravy a rozšíření rozvodů VZT a chlazení',
        text: 'Přesunutí vyústek, úpravy potrubních tras a instalace fan-coilových jednotek podle nových dispozic.'
      },
      {
        title: 'Větrání a chlazení zasedacích místností',
        text: 'Samostatná regulace přívodu vzduchu a chlazení v exponovaných jednacích a focus místnostech.'
      },
      {
        title: 'Koordinaci s technickým managementem budovy',
        text: 'Jednání se správcem budovy, respektování limitů centrálního TZB systému a tlakových poměrů.'
      },
      {
        title: 'Zaregulování soustavy, měření a předání revizí',
        text: 'Změření průtoků vzduchu, hlučnosti a předání protokolů o zaregulování pro bezproblémový provoz.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Je vzduchotechnika součástí fit-outu kanceláří?',
        answer: 'Ano, úpravy VZT a chlazení tvoří podstatnou a kritickou část každé přestavby či fit-outu kanceláří.'
      },
      {
        question: 'Jaké podklady vám máme poslat?',
        answer: 'Ideální je výkres stávajícího stavu TZB v DWG od správy budovy a nový plánovaný dispoziční půdorys s počty lidí v místnostech.'
      },
      {
        question: 'Řešíte také chlazení a vytápění?',
        answer: 'Ano, vzduchotechniku koordinujeme společně s chlazením (fan-coily, VRV systémy) a otopnými tělesy do jednoho funkčního celku.'
      },
      {
        question: 'S kým koordinujete napojení na budovu?',
        answer: 'Veškerá napojení a technické parametry koordinujeme přímo s technickým dozorem a facility manažerem dané administrativní budovy.'
      }
    ],
    workModel: 'Součást fit-outu nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/ctpark-borska-pole', 'projects/fcc']
  },

  '13_partitions': {
    title: 'Příčky a prosklené stěny',
    category: 'Stavba a technika',
    excerpt: '<p>Oddělíme zasedačky i focus roomy s důrazem na akustiku a světlo v celém prostoru.</p>',
    intro: '<p>Příčky začleňujeme do stavební realizace podle návrhu kanceláře. K zadání patří rozmístění místností a požadavky na soukromí a akustiku.</p>',
    details: '<p>V CTParku Borská pole jsme použili skleněné příčky LIKO-S s vysokým akustickým útlumem. Kanceláře jsme realizovali podle návrhu externího architekta z holého betonu.</p><p>Dodávku řešíme v rámci fit-outu kanceláří. Podle projektu kombinujeme bezrámové prosklené stěny, dvojskla, sádrokartonové mezibytové a kancelářské příčky s integrovanými hliníkovými či dřevěnými dveřmi.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Jednoduše i dvojitě zasklené systémové příčky',
        text: 'Bezrámové i rastrové skleněné stěny s vysokou propustností světla a čistým minimalistickým detailem.'
      },
      {
        title: 'Špičkový akustický útlum až 49 dB',
        text: 'Spolehlivé odhlučnění jednacích místností a ředitelských kanceláří zabraňující úniku citlivých informací.'
      },
      {
        title: 'Sádrokartonové a akustické plné stěny',
        text: 'Masivní SDK konstrukce s minerální izolací pro technické místnosti, kuchyňky i hygienická zázemí.'
      },
      {
        title: 'Dveřní systémy a chytré doplňky',
        text: 'Skleněné, dýhované i laminované dveře s padacími prahy, magnetickými zámky a možností nalepení fólií.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'S jakými příčkami máte zkušenost?',
        answer: 'Pravidelně realizujeme systémy od předních výrobců jako LIKO-S, Dorma, Vertic i klasické SDK akustické stěny Knauf a Rigips.'
      },
      {
        question: 'Provedete příčky podle projektu našeho architekta?',
        answer: 'Ano, přesně dodržíme specifikaci profilů, barevnosti i typu zasklení navrženou vaším architektem.'
      },
      {
        question: 'Jaké akustické parametry příčky splňují?',
        answer: 'Standardní jednoduše zasklené příčky dosahují útlumu cca 32–36 dB, dvojitě zasklené stěny s akustickou fólií a padacím prahem dosahují útlumu 42 až 49 dB, což zaručuje absolutní diskrétnost.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/ctpark-borska-pole', 'projects/direct-pojistovna']
  },

  '14_surfaces': {
    title: 'Povrchy a materiály',
    category: 'Stavba a technika',
    excerpt: '<p>Stěrky, tapety, obklady a dřevo. Vybíráme materiály, které vydrží každodenní intenzivní provoz.</p>',
    intro: '<p>Materiály a povrchy řešíme jako součást návrhu i realizace interiéru. Barvy, obklady a nábytek skládáme do společného řešení.</p>',
    details: '<p>V Direct pojišťovně jsme plechovou recepci doplnili terakotovým obkladem. Zelenou firemní barvu v interiéru doprovází přírodní dřevo a rostliny. Barevnost značky tak získala konkrétní fyzickou podobu v prostoru.</p><p>V Restauraci Evropa jsme při rekonstrukci v historickém prostředí vytvořili bar z trapézového plechu a kazetový podhled. Podobné prvky propojujeme s truhlářskou výrobou na míru.</p>',
    includesHeadline: 'Co zahrnuje',
    includes: [
      {
        title: 'Pohledové betonové a designové stěrky',
        text: 'Pandomo, mikrocement a stěrky s industriálním i sametovým finišem pro reprezentativní plochy.'
      },
      {
        title: 'Dřevěné a akustické obklady stěn',
        text: 'Dýhované panely, laťování z masivu a perforované akustické desky pro vizuální teplo a tlumení hluku.'
      },
      {
        title: 'Keramické obklady a plechové detaily',
        text: 'Mozaiky, velkoformátové dlažby, trapézové plechy a lakované kovové prvky pro specifický styl interiéru.'
      },
      {
        title: 'Odolné malby a omyvatelné nátěry',
        text: 'Prémiové otěruvzdorné barvy a tapety testované pro vysokou frekvenci pohybu osob v chodbách a open-space.'
      }
    ],
    faqHeadline: 'Časté otázky',
    faq: [
      {
        question: 'Můžete do interiéru zapracovat firemní barvy?',
        answer: 'Ano, firemní identitu a barvy převádíme do materiálů přirozeným způsobem – od stěrek a látek až po práškově lakované kovy či obklady.'
      },
      {
        question: 'Vyrobíte i atypický prvek z navrženého materiálu?',
        answer: 'Ano, máme zkušenosti s netradičními materiály, jako jsou trapézové plechy, pivní sudy, plechovky, surová ocel či terakota.'
      },
      {
        question: 'Můžeme si předem prohlédnout vzorky materiálů?',
        answer: 'Samozřejmě. Pro každý projekt připravujeme fyzický vzorkovník (moodboard) materiálů, textilií a povrchů, který si společně odsouhlasíme před objednáním.'
      }
    ],
    workModel: 'Design & Build nebo samostatně',
    location: 'Celá Česká republika a Slovensko',
    relatedProjects: ['projects/direct-pojistovna', 'projects/ortho-dent', 'projects/volareza-restaurace-evropa']
  }
};

const baseDir = path.join(__dirname, '..', 'public', 'content', '3_services');

function parseKirbyContent(content) {
  const parts = content.split(/\r?\n----\r?\n/);
  const fields = {};
  for (const part of parts) {
    const colonIdx = part.indexOf(':');
    if (colonIdx !== -1) {
      const key = part.slice(0, colonIdx).trim().toLowerCase();
      const val = part.slice(colonIdx + 1).trim();
      fields[key] = val;
    }
  }
  return fields;
}

function yamlStructure(items) {
  let out = '';
  for (const item of items) {
    out += '\n- \n';
    for (const [k, v] of Object.entries(item)) {
      if (typeof v === 'string' && (v.includes('\n') || v.includes(':') || v.includes('"') || v.includes("'"))) {
        out += `  ${k}: >\n    ${v.replace(/\r?\n/g, '\n    ')}\n`;
      } else {
        out += `  ${k}: ${v}\n`;
      }
    }
  }
  return out;
}

function yamlList(items) {
  let out = '';
  for (const item of items) {
    out += `\n- ${item}`;
  }
  return out;
}

for (const [folder, data] of Object.entries(servicesData)) {
  const filePath = path.join(baseDir, folder, 'solution.cz.txt');
  if (!fs.existsSync(filePath)) {
    console.warn(`File not found: ${filePath}`);
    continue;
  }

  const origContent = fs.readFileSync(filePath, 'utf8');
  const origFields = parseKirbyContent(origContent);

  // Preserve essential original fields if present
  const cover = origFields['cover'] || '';
  const uuid = origFields['uuid'] || '';
  const gallery = origFields['gallery'] || '';
  const hero = origFields['hero'] || '';

  let newContent = `Title: ${data.title}

----

Category: ${data.category}

----

Excerpt: ${data.excerpt}

----

Intro: ${data.intro}

----

Details: ${data.details}

----

Includesheadline: ${data.includesHeadline}

----

Includes:${yamlStructure(data.includes)}

----

Faqheadline: ${data.faqHeadline}

----

Faq:${yamlStructure(data.faq)}

----

Workmodel: ${data.workModel}

----

Location: ${data.location}

----

Relatedprojects:${yamlList(data.relatedProjects)}`;

  if (gallery) {
    newContent += `\n\n----\n\nGallery: ${gallery}`;
  }
  if (cover) {
    newContent += `\n\n----\n\nCover: ${cover}`;
  }
  if (hero) {
    newContent += `\n\n----\n\nHero: ${hero}`;
  }
  if (uuid) {
    newContent += `\n\n----\n\nUuid: ${uuid}`;
  }

  newContent += '\n';

  fs.writeFileSync(filePath, newContent, 'utf8');
  console.log(`Updated: ${folder}/solution.cz.txt`);
}

console.log('All 14 services updated successfully!');
