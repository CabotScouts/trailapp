require('./bootstrap');

import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client'
import Global from '@/layouts/global';

const app_name = document.getElementsByTagName('title')[0].innerText;

createInertiaApp({
  title: (title) => `${title} - ${app_name}`,
  progress: {
    color: '#9333ea'
  },
  resolve: (name) => {
    const page = require(`./pages/${name}`).default;
    if (page.layout === undefined && !name.startsWith('admin/')) {
      page.layout = Global;
    }
    return page;
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
});