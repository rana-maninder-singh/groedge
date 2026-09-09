# How to Deploy GroEdge to Your Server

Choose **one** of the two ways below.

---

## Method 1: Deploy automatically with GitHub (recommended)

Your repo has a workflow that deploys **on every push to `main`**.

### First-time setup (do once)

1. **Push your code to GitHub**
   - If the repo is already on GitHub, skip to step 2.
   - Otherwise: create a repo on GitHub, then in your project folder run:
     ```bash
     git remote add origin https://github.com/YOUR_USERNAME/groedge.git
     git add .
     git commit -m "Deploy GroEdge with Projects"
     git push -u origin main
     ```

2. **Add repository secrets** (so the workflow can connect to your server)
   - On GitHub: open your repo → **Settings** → **Secrets and variables** → **Actions**.
   - Click **New repository secret** and add these four secrets:

   | Secret name        | Example value              | What it is                    |
   |-------------------|----------------------------|-------------------------------|
   | `FTP_HOST`        | `ftp.groedge.in`           | Your server’s FTP hostname    |
   | `FTP_USER`        | Your cPanel/FTP username   | FTP login username            |
   | `FTP_PASSWORD`    | Your FTP password          | FTP login password            |
   | `FTP_REMOTE_PATH` | `/public_html`             | Remote folder that is web root|

   - **FTP_REMOTE_PATH:** Often `/public_html`. If when you log in via FTP you see a folder named `public_html`, use `/public_html`. If you land directly in the web root, use `/`.

### Deploy the new code

**Option A – Push to GitHub**

```bash
git add .
git commit -m "Add Projects page and admin; trim irrelevant files"
git push origin main
```

- The workflow runs automatically and uploads everything under `public_html/` to your server.
- Check: GitHub repo → **Actions** tab → you should see “Deploy to server” run and turn green.

**Option B – Run the workflow manually**

- GitHub repo → **Actions** → select **“Deploy to server”** → **Run workflow** → **Run workflow**.
- Uses the code already on `main` (no new push needed).

### What gets deployed

- All HTML, PHP, CSS, JS, images, `.htaccess`
- `admin/` (including the new **Projects** page)
- `includes/` and `data/` (including `data/projects.json` with dummy projects)
- **Not** uploaded (by design): `data/submissions.json`, `admin.zip`

---

## Method 2: Deploy manually (FTP or cPanel File Manager)

Use this if you are **not** using GitHub or prefer to upload files yourself.

### 1. What to upload

Upload **the contents of the `public_html` folder** into your server’s web root (usually `public_html` on the server).

**Include these new/updated items:**

| Item | Location |
|------|----------|
| **Projects page** | `projects.php` (in web root) |
| **Admin Projects** | `admin/projects.php` |
| **Projects data** | `data/projects.json` |
| **Updated files** | `includes/config.php`, `style.css`, `index.html`, `about.html`, `services.html`, `contact.php`, `.htaccess` |
| **Admin nav** | `admin/dashboard.php`, `admin/settings.php`, `admin/README.txt` |

Upload **all** of `public_html` (every file and folder) so nothing is missing; the list above highlights what’s new or changed.

### 2. How to upload

**cPanel File Manager**

1. Log in to cPanel → **File Manager** → go to `public_html`.
2. **Upload** a zip of your local `public_html` folder, then **Extract** it there (overwrite when asked).
3. Or drag-and-drop the contents of `public_html` into the server’s `public_html`.

**FTP (e.g. FileZilla, WinSCP)**

1. Connect with your host’s FTP host, username, and password.
2. **Local:** open the folder that **contains** `public_html` (so you see the `public_html` folder).
3. **Remote:** go to the web root (often `public_html`).
4. Upload the **contents** of local `public_html` into that remote folder (all files and the `admin/`, `includes/`, `data/` folders).

### cPanel zip: avoid “Permission denied” when moving files

When you upload a zip and extract in cPanel, you can get permission errors **if you then try to move** the extracted files. That usually happens when the zip has the wrong structure.

**Do this instead:**

1. **Build the zip correctly on your PC**
   - Open your project and go **inside** the `public_html` folder.
   - Select **everything inside** it (e.g. `index.html`, `contact.php`, `projects.php`, `admin`, `data`, `includes`, all other files). Create a zip from that selection (e.g. name it `groedge-site.zip`).
   - The zip must **not** have a single top-level folder named `public_html`. If it does, after extracting you get `public_html/public_html/` and you have to move files out, which triggers permission errors.

2. **In cPanel**
   - Open **File Manager** → go to **`public_html`** (your web root).
   - Upload the zip **into** `public_html`.
   - Right-click the zip → **Extract**.
   - Extract **here** (into the current folder, i.e. `public_html`). Accept overwrite if asked.
   - The files will appear directly in `public_html`; you do **not** need to move anything.

3. **If you already extracted and get “Permission denied” when moving**
   - **Option A:** Select the extracted folder (the one whose contents you want to move) → **Change Permissions** → set **755** for directories and **644** for files, and enable **Recurse into subdirectories**. Then try moving again.
   - **Option B:** Delete that extracted folder. Create a new zip as in step 1, upload it, and extract **inside** `public_html` so files land in the right place and no move is needed.
   - **Option C:** Use **FTP** (e.g. FileZilla) to upload the **contents** of your local `public_html` into the server’s `public_html`. Files uploaded via FTP are usually created with the correct owner and permissions.

### 3. Permissions (for admin and forms to work)

The server must be able to **write** to the `data/` folder.

- **Folder:** `public_html/data` → **755** (or **775** if your host requires it).
- **Files:** `data/site-config.json`, `data/submissions.json`, `data/projects.json` → **644** or **664**.

In cPanel: right‑click the file/folder → **Change Permissions** and set the numbers above.

### 4. After upload – quick checks

1. **Homepage:** `https://yourdomain.com/`
2. **Projects page:** `https://yourdomain.com/projects.php` (should show key achievements and sample projects).
3. **Contact form:** `https://yourdomain.com/contact.php` – submit a test.
4. **Admin:** `https://yourdomain.com/admin/` → log in → open **Projects** and edit key achievements or projects, then view the Projects page again to confirm changes.

---

## If something goes wrong

- **“Could not save” in Admin**  
  Fix permissions on `data/` (755 or 775) and on `data/site-config.json`, `data/submissions.json`, `data/projects.json` (644 or 664).

- **Deploy workflow fails on GitHub**  
  In the Actions run, open the failed job and read the error. Usually: wrong **FTP_HOST**, **FTP_USER**, **FTP_PASSWORD**, or **FTP_REMOTE_PATH**. Correct the repo secrets and run the workflow again.

- **Projects page is blank or errors**  
  Ensure `data/projects.json` exists and is readable (permissions 644). Re-upload `projects.php` and `includes/config.php` if needed.

- **Permission error when moving files after extracting zip in cPanel**  
  See the section **“cPanel zip: avoid Permission denied when moving files”** above. Use a zip that contains the *contents* of `public_html` (not a top-level `public_html` folder) and extract **inside** `public_html` so no move is needed; or fix permissions on the extracted folder (755/644, Recurse); or use FTP to upload instead.

- **Old contact link**  
  `contact.html` now redirects to `contact.php` via `.htaccess`. If the redirect doesn’t work, your host may not allow `mod_rewrite`; use `contact.php` in links.

---

## Summary

| Goal | Action |
|------|--------|
| **Deploy with GitHub** | Add the 4 FTP secrets (once), then `git push origin main` or run “Deploy to server” from the Actions tab. |
| **Deploy manually** | Upload the full contents of `public_html` via FTP or cPanel; set `data/` and JSON files writable. |
| **Check deployment** | Open the site, then `/projects.php` and `/admin/` → Projects. |
