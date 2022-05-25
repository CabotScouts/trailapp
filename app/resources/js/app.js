require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { createInertiaApp } from '@inertiajs/inertia-react';
import { InertiaProgress } from '@inertiajs/progress';
import Global from '@/layouts/global';

const app_name = document.getElementsByTagName('title')[0].innerText;

createInertiaApp({
  title: (title) => `${title} - ${app_name}`,
  resolve: (name) => {
    const page = require(`./pages/${name}`).default;
    if(page.layout === undefined && !name.startsWith('admin/')) {
      page.layout = Global;
    }
    return page;
  },
  setup({ el, App, props }) {
    return render(<App {...props} />, el);
  },
});

InertiaProgress.init({ color: '#9333ea' });
