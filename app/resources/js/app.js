require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { createInertiaApp } from '@inertiajs/inertia-react';
import { InertiaProgress } from '@inertiajs/progress';

const app_name = document.getElementsByTagName('title')[0].innerText;

createInertiaApp({
  title: (title) => `${title} - ${app_name}`,
  resolve: (name) => require(`./pages/${name}`),
  setup({ el, App, props }) {
    return render(<App {...props} />, el);
  },
});

InertiaProgress.init({ color: '#9333ea' });
