import './bootstrap'
import '../css/app.css'

import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const app_name = document.getElementsByTagName('title')[0].innerText;

createInertiaApp({
  title: (title) => `${title} - ${app_name}`,
  progress: {
    color: '#9333ea'
  },
  resolve: (name) => resolvePageComponent(`./pages/${name}.jsx`, import.meta.glob('./pages/**/*.jsx')),
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
});