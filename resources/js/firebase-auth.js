import { signInWithFirebaseGoogle } from './firebase.js';

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('firebase-google-btn');
    const errEl = document.getElementById('firebase-error');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        btn.disabled = true;
        errEl.classList.add('hidden');
        errEl.textContent = '';
        try {
            const idToken = await signInWithFirebaseGoogle();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/auth/firebase/verify';
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
            form.innerHTML = `<input type="hidden" name="_token" value="${csrf}"><input type="hidden" name="id_token" value="${idToken}">`;
            document.body.appendChild(form);
            form.submit();
        } catch (e) {
            errEl.textContent = e.message || 'Firebase sign-in failed.';
            errEl.classList.remove('hidden');
            btn.disabled = false;
        }
    });
});
