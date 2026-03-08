/**
 * FCM (Firebase Cloud Messaging) - request token and register with Laravel
 * Uses fetch API - no Firebase JS SDK required for token request (we use web push VAPID)
 * For simplicity: we use Firebase Admin SDK on server; client gets token via firebase/messaging in sw
 *
 * Alternative: Use firebase/messaging getToken() in main thread - works for foreground.
 * Service worker is only needed for background notifications.
 */
import { getMessaging, getToken } from 'firebase/messaging';
import { initializeApp } from 'firebase/app';

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
};

const vapidKey = import.meta.env.VITE_FIREBASE_VAPID_KEY;

let fcmToken = null;

export async function initFcmAndRegister() {
    if (!firebaseConfig.apiKey || !firebaseConfig.projectId || !vapidKey) return null;

    try {
        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        if (!('Notification' in window)) return null;
        if (Notification.permission === 'default') {
            await Notification.requestPermission();
        }
        if (Notification.permission !== 'granted') return null;

        fcmToken = await getToken(messaging, { vapidKey });
        if (fcmToken) {
            await registerTokenWithServer(fcmToken);
        }
        return fcmToken;
    } catch (e) {
        console.warn('FCM init failed:', e);
        return null;
    }
}

async function registerTokenWithServer(token) {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const response = await fetch('/fcm-token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf || '',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ token }),
        credentials: 'same-origin',
    });
    return response.ok;
}
