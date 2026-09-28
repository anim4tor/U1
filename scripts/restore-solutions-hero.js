const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const contentDir = path.join(__dirname, '..', 'public', 'content');
const servicesDir = path.join(contentDir, '3_services');

// Helper to parse Kirby txt file content accurately
function parseKirbyRaw(rawText) {
    // Kirby fields are separated by \n----\n or \r\n----\r\n
    // Field name starts at beginning of block followed by :
    const rawBlocks = rawText.split(/\r?\n----\r?\n/);
    const fields = {};
    for (const b of rawBlocks) {
        const idx = b.indexOf(':');
        if (idx !== -1) {
            const key = b.slice(0, idx).trim();
            const val = b.slice(idx + 1).replace(/^\r?\n/, '');
            fields[key] = val;
        }
    }
    return fields;
}

function stringifyKirbyRaw(fields) {
    const parts = [];
    for (const [key, val] of Object.entries(fields)) {
        parts.push(`${key}: ${val}`);
    }
    return parts.join('\n\n----\n\n') + '\n';
}

function randomId() {
    return 'block-' + Math.random().toString(36).substring(2, 10);
}

const entries = fs.readdirSync(servicesDir, { withFileTypes: true });

entries.forEach(entry => {
    if (!entry.isDirectory()) return;
    const subDir = path.join(servicesDir, entry.name);
    
    ['solution.cz.txt', 'solution.en.txt'].forEach(filename => {
        const gitPath = `public/content/3_services/${entry.name}/${filename}`;
        const filePath = path.join(subDir, filename);
        
        let originalContent = '';
        try {
            originalContent = execSync(`git show f4898d74:${gitPath}`, { encoding: 'utf8' });
        } catch (e) {
            if (fs.existsSync(filePath)) {
                originalContent = fs.readFileSync(filePath, 'utf8');
            } else {
                return;
            }
        }
        
        const fields = parseKirbyRaw(originalContent);
        const title = (fields['Title'] || entry.name).trim();
        const excerpt = (fields['Excerpt'] || '').replace(/<[^>]+>/g, '').trim();
        const intro = (fields['Intro'] || '').replace(/<[^>]+>/g, '').trim();
        const coverRaw = (fields['Cover'] || '').trim();
        
        let coverFiles = [];
        if (coverRaw) {
            coverRaw.split(/\r?\n/).forEach(line => {
                const cleaned = line.replace(/^-\s*/, '').trim();
                if (cleaned) {
                    coverFiles.push(cleaned);
                }
            });
        }
        
        const heroBlocks = [
            {
                type: 'heading',
                id: randomId(),
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
        
        if (coverFiles.length > 0) {
            heroBlocks.push({
                type: 'cover',
                id: randomId(),
                isHidden: false,
                content: {
                    image: coverFiles,
                    hasparallax: 'false',
                    parallax: 0,
                    hasreveal: 'false',
                    reveal: '',
                    bid: '',
                    attr: '',
                    css: 'overlay__harder',
                    href: '',
                    target: 'false',
                    node: ''
                }
            });
        }
        
        const textVal = excerpt || intro;
        if (textVal) {
            heroBlocks.push({
                type: 'text',
                id: randomId(),
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
        newFields['Title'] = title;
        newFields['Hero'] = JSON.stringify(heroBlocks);
        for (const [k, v] of Object.entries(fields)) {
            if (k !== 'Title' && k !== 'Hero') {
                newFields[k] = v;
            }
        }
        
        fs.writeFileSync(filePath, stringifyKirbyRaw(newFields), 'utf8');
        console.log(`Successfully built ${gitPath} with Cover: ${coverFiles.join(', ')}`);
    });
});
