const withOpacity = (variableName, fallback) => {
  return ({ opacityValue }) => {
    if (opacityValue !== undefined) {
      return `color-mix(in srgb, var(${variableName}, ${fallback}) calc(${opacityValue} * 100%), transparent)`;
    }
    return `var(${variableName}, ${fallback})`;
  };
};

module.exports = {
  corePlugins: {
    preflight: false,
  },
  content: [
    "./site/components/**/*.php",
    "./site/components/**/*.js",
    "./site/templates/**/*.php",
    "./site/snippets/**/*.php",
    "./public/content/**/*.txt",
    "./public/content/**/*.json",
    "./public/index.php",
    "./index.php",
  ],
  theme: {
    extend: {
      colors: {
        prim: withOpacity('--color-prim', '#ED1359'),
        sec: withOpacity('--color-sec', '#EDECE7'),
        acc: withOpacity('--color-acc', '#ED1359'),
        light: withOpacity('--color-light', '#EDECE7'),
        dark: withOpacity('--color-dark', '#000000'),
        text: withOpacity('--color-text', '#151314'),
        invert: withOpacity('--color-invert', '#FFFFFF'),
        neon: '#f4ee32',
        lime: '#ddf432',
        yellow: '#f4cd32',
        orange: '#f49a32',
        red: '#db6b57',
        crimson: '#db5f7e',
        pink: '#d56ff7',
        purple: '#986ff7',
        blue: '#034dbc',
        marine: '#7fc2db',
        cyan: '#11b5bb',
      },
      fontFamily: {
        heading: ['var(--ff-heading)', 'sans-serif'],
        body: ['var(--ff-body)', 'sans-serif'],
        sans: ['Inter', 'sans-serif'],
      },
      fontSize: {
        'xs': 'calc(var(--output-size, 1rem) * 0.8)',
        's': 'calc(var(--output-size, 1rem) * 0.9)',
        'sm': 'calc(var(--output-size, 1rem) * 0.9)',
        'small': 'calc(var(--output-size, 1rem) * 0.9)',
        'base': 'calc(var(--output-size, 1rem) * 1)',
        'df': 'calc(var(--output-size, 1rem) * 1)',
        'default': 'calc(var(--output-size, 1rem) * 1)',
        'm': 'calc(var(--output-size, 1rem) * 1.25)',
        'md': 'calc(var(--output-size, 1rem) * 1.25)',
        'l': 'calc(var(--output-size, 1rem) * 1.5)',
        'lg': 'calc(var(--output-size, 1rem) * 1.5)',
        'large': 'calc(var(--output-size, 1rem) * 1.5)',
        'xl': 'calc(var(--output-size, 1rem) * 2)',
        'xxl': 'calc(var(--output-size, 1rem) * 3)',
        '2xl': 'calc(var(--output-size, 1rem) * 3)',
        '3xl': 'calc(var(--output-size, 1rem) * 3)',
        '1': 'var(--font-size-1)',
        '2': 'var(--font-size-2)',
        '3': 'var(--font-size-3)',
        '4': 'var(--font-size-4)',
        '5': 'var(--font-size-5)',
      },
      spacing: {
        '01': 'calc(0.1 * var(--spacing))',
        '02': 'calc(0.2 * var(--spacing))',
        '03': 'calc(0.3 * var(--spacing))',
        '05': 'calc(0.5 * var(--spacing))',
        '1': 'calc(1 * var(--spacing))',
        '2': 'calc(2 * var(--spacing))',
        '3': 'calc(3 * var(--spacing))',
        '4': 'calc(4 * var(--spacing))',
        '5': 'calc(5 * var(--spacing))',
        '6': 'calc(6 * var(--spacing))',
        '8': 'calc(8 * var(--spacing))',
        '10': 'calc(10 * var(--spacing))',
      },
      opacity: {
        '2': '0.2',
        '4': '0.4',
        '5': '0.5',
        '6': '0.6',
        '8': '0.8',
      },
      borderRadius: {
        'img': 'calc(var(--img-radius, 0.75) * 1em)',
        'radius': 'calc(var(--radius, 1.5) * 1em)',
      },
      screens: {
        'mobile': {'max': '768px'},
      }
    },
  },
  plugins: [
    function({ addUtilities }) {
      const fontSizes = {
        '1': { '--output-size': 'calc(var(--font-size-1))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-1)' },
        '2': { '--output-size': 'calc(var(--font-size-2))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-2)' },
        '3': { '--output-size': 'calc(var(--font-size-3))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-3)' },
        '4': { '--output-size': 'calc(var(--font-size-4))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-4)' },
        '5': { '--output-size': 'calc(var(--font-size-5))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-5)' },
        'small': { '--output-size': 'calc(var(--font-size-small))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-small)' },
        'default': { '--output-size': 'calc(var(--font-size-default))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-default)' },
        'large': { '--output-size': 'calc(var(--font-size-large))', 'font-size': 'var(--output-size)', 'line-height': 'var(--line-height-large)' },
      };

      const utilities = {};
      for (const [key, val] of Object.entries(fontSizes)) {
        utilities[`.font-size-${key}`] = val;
        utilities[`.font__size__${key}`] = val;
      }
      addUtilities(utilities, ['responsive']);

      const vhUtilities = {};
      const vwUtilities = {};
      for (let i = 1; i <= 20; i++) {
        const vhVal = `${i * 5}vh`;
        const vwVal = `${i * 5}vw`;
        vhUtilities[`.vh-${i}`] = { height: vhVal };
        vhUtilities[`.vh__${i}`] = { height: vhVal };
        vhUtilities[`.h-vh-${i}`] = { height: vhVal };
        
        vwUtilities[`.vw-${i}`] = { width: vwVal };
        vwUtilities[`.vw__${i}`] = { width: vwVal };
        vwUtilities[`.w-vw-${i}`] = { width: vwVal };
      }
      addUtilities(vhUtilities, ['responsive']);
      addUtilities(vwUtilities, ['responsive']);

      // Color and text utilities that set --col
      const colorMap = {
        prim: 'var(--color-prim, #ED1359)',
        sec: 'var(--color-sec, #EDECE7)',
        acc: 'var(--color-acc, #ED1359)',
        light: 'var(--color-light, #EDECE7)',
        dark: 'var(--color-dark, #000000)',
        text: 'var(--color-text, #151314)',
        invert: 'var(--color-invert, #FFFFFF)',
        white: '#FFFFFF',
        black: '#000000',
        neon: '#f4ee32',
        lime: '#ddf432',
        yellow: '#f4cd32',
        orange: '#f49a32',
        red: '#db6b57',
        crimson: '#db5f7e',
        pink: '#d56ff7',
        purple: '#986ff7',
        blue: '#034dbc',
        marine: '#7fc2db',
        cyan: '#11b5bb',
      };

      const alphas = [5, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
      const colorUtilities = {};
      for (const [name, val] of Object.entries(colorMap)) {
        colorUtilities[`.text-${name}`] = { '--col': val, 'color': 'var(--col)' };
        colorUtilities[`.color-${name}`] = { '--col': val, 'color': 'var(--col)' };
        colorUtilities[`.color__${name}`] = { '--col': val, 'color': 'var(--col)' };

        for (const a of alphas) {
          const alphaVal = `color-mix(in srgb, ${val} ${a}%, transparent)`;
          colorUtilities[`.text-${name}\\/${a}`] = { '--col': alphaVal, 'color': 'var(--col)' };
          colorUtilities[`.color-${name}\\/${a}`] = { '--col': alphaVal, 'color': 'var(--col)' };
          colorUtilities[`.color__${name}\\/${a}`] = { '--col': alphaVal, 'color': 'var(--col)' };
        }
      }
      addUtilities(colorUtilities, ['responsive', 'hover']);
    }
  ],
};
