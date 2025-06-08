/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './node_modules/tw-elements/dist/js/**/*.js',
    './public/icons/*.css',
    "./node_modules/flowbite/**/*.js",
    "transform: (content) => content.replace(/taos:/g, '')"
  ],
  safelist: [
    'w-64',
    'w-1/2',
    'rounded-l-lg',
    'rounded-r-lg',
    'bg-gray-200',
    'grid-cols-4',
    'grid-cols-7',
    'h-6',
    'leading-6',
    'h-9',
    'leading-9',
    'shadow-lg',
    'bg-opacity-50',
    'dark:bg-opacity-80',
    '!duration-[0ms]',
    '!delay-[0ms]',
    'html.js :where([class*="taos:"]:not(.taos-init))'
  ],
  theme: {
    container: {
      center: true,
      padding: "2rem",
    },
    extend: {
      colors: {
        primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a" },
        main : "#1A1C1E",
        main2 : "#F0CC80",
        main3 : "#F9F9F9",
        main4 : "#303234",
        main5 : "#5e6061",
        main6 : "#0d0e0f"
      },
      fontFamily: {
        'sans': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
        'body': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
        'mono': ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace']
      },
      transitionProperty: {
        'width': 'width'
      },
      textDecoration: ['active'],
      minWidth: {
        'kanban': '28rem'
      },
      transitionTimingFunction: {
        'in-expo': 'cubic-bezier(0.95, 0.05, 0.795, 0.035)',
        'out-expo': 'cubic-bezier(0.19, 1, 0.22, 1)',
        'ease-in-out': 'cubic-bezier(0.4, 0, 0.2, 1)',
        
      },

      boxShadow: {
        best: "0px 2px 5px -1px rgba(50, 50, 93, 0.25),  0px 1px 3px -1px rgba(0, 0, 0, 0.3)",
        best4: "0px 2px 5px -1px rgba(255, 255, 255, 0.25),  0px 1px 3px -1px rgba(255, 255, 255, 0.3)",
        best2: "rgb(204, 219, 232) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset",
        best3: "rgba(0, 0, 0, 0.35) 0px -7px 9px -7px inset;",
        best4: "rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;",
        best5: "rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;",
        taos: '0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.02)',
        md: '0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -1px rgba(0, 0, 0, 0.02)',
        lg: '0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.01)',
        xl: '0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.01)',
        smooth: 'rgba(149, 157, 165, 0.2) 0px 8px 24px'
        
      },

      outline: {
        blue: '2px solid rgba(0, 112, 244, 0.5)',
        },
        fontFamily: {
            inter: ['Inter', 'sans-serif'],
        },
        fontSize: {
            xs: ['0.75rem', { lineHeight: '1.5' }],
            sm: ['0.875rem', { lineHeight: '1.5715' }],
            base: ['1rem', { lineHeight: '1.5', letterSpacing: '-0.01em' }],
            lg: ['1.125rem', { lineHeight: '1.5', letterSpacing: '-0.01em' }],
            xl: ['1.25rem', { lineHeight: '1.5', letterSpacing: '-0.01em' }],
            '2xl': ['1.5rem', { lineHeight: '1.33', letterSpacing: '-0.01em' }],
            '3xl': ['1.88rem', { lineHeight: '1.33', letterSpacing: '-0.01em' }],
            '4xl': ['2.25rem', { lineHeight: '1.25', letterSpacing: '-0.02em' }],
            '5xl': ['3rem', { lineHeight: '1.25', letterSpacing: '-0.02em' }],
            '6xl': ['3.75rem', { lineHeight: '1.2', letterSpacing: '-0.02em' }],
        },
      animation: {
        best: "slide_top 4s infinite",
        best1: "slide_bottom 4s infinite",
        best2: "slide_top 4s infinite",
        best3: "slide_bottom 4s infinite",
        fadeIn : "fadeIn 1s ease-in-out infinite",
        tada: 'tada 1s ease-in-out infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '1' },
          '100%': { opacity: '0.3' },
        },
        tada: {
          '0%': {
            transform: 'scale(1)',
          },
          '10%, 20%': {
            transform: 'scale(0.9) rotate(-3deg)',
          },
          '30%, 50%, 70%, 90%': {
            transform: 'scale(1.1) rotate(3deg)',
          },
          '40%, 60%, 80%': {
            transform: 'scale(1.1) rotate(-3deg)',
          },
          '100%': {
            transform: 'scale(1) rotate(0)',
          },
        }
      },
      transitionDelay: {
        delay: '150ms'
      }
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('daisyui'),
    

  ],

  safelist: [
    '!duration-0',
    '!delay-0',
    'html.js :where([class*="taos:"]:not(.taos-init))'
  ]
}
