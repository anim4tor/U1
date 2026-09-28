const fs = require('fs');
const path = require('path');

const contentDir = path.join(__dirname, '..', 'public', 'content');

// Helper to parse Kirby txt file into fields
function parseKirbyContent(text) {
    const parts = text.split(/\r?\n----\r?\n/);
    const fields = {};
    for (const part of parts) {
        const match = part.match(/^([a-zA-Z0-9_-]+):\s*([\s\S]*)$/);
        if (match) {
            const key = match[1];
            const val = match[2];
            fields[key] = val;
        }
    }
    return fields;
}

// Helper to stringify fields back to Kirby txt format
function stringifyKirbyContent(fields) {
    const parts = [];
    for (const [key, val] of Object.entries(fields)) {
        parts.push(`${key}: ${val}`);
    }
    return parts.join('\n\n----\n\n') + '\n';
}

// 1. Update Contact
['contact.cz.txt', 'contact.en.txt'].forEach(file => {
    const filePath = path.join(contentDir, 'contact', file);
    if (!fs.existsSync(filePath)) return;
    const content = fs.readFileSync(filePath, 'utf8');
    const fields = parseKirbyContent(content);
    if (!fields['Hero']) {
        const title = fields['Title'] || (file.includes('.cz') ? 'Kontakt' : 'Contact');
        const intro = (fields['Intro'] || '').trim();
        const cover = (fields['Cover'] || '').trim();
        
        const blocks = [
            {
                type: 'heading',
                id: 'hero-head-' + Math.random().toString(36).substring(2, 9),
                isHidden: false,
                content: {
                    text: title,
                    level: 'h1',
                    mod: 'l',
                    hasreveal: 'true',
                    bid: '',
                    attr: '',
                    css: '',
                    href: '',
                    target: 'false',
                    node: ''
                }
            }
        ];
        
        if (cover) {
            blocks.push({
                type: 'cover',
                id: 'hero-cover-' + Math.random().toString(36).substring(2, 9),
                isHidden: false,
                content: {
                    image: [cover],
                    hasparallax: 'false',
                    parallax: 0,
                    hasreveal: 'false',
                    reveal: '',
                    bid: '',
                    attr: '',
                    css: 'overlay__bottom',
                    href: '',
                    target: 'false',
                    node: ''
                }
            });
        }
        
        if (intro) {
            blocks.push({
                type: 'text',
                id: 'hero-text-' + Math.random().toString(36).substring(2, 9),
                isHidden: false,
                content: {
                    text: intro,
                    mod: 'l',
                    face: '',
                    case: 'lower',
                    hasreveal: 'true',
                    bid: '',
                    attr: '',
                    css: '',
                    href: '',
                    target: 'false',
                    node: ''
                }
            });
        }
        
        // Re-order fields: Title, Hero, Cover, Intro, ...
        const newFields = {};
        newFields['Title'] = fields['Title'];
        newFields['Hero'] = JSON.stringify(blocks);
        for (const [k, v] of Object.entries(fields)) {
            if (k !== 'Title' && k !== 'Hero') {
                newFields[k] = v;
            }
        }
        fs.writeFileSync(filePath, stringifyKirbyContent(newFields), 'utf8');
        console.log(`Updated hero in ${filePath}`);
    } else {
        console.log(`Hero already exists in ${filePath}`);
    }
});

// 2. Update Solutions under 3_services
const servicesDir = path.join(contentDir, '3_services');
if (fs.existsSync(servicesDir)) {
    const entries = fs.readdirSync(servicesDir, { withFileTypes: true });
    entries.forEach(entry => {
        if (!entry.isDirectory()) return;
        const subDir = path.join(servicesDir, entry.name);
        ['solution.cz.txt', 'solution.en.txt'].forEach(file => {
            const filePath = path.join(subDir, file);
            if (!fs.existsSync(filePath)) return;
            const content = fs.readFileSync(filePath, 'utf8');
            const fields = parseKirbyContent(content);
            if (!fields['Hero']) {
                const title = fields['Title'] || entry.name;
                const excerpt = (fields['Excerpt'] || '').replace(/<[^>]+>/g, '').trim();
                const intro = (fields['Intro'] || '').replace(/<[^>]+>/g, '').trim();
                const cover = (fields['Cover'] || '').trim();
                const textVal = excerpt || intro;
                
                const blocks = [
                    {
                        type: 'heading',
                        id: 'hero-head-' + Math.random().toString(36).substring(2, 9),
                        isHidden: false,
                        content: {
                            text: title,
                            level: 'h1',
                            mod: 'l',
                            hasreveal: 'true',
                            bid: '',
                            attr: '',
                            css: '',
                            href: '',
                            target: 'false',
                            node: ''
                        }
                    }
                ];
                
                if (cover) {
                    const coverClean = cover.replace(/^-\s*/, '').trim();
                    blocks.push({
                        type: 'cover',
                        id: 'hero-cover-' + Math.random().toString(36).substring(2, 9),
                        isHidden: false,
                        content: {
                            image: [coverClean],
                            hasparallax: 'false',
                            parallax: 0,
                            hasreveal: 'false',
                            reveal: '',
                            bid: '',
                            attr: '',
                            css: 'overlay__bottom',
                            href: '',
                            target: 'false',
                            node: ''
                        }
                    });
                }
                
                if (textVal) {
                    blocks.push({
                        type: 'text',
                        id: 'hero-text-' + Math.random().toString(36).substring(2, 9),
                        isHidden: false,
                        content: {
                            text: textVal,
                            mod: 'l',
                            face: '',
                            case: 'lower',
                            hasreveal: 'true',
                            bid: '',
                            attr: '',
                            css: '',
                            href: '',
                            target: 'false',
                            node: ''
                        }
                    });
                }
                
                const newFields = {};
                newFields['Title'] = fields['Title'];
                newFields['Hero'] = JSON.stringify(blocks);
                for (const [k, v] of Object.entries(fields)) {
                    if (k !== 'Title' && k !== 'Hero') {
                        newFields[k] = v;
                    }
                }
                fs.writeFileSync(filePath, stringifyKirbyContent(newFields), 'utf8');
                console.log(`Updated hero in ${filePath}`);
            } else {
                console.log(`Hero already exists in ${filePath}`);
            }
        });
    });
}
