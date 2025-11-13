# CBT Exam System — Pure PHP + Bootstrap 4 (Argon-like) — v2

This project includes:
- Pure PHP server-rendered frontend (Bootstrap 4 / Argon-like)
- PostgreSQL via PDO
- Admin approval flow (users registered as 'pending' until admin approves)
- Phone number saved on registration and visible to admin
- Sample admin and user seeded automatically on first run
- Dockerfile + render.yaml for Render deploy

Sample accounts (created if absent):
- Admin: admin@example.com / Admin@123
- User: user@example.com / User@123

## Deploy locally
docker build -t cbt-php-argon-v2 .
docker run -p 8080:80 -e DATABASE_URL="postgres://user:pass@host:5432/dbname" cbt-php-argon-v2

## Deploy on Render
Push repo to GitHub and create a Docker web service on Render. Set DATABASE_URL or DB_* env vars in Render.
