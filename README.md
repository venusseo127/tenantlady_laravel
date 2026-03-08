# tenantlady — Landlord & Tenant Billing

Mobile-first landlord & tenant management platform for small landlords in the Philippines.

## Features

- **Landlord Dashboard** — KPIs, listings overview, bills due/paid
- **Listings** — Rooms, houses, apartments (CRUD)
- **Tenants** — Manage tenants per listing
- **Billing** — Water, electricity, internet, rent, other (meter-based or fixed)
- **Payment Proof** — Tenants upload proof; landlords approve
- **Subscription Plans** — Free (1), Starter (4), Pro (∞), Business (∞)
- **Referral Program** — Referral links and codes
- **Admin Dashboard** — Users, subscriptions, analytics

## Tech Stack

- Laravel 11
- MySQL / SQLite
- Tailwind CSS
- Laravel Breeze + Socialite (Google/Facebook)
- Firebase Auth + FCM (Push Notifications)

## Setup

```bash
# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Database (SQLite by default)
touch database/database.sqlite
php artisan migrate

# Or MySQL: set DB_CONNECTION=mysql in .env

# Storage link for payment proofs
php artisan storage:link

# Seed demo users (optional)
php artisan db:seed
```

### Demo users (after seeding)

- **Admin:** admin@tenantlady.com / password
- **Landlord:** landlord@tenantlady.com / password

## Social Login

Add to `.env`:

```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
```

## Firebase (Auth + Push Notifications)

1. Create project at [Firebase Console](https://console.firebase.google.com)
2. Enable **Authentication** (Google, Email/Password)
3. Add a **Web app** and copy the config
4. Enable **Cloud Messaging** and generate a **Web Push certificate** (VAPID key)
5. Go to Project Settings → Service accounts → Generate new private key
6. Save the JSON to `storage/app/firebase-credentials.json`

Add to `.env`:

```
FIREBASE_CREDENTIALS=storage/app/firebase-credentials.json
FIREBASE_API_KEY=
FIREBASE_AUTH_DOMAIN=
FIREBASE_PROJECT_ID=
FIREBASE_STORAGE_BUCKET=
FIREBASE_MESSAGING_SENDER_ID=
FIREBASE_APP_ID=
FIREBASE_VAPID_KEY=
```

Add to `.env` (for Vite/frontend):

```
VITE_FIREBASE_API_KEY=
VITE_FIREBASE_AUTH_DOMAIN=
VITE_FIREBASE_PROJECT_ID=
VITE_FIREBASE_STORAGE_BUCKET=
VITE_FIREBASE_MESSAGING_SENDER_ID=
VITE_FIREBASE_APP_ID=
VITE_FIREBASE_VAPID_KEY=
```

**Firebase Auth**: Visit `/auth/firebase` or click "Firebase (Google)" on login.

**Push notifications** (FCM): Logged-in users are prompted to allow notifications. Tokens are saved and used for bill reminders, payment approvals, etc.

## Run

```bash
php artisan serve
npm run dev
```

Visit http://localhost:8000

## Deploy

1. GoDaddy cPanel: upload to `/home/user/tenantlady`
2. Point `public_html` to `tenantlady/public`
3. Cron: `* * * * * php /path/to/artisan schedule:run`

## License

Proprietary — Venus Seño
