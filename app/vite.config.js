import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel([
      'resources/js/app.jsx',
    ]),
    react(),
    tailwindcss(),
  ],
});