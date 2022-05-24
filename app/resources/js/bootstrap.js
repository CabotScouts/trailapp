import Echo from 'laravel-echo';

window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  wsHost: process.env.MIX_PUSHER_HOST,
  wsPath: process.env.MIX_PUSHER_PATH,
  wsPort: process.env.MIX_PUSHER_PORT,
  wssPort: process.env.MIX_PUSHER_PORT,
  forceTLS: false,
  encrypted: true,
  disableStats: true,
  enabledTransports: ['ws', 'wss'],
});

window.Echo.channel('global').listenToAll((e, d) => { console.log(e, d) });
