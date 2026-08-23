const fs = require('fs');
const path = require('path');
const sass = require('sass');

const isMinify = process.argv.includes('--minify');

const targets = [
  {
    input: path.resolve(__dirname, '../site/assets/css/theme.scss'),
    output: path.resolve(__dirname, '../public/assets/css/theme.dist.css'),
    name: 'theme.dist.css'
  },
  {
    input: path.resolve(__dirname, '../site/assets/css/app.scss'),
    output: path.resolve(__dirname, '../public/assets/css/app.dist.css'),
    name: 'app.dist.css'
  }
];

function compileCss() {
  const startTime = Date.now();
  try {
    for (const target of targets) {
      if (!fs.existsSync(target.input)) continue;

      const sassResult = sass.compile(target.input, {
        loadPaths: [
          path.resolve(__dirname, '../site/assets/css'),
          path.resolve(__dirname, '../site'),
          path.resolve(__dirname, '..'),
        ],
        style: isMinify ? 'compressed' : 'expanded',
        sourceMap: false,
        quietDeps: true,
        silenceDeprecations: ['import', 'slash-div', 'global-builtin', 'color-functions'],
      });

      const outputDir = path.dirname(target.output);
      if (!fs.existsSync(outputDir)) {
        fs.mkdirSync(outputDir, { recursive: true });
      }

      fs.writeFileSync(target.output, sassResult.css);
    }
    const duration = Date.now() - startTime;
    console.log(`[CSS] Compiled theme & app in ${duration}ms -> public/assets/css/`);
  } catch (err) {
    console.error(`[CSS Error]`, err.message || err);
  }
}

if (require.main === module) {
  compileCss();
}

module.exports = { compileCss };
