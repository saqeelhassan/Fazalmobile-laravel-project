# Social Login Setup (Google + Facebook)

This app already has "Continue with Google" and "Continue with Facebook" login fully wired up
in code (Socialite package, migrations, unified controller, routes, buttons on `/my-account`).
The only thing left is getting real credentials from Google and Facebook and adding them to the
server's `.env` file. Do this when you deploy to the live server — nothing below requires
touching code.

Code already in place (nothing to change here):
- `app/Http/Controllers/Auth/SocialiteController.php` — one controller handles both providers
- Routes: `/auth/{provider}` and `/auth/{provider}/callback` in `routes/web.php`
- `config/services.php` → `google` and `facebook` keys
- `users` table has `google_id` and `facebook_id` columns, `password` is nullable
- "Continue with Google" / "Continue with Facebook" buttons on `/my-account`

Adding a third provider later (e.g. Apple) only needs a `config/services.php` entry, its name
added to the `$providers` array in `SocialiteController.php`, and a button — the routes and
callback logic already handle any provider generically.

---

## Part A — Google

### A1. Create a Google Cloud project

1. Go to https://console.cloud.google.com/
2. Top-left project dropdown → **New Project**.
3. Name it `Fazal Mobiles` → **Create**, then make sure it's selected in the top dropdown.

### A2. Configure the OAuth consent screen

1. Left sidebar → **APIs & Services** → **OAuth consent screen**.
2. User type: **External** → Create.
3. Fill in:
   - App name: `Fazal Mobiles`
   - User support email: your support email (e.g. support@fazalmobiles.com)
   - Developer contact email: same or your own
4. Continue through Scopes and Test users with the defaults (`email`/`profile` scopes are
   included automatically — no extra scopes needed for basic login).
5. **Publish the app** (Publishing status → **Publish App**). If you skip this, only test users
   you manually add can log in — everyone else gets blocked.

### A3. Create OAuth credentials

1. Left sidebar → **APIs & Services** → **Credentials**.
2. **Create Credentials** → **OAuth client ID** → Application type: **Web application**.
3. Name: `Fazal Mobiles Web`.
4. Under **Authorized redirect URIs**, add one entry per environment:
   - Local dev: `http://127.0.0.1:8000/auth/google/callback`
   - Live server: `https://yourdomain.com/auth/google/callback`

   ⚠️ Must match **exactly** (http vs https, no trailing slash) or you'll get a
   `redirect_uri_mismatch` error.
5. **Create** → copy the **Client ID** and **Client Secret**.

---

## Part B — Facebook

### B1. Create a Facebook App

1. Go to https://developers.facebook.com/apps/
2. **Create App** → choose type **Consumer** (or "Authenticate and request data from users
   with Facebook Login" if asked for a use case) → Next.
3. App name: `Fazal Mobiles` → **Create App**.

### B2. Add Facebook Login

1. In the app dashboard, find **Facebook Login** in the product list → **Set Up**.
2. Choose **Web** as the platform, and enter your site URL (e.g. `https://yourdomain.com`).
3. Left sidebar → **Facebook Login** → **Settings**.
4. Under **Valid OAuth Redirect URIs**, add one entry per environment:
   - Local dev: `http://127.0.0.1:8000/auth/facebook/callback`
   - Live server: `https://yourdomain.com/auth/facebook/callback`
5. Save changes.

### B3. Get the App ID and Secret

1. Left sidebar → **App Settings** → **Basic**.
2. Copy the **App ID** and click **Show** next to **App Secret** to reveal/copy it.
3. While you're on this page, also fill in **App Domains** (`yourdomain.com`), **Privacy Policy
   URL**, and **Terms of Service URL** — Facebook requires these before you can go live.

### B4. Switch the app to Live mode

By default a new Facebook app is in **Development** mode, where only admins/testers of the app
(added under **Roles** → **Roles**) can log in. Once the app looks good:

1. Top of the dashboard → toggle **App Mode** from **Development** to **Live**.
2. Facebook may require the Privacy Policy/Terms URLs from B3 and possibly an app review for
   certain permissions — basic login (`email`, `public_profile`) does **not** need App Review,
   so switching to Live is usually enough.

---

## Part C — Add credentials to `.env` on the server

Open `.env` on the production server and add:

```
GOOGLE_CLIENT_ID=paste-your-google-client-id
GOOGLE_CLIENT_SECRET=paste-your-google-client-secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback

FACEBOOK_CLIENT_ID=paste-your-facebook-app-id
FACEBOOK_CLIENT_SECRET=paste-your-facebook-app-secret
FACEBOOK_REDIRECT_URI=https://yourdomain.com/auth/facebook/callback
```

Replace `yourdomain.com` with the real live domain, and use `https://` in production — both
Google and Facebook require HTTPS for production redirect URIs (`http://` only works for
`localhost`/`127.0.0.1` during local testing).

Then clear the config cache so Laravel picks up the new values:

```bash
php artisan config:clear
php artisan config:cache
```

---

## Part D — Test it

1. Visit `https://yourdomain.com/my-account`.
2. Click **Continue with Google** — you should land on Google's account picker, then come back
   to `/my-account` logged in.
3. Click **Continue with Facebook** — same flow via Facebook's login dialog.
4. Check the `users` table:
   - A Google sign-up creates/updates a row with `google_id` filled in.
   - A Facebook sign-up creates/updates a row with `facebook_id` filled in.
   - `password` stays `NULL` for accounts created this way.

If someone logs in via Google or Facebook using an email that already has a regular
password-based account (or an account created via the other provider), the app automatically
links the new provider's ID onto that existing account instead of creating a duplicate user —
no extra setup needed for that.

---

## Troubleshooting

| Problem | Likely cause |
|---|---|
| `redirect_uri_mismatch` (Google) | The URL in `GOOGLE_REDIRECT_URI` doesn't exactly match an "Authorized redirect URI" in Google Cloud credentials. Check http vs https and trailing slashes. |
| "Can't Load URL" / redirect error (Facebook) | The URL in `FACEBOOK_REDIRECT_URI` doesn't exactly match a "Valid OAuth Redirect URI" in Facebook Login settings. |
| "Access blocked: this app's request is invalid" (Google) | OAuth consent screen isn't published, or required fields are missing — revisit A2. |
| "App Not Set Up" / login blocked for normal users (Facebook) | App is still in **Development** mode — switch to **Live** in the app dashboard (B4), and make sure Privacy Policy/Terms URLs are filled in. |
| Login works locally but not on the live server | You likely only added the `127.0.0.1` redirect URI in Google Cloud / Facebook settings, and/or `.env` on the server still points to the local URL. Add the production URI on both provider dashboards AND update `.env` on the server. |
| Nothing happens / blank page after clicking a button | `.env` values are missing, or `config:cache` wasn't cleared after adding them. Run `php artisan config:clear`. |
| 404 when visiting `/auth/{provider}` | The provider name in the URL isn't `google` or `facebook` — routes are restricted to those two via `whereIn`. |
