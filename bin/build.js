const esbuild = require('esbuild')
const isDev = process.argv.includes('--dev')

esbuild
    .build({
        define: {
            'process.env.NODE_ENV': isDev ? `'development'` : `'production'`,
        },
        entryPoints: ['./resources/js/index.js'],
        outfile: './resources/dist/locationpickr-field.js',
        bundle: true,
        sourcemap: isDev ? 'inline' : false,
        sourcesContent: isDev,
        platform: 'neutral',
        mainFields: ['module', 'main'],
        watch: isDev,
        minify: !isDev,
    })
    .catch(() => process.exit(1))
