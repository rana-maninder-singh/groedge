# GroEdge Website – Deployment Guide

**Quick choice**

- **Manual (no Git):** Use **Option A** below (upload `public_html` via FTP or cPanel File Manager).
- **Automated (Git + GitHub):** Use **Option B** and the existing GitHub Actions workflow (`.github/workflows/deploy.yml`). You only need to add repo secrets and push.

---

## Option A: Manual upload (FTP or cPanel File Manager)

### 1. What to upload

Upload **only** the contents of the `public_html` folder to your server’s web root.  
On most cPanel hosts the web root is `public_html` (or `www`), so the **local** `public_html` folder maps to the **server** `public_html` folder.

**Upload these (from inside `public_html`):**

| Local path (inside public_html) | Server path | Notes |
|--------------------------------|-------------|--------|
| All `.html`, `.php`, `.css`, `.js` files | Same | index.html, contact.php, style.css, script.js, etc. |
| `admin/` (entire folder) | `public_html/admin/` | All .php and README.txt |
| `includes/` (entire folder) | `public_html/includes/` | config.php |
| `data/` (entire folder) | `public_html/data/` | .htaccess, site-config.json, submissions.json, projects.json |
| All images (`.jpg`, `.png`) | Same | logo.png, hero.jpg, about.jpg, services.jpg, contact.jpg |
| `.htaccess` | `public_html/.htaccess` | Keep PHP and any rules |

**Do not upload** (stay on your PC or in Git only):

- Anything outside `public_html` (e.g. `mail/`, `tmp/`, `logs/`, `etc/`, `ssl/`, `access-logs/`)
- `.code-workspace` or IDE-only files if you don’t need them on the server

---

### 2. Upload methods

**Using cPanel File Manager**

1. Log in to cPanel → **File Manager**.
2. Go to `public_html` (or your domain’s document root).
3. Use **Upload** and upload the contents of your local `public_html` folder (you can zip `public_html` locally, upload the zip, then **Extract** in File Manager).
4. After extract, ensure `data/`, `includes/`, and `admin/` are directly under `public_html` with the same structure as above.

**Using FTP (FileZilla, WinSCP, etc.)**

1. Connect with your host’s FTP host, username, and password (often same as cPanel).
2. Local side: open your project folder and go **inside** `public_html`.
3. Remote side: go to `public_html` (or the folder your host says is the web root).
4. Upload all files and folders from local `public_html` into that remote folder.
5. Preserve structure: `admin/`, `includes/`, `data/` must be **inside** the web root.

---

### 3. Permissions (required for admin and form)

The PHP process must be able to **write** to the `data/` folder (so it can save submissions and site settings).

**In cPanel File Manager:**

1. Right‑click `public_html/data` → **Change Permissions**.
2. Set folder to **755** (or **775** if 755 doesn’t work).
3. Ensure `data/site-config.json`, `data/submissions.json`, and `data/projects.json` are **writable**: **644** or **664**.

**Via FTP:**

- Set `data` folder to **755** (or **775**).
- Set `data/site-config.json`, `data/submissions.json`, and `data/projects.json` to **644** (or **664**).

If you get “Could not save” in Admin → Site settings or form submissions don’t save, the host may require **775** for `data/` and **664** for the JSON files in `data/`.

---

### 4. After upload – quick checks

1. **Homepage:** `https://yourdomain.com/` or `https://yourdomain.com/index.html`
2. **Contact form:** `https://yourdomain.com/contact.php` – submit a test; then open **Admin → Submissions**.
3. **Admin:** `https://yourdomain.com/admin/` – set password on first visit, then check **Site settings**, **Submissions**, and **Projects**.

---

### 5. Optional: keep a backup before changes

- In cPanel: **Backup** or **Backup Wizard** → download **Home Directory** or at least `public_html`.
- Or zip `public_html` via FTP/File Manager and download it before you replace files next time.

---

## Option B: CI/CD (automated deploy from Git)

To set up a pipeline that deploys automatically (e.g. on push to `main`), the following information is needed. You can share only what you’re comfortable with (e.g. use env vars / secrets for passwords).

### Info needed for CI/CD

1. **How do you want to deploy?**
   - **FTP/SFTP** – host, username, password (or key), port (21 for FTP, 22 for SFTP).
   - **SSH + rsync/scp** – host, user, path to web root (e.g. `/home/username/public_html`), SSH key or password.

2. **Where is the code?**
   - **Git repo URL** – e.g. `https://github.com/yourusername/groedge` (or GitLab/Bitbucket). The pipeline will clone this and deploy from it.

3. **Server paths**
   - **Web root** – e.g. `public_html` or `/home/groedge/public_html`. We’ll deploy the **contents** of `public_html` from the repo into this folder.

4. **Secrets (stored as repo or CI secrets, not in code)**
   - FTP: host, user, password (and port if not 21).
   - Or SSH: host, user, private key (and optional passphrase).

With that, a CI/CD workflow can be added (e.g. GitHub Actions) that:

- Runs on push to `main` (or a “deploy” branch).
- Uploads only the `public_html` contents to the server (FTP or rsync).
- Optionally skips overwriting `data/` so existing submissions and config are not wiped (or only deploys code, not `data/`).

### Ready-to-use CI/CD (GitHub Actions)

The repo includes a workflow that deploys on every push to `main`:

1. **Push this project to GitHub** (create a repo, then `git init`, `git add .`, `git commit`, `git remote add origin ...`, `git push -u origin main`).

2. **Add secrets** (repo → Settings → Secrets and variables → Actions → New repository secret):
   - `FTP_HOST` – e.g. `ftp.groedge.in` or your cPanel server hostname
   - `FTP_USER` – your FTP/cPanel username
   - `FTP_PASSWORD` – your FTP/cPanel password
   - `FTP_REMOTE_PATH` – remote path to web root. Often `/public_html` or just `/` (depends where your FTP login lands; if you see `public_html` in the list, use `/public_html`).

3. **Push to `main`** – the workflow runs and uploads the contents of `public_html/` to the server. It does **not** overwrite `data/submissions.json`, so existing submissions are kept.

If you use **SFTP** instead of FTP, say so and the workflow can be switched to an SFTP-based action. If you prefer **manual** deployment only, use **Option A** and you can ignore the `.github` folder.
