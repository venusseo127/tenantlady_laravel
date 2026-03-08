import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage } from 'firebase/messaging';

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
};

let messaging = null;

if (firebaseConfig.apiKey && firebaseConfig.projectId && firebaseConfig.messagingSenderId) {
    const app = initializeApp(firebaseConfig);
    messaging = getMessaging(app);
}

export { messaging };

export async function requestFcmToken(vapidKey) {
    if (!messaging || !vapidKey) return null;
    if (!('Notification' in window) || Notification.permission !== 'granted') {
        const perm = await Notification.requestPermission();
        if (perm !== 'granted') return null;
    }
    return getToken(messaging, { vapidKey });
}

export function onForegroundMessage(callback) {
    if (!messaging) return () => {};
    return onMessage(messaging, callback);
}
