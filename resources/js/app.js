import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// FCM: init when user is logged in and Firebase configured
if (document.body.dataset.fcmInit === '1') {
    import('./fcm.js').then((m) => m.initFcmAndRegister?.()).catch(() => {});
}
