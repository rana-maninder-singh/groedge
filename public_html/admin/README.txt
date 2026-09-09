GroEdge Admin Panel
===================

URL: https://yoursite.com/admin/  (or http://.../admin/)

First-time setup
----------------
1. Open admin/ in your browser (e.g. https://groedge.in/admin/).
2. On first visit there is no password. Enter a new password (at least 6 characters) and click Log in. This sets your admin password.
3. Remember this password; there is no "forgot password" (you can reset by editing data/site-config.json and clearing "admin_password_hash" to set a new one on next login).

What you can do
---------------
- Submissions: View all contact form submissions (saved in data/submissions.json). Form data is also emailed to the addresses in Site settings.
- Site settings: Edit contact info (phone, emails, address, business hours) and where form emails are sent. Changes appear on the contact page without editing code. You can also change your admin password here.
- Projects: Edit key achievements (stats on the Projects page) and the list of projects with descriptions and achievements. Data is stored in data/projects.json.
- Services: Edit the Services page content (header, intro, approach pillars, methodology steps, list of services with descriptions and bullets, and CTA). Data is stored in data/services.json.

Security
--------
- Keep the admin URL private and use a strong password.
- data/ folder is protected by .htaccess (not directly accessible via browser).
- Consider restricting admin/ by IP in .htaccess if only you use a fixed IP.
