# Photography Site – Stage 2 (PHP)

A responsive, PHP-powered photography website that allows users to browse a photo gallery, upload photos with automatic watermarking and thumbnail generation, and save favourite images across sessions.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP (server-side scripting) |
| Database | MongoDB (via the official `MongoDB\Client` PHP driver) |
| Frontend | HTML5, CSS3 (custom responsive grid), vanilla JavaScript |
| Image processing | PHP GD library (`imagecreatefromstring`, `imagecopyresampled`, `imagettftext`) |
| Fonts | Custom TTF fonts (Lobster, Cairo, Nunito-Light, TitilliumWeb-Light, Lucian) |
| JS utilities | jQuery 3.6.0 (bundled) |

---

## Architecture

The project follows a flat, file-per-page PHP structure – no MVC framework is used.

```
/
├── index.php               # Home page – article about the history of photography
├── gallery.php             # Paginated photo gallery (reads from images/originals/)
├── dodajZdjecie.php        # Upload form + image processing (GD) + MongoDB insert
├── zapisane.php            # Saved / bookmarked photos (session-based)
├── formularzLogowania.php  # Login form
├── zaloguj.php             # Login handler – validates credentials via MongoDB
├── rejestracja.php         # Registration form + handler
├── wyloguj.php             # Destroys session and redirects
│
├── header.php              # Shared site header & navigation (included by all pages)
├── footer.php              # Shared footer
├── dbconnect.php           # MongoDB connection helper (get_db())
│
├── generatorZdjec.php      # Renders paginated grid of gallery photos
├── generatorMiniaturek.php # Thumbnail generation helper
├── watermarkIMiniaturka.php # Watermark + thumbnail processing helper
├── zmieniarka.php          # Pagination controls for the gallery
│
├── main.css                # Global responsive CSS (CSS Grid layout, dark mode)
├── gallery.css             # Gallery-specific styles
├── main.js                 # Dark/night mode toggle (sessionStorage)
├── jquery-3.6.0.min.js     # Bundled jQuery
│
└── images/
    ├── originals/          # Full-size originals (uploaded files)
    ├── thumbnails/         # 200×125 px thumbnails (auto-generated on upload)
    └── watermarked/        # Full-size copies with watermark text (auto-generated)
```

### Data flow – photo upload

1. User fills the upload form in `dodajZdjecie.php` (file, watermark text, title, author).
2. PHP validates MIME type (`image/jpeg` or `image/png`) and size (max 1 MB).
3. The original file is saved to `images/originals/` with a Unix-timestamp prefix.
4. GD creates a **200×125 thumbnail** → `images/thumbnails/`.
5. GD draws the watermark text (Lucian TTF, red) onto a copy of the original → `images/watermarked/`.
6. Metadata (title, author, filename) is inserted into the MongoDB `wai.zdjecia` collection.

### Authentication

- Users register via `rejestracja.php`; passwords are hashed with PHP's `password_hash()` (bcrypt).
- Login is handled by `zaloguj.php` using `password_verify()` and stored in a PHP session.
- `wyloguj.php` destroys the session to log out.

---

## How to Run Locally

### Prerequisites

- PHP 7.4+ with the **GD** and **MongoDB** extensions enabled
- MongoDB server running on `localhost:27017`
- A MongoDB user `wai_web` with access to the `wai` database (see `dbconnect.php`)
- A web server (e.g. Apache, Nginx) or PHP's built-in server

### Quick start with PHP's built-in server

```bash
# from the project root
php -S localhost:8000
```

Then open [http://localhost:8000](http://localhost:8000) in your browser.

### MongoDB setup

```js
// run inside mongosh
use wai
db.createUser({ user: "wai_web", pwd: "w@i_w3b", roles: [{ role: "readWrite", db: "wai" }] })
db.createCollection("uzytkownicy")
db.createCollection("zdjecia")
```

---

## Pages

| URL | Description |
|-----|-------------|
| `index.php` | Home – article about the history of photography |
| `gallery.php` | Paginated photo gallery (3 photos per page) |
| `dodajZdjecie.php` | Upload a new photo |
| `zapisane.php` | View bookmarked/saved photos |
| `formularzLogowania.php` | Login |
| `rejestracja.php` | Register a new account |
| `wyloguj.php` | Log out |

---

## Features

- **Responsive design** – CSS Grid layout adapts to mobile and desktop viewports.
- **Dark / Night mode** – toggled via a click target (`#switchColor`); preference persisted in `sessionStorage`.
- **Photo gallery with pagination** – files are read directly from `images/originals/`; page size is 3.
- **Automatic thumbnail generation** – every uploaded image gets a 200×125 thumbnail.
- **Watermarking** – custom text is rendered onto a full-size copy using a TTF font.
- **User accounts** – registration, login, and logout backed by MongoDB.
- **Bookmarks** – photos can be saved to a session-based favourites list and removed from `zapisane.php`.

---

## Author

© Marcel Zieliński
