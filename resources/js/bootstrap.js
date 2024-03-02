/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     // wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsHost: window.location.hostname,
//     wssPort: 6001,
//     // wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     // forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     forceTLS: false,
//     enabledTransports: ['ws', 'wss'],
// });

window.Echo = new Echo({
    // broadcaster: 'pusher',
    // // key: process.env.MIX_PUSHER_APP_KEY,
    // key: 'websocket-key',
    // // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    // cluster: 'mt1',
    // // forceTLS: true,
    // // wsHost: window.location.hostname,
    // // wsPort: 6001

    // wsHost: process.env.MIX_PUSHER_HOST, //window.location.hostname,
    // wsPort: 6001,
    // wssPort: 6001,
    // disableStats: true,
    // forceTLS: true,
    // encrypted: true,
    // enabledTransports: ['ws','wss'],

    broadcaster: 'pusher',
    key: 'websocket-key',
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
    forceTLS: true,
    encrypted: true,
    wssPort: 6001,
    enabledTransports: ['ws','wss'],

});

