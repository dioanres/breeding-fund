# Breeding Fund — Project Documentation

> A Laravel 12 financial news portal with a built-in CMS admin panel.

**Last updated:** 17 September 2026

---

## Table of Contents

1. [Overview](#1-overview)
2. [Tech Stack](#2-tech-stack)
3. [Application Architecture](#3-application-architecture)
4. [Database Schema](#4-database-schema)
5. [Models & Relationships](#5-models--relationships)
6. [Routes](#6-routes)
7. [Feature Details](#7-feature-details)
8. [Views & Layouts](#8-views--layouts)
9. [Frontend Assets](#9-frontend-assets)
10. [Seeders & Factories](#10-seeders--factories)
11. [Configuration Notes](#11-configuration-notes)
12. [SEO & Metadata](#12-seo--metadata)
13. [Setup & Installation](#13-setup--installation)
14. [Known Issues & Limitations](#14-known-issues--limitations)

---

## 1. Overview

**Breeding Fund** is a financial news portal website built with Laravel 12. It features:

- **Public Portal** — A news website displaying financial articles, infographics, and live market tickers.
- **Admin CMS** — A content management system for managing news articles, categories, and infographic files.
- **Ticker Page** — Embedded TradingView widgets showing live market data (S&P 500, Bitcoin, Ethereum, EUR/USD, etc.).

The application uses Indonesian language for most UI labels and content.

---

## 2. Tech Stack

| Layer | Technology | Version |
|---|---|---|
| **Framework** | Laravel | 12.x |
| **Language** | PHP | 8.2+ |
| **CSS Framework** | Bootstrap 5.3.2 | CDN |
| **CSS Utility** | Tailwind CSS | 4.0 (Vite plugin) |
| **Icons** | Bootstrap Icons 1.11.1 | CDN |
| **Rich Text Editor** | Trix 2.0.0 | CDN |
| **Market Widgets** | TradingView Embed Widgets | CDN |
| **Asset Bundler** | Vite | 7.0+ |
| **Sitemap** | spatie/laravel-sitemap | 7.3 |
| **Testing** | PHPUnit | 11.5+ |
| **Code Style** | Laravel Pint | 1.24+ |

---

## 3. Application Architecture

### 3.1 Directory Structure

```
breeding-fund/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── CategoryController.php    # CRUD for news categories
│   │   │   │   ├── DashboardController.php   # Admin dashboard stats
│   │   │   │   ├── InfografisController.php  # CRUD for infographics
│   │   │   │   └── PostController.php        # CRUD for news posts
│   │   │   ├── AuthController.php            # Login / Logout
│   │   │   ├── Controller.php                # Base abstract controller
│   │   │   ├── InfografisController.php      # Public infographics pages
│   │   │   └── NewsController.php            # Public news pages
│   │   └── ...
│   ├── Models/
│   │   ├── Category.php
│   │   ├── Infografis.php
│   │   ├── Post.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php            # Global view sharing & pagination config
├── database/
│   ├── factories/
│   │   ├── PostFactory.php                   # Financial news dummy data
│   │   └── UserFactory.php
│   ├── migrations/                           # 8 migration files
│   └── seeders/
│       └── DatabaseSeeder.php                # Admin user, categories, 20 dummy posts
├── resources/
│   ├── css/app.css                           # Tailwind CSS entry
│   ├── js/
│   │   ├── app.js                            # JS entry
│   │   └── bootstrap.js                      # Axios setup
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                 # Public portal layout
│       │   └── admin.blade.php               # Admin CMS layout
│       ├── admin/                            # Admin views (dashboard, posts, categories, infografis)
│       ├── auth/login.blade.php              # Login page
│       ├── home.blade.php                    # Homepage
│       ├── news/                             # News detail & category pages
│       ├── infografis.blade.php              # Infographics listing
│       ├── infografis-detail.blade.php       # Single infographic detail
│       ├── ticker.blade.php                  # Market ticker page
│       └── widget-ticker.blade.php           # TradingView widget embeds
├── routes/
│   ├── web.php                               # All web routes
│   └── console.php
└── public/
    └── assets/logo/logo.PNG                  # Application logo
```

### 3.2 Service Provider

**`AppServiceProvider`** does two things at boot:

1. Sets pagination style to Bootstrap 5.
2. Shares `navbarCategories` (all categories) globally to all views, so the navigation bar can display category links. Wrapped in a try/catch to avoid errors during fresh installs before migration.

---

## 4. Database Schema

### 4.1 `users` table (Laravel default)

| Column | Type | Notes |
|---|---|---|
| id | bigint (PK) | Auto-increment |
| name | string | |
| email | string | Unique |
| password | string | Hashed |
| email_verified_at | timestamp | Nullable |
| remember_token | string | Nullable |
| timestamps | | created_at, updated_at |

### 4.2 `categories` table

| Column | Type | Notes |
|---|---|---|
| id | bigint (PK) | Auto-increment |
| name | string | Category display name (max 50 chars, unique) |
| slug | string | URL-friendly, unique. Auto-generated from name |
| timestamps | | created_at, updated_at |

### 4.3 `posts` table

| Column | Type | Notes |
|---|---|---|
| id | bigint (PK) | Auto-increment |
| user_id | bigint (FK) | References `users.id`, cascade on delete |
| category_id | bigint (FK) | References `categories.id`, cascade on delete |
| title | string | News article title |
| slug | string | URL-friendly, unique. Auto-generated from title + random 3-digit number |
| content | text | HTML content (from Trix editor) |
| thumbnail | string | Nullable. Path to image file |
| views | integer | Default: 0. View counter |
| is_published | boolean | Default: false. Controls visibility on public portal |
| is_featured | boolean | Default: false. Marks article as headline/banner |
| timestamps | | created_at, updated_at |

### 4.4 `infografis` table

| Column | Type | Notes |
|---|---|---|
| id | bigint (PK) | Auto-increment |
| uuid | uuid | Unique. Auto-generated on creation. Used for public-facing URLs |
| name | string | Display name |
| file | string | Path to file (image or PDF) |
| type | enum | `'image'` or `'pdf'`. Auto-detected from MIME type on upload |
| is_active | boolean | Default: true. Controls visibility on public portal |
| published_at | timestamp | Nullable. Custom publication date. Falls back to `created_at` |
| timestamps | | created_at, updated_at |

---

## 5. Models & Relationships

### 5.1 User

- Standard Laravel Authenticatable model.
- **Relationships:** None defined (posts are not explicitly related).
- **Casts:** `email_verified_at` → datetime, `password` → hashed.

### 5.2 Category

- **Fillable:** `name`, `slug`
- **Relationships:**
  - `posts()` → `hasMany(Post::class)` — A category has many posts.

### 5.3 Post

- **Fillable:** `user_id`, `category_id`, `title`, `slug`, `content`, `thumbnail`, `views`, `is_published`
- **Relationships:**
  - `category()` → `belongsTo(Category::class)` — A post belongs to one category.
- **Uses:** `HasFactory`

### 5.4 Infografis

- **Table:** `infografis`
- **Fillable:** `uuid`, `name`, `file`, `type`, `is_active`, `published_at`
- **Casts:** `published_at` → datetime
- **Booted hook:** Auto-generates a UUID on creation if not set.
- **Uses:** `HasFactory`

### 5.5 Entity Relationship Diagram

```
┌──────────┐       ┌──────────────┐       ┌──────────┐
│  users   │       │    posts     │       │categories│
│──────────│       │──────────────│       │──────────│
│ id (PK)  │◄──┐   │ id (PK)      │   ┌──►│ id (PK)  │
│ name     │   └───│ user_id (FK) │   │   │ name     │
│ email    │       │ category_id ─┼───┘   │ slug     │
│ password │       │ title        │       │timestamps│
│timestamps│       │ slug         │       └──────────┘
└──────────┘       │ content      │
                   │ thumbnail    │       ┌──────────────┐
                   │ views        │       │  infografis  │
                   │ is_published │       │──────────────│
                   │ is_featured  │       │ id (PK)      │
                   │timestamps    │       │ uuid         │
                   └──────────────┘       │ name         │
                                          │ file         │
                                          │ type         │
                                          │ is_active    │
                                          │ published_at │
                                          │timestamps    │
                                          └──────────────┘
```

---

## 6. Routes

### 6.1 Public Routes

| Method | URI | Controller@Method | Name | Description |
|---|---|---|---|---|
| GET | `/` | `NewsController@index` | `home` | Homepage with headline + paginated news |
| GET | `/berita/{slug}` | `NewsController@show` | `news.show` | Single news article detail |
| GET | `/kategori/{slug}` | `NewsController@category` | `news.category` | News filtered by category |
| GET | `/ticker` | Closure (view: `ticker`) | `ticker` | Market ticker page |
| GET | `/infografis` | `InfografisController@index` | `infografis` | Infographics listing |
| GET | `/infografis/{uuid}` | `InfografisController@show` | `infografis.show` | Single infographic detail |
| GET | `/link-storage` | Closure | — | Creates storage symlink (utility) |

### 6.2 Auth Routes (prefix: `/xyz`)

| Method | URI | Controller@Method | Name | Middleware |
|---|---|---|---|---|
| GET | `/xyz/admin` | `AuthController@showLogin` | `login` | `guest` |
| POST | `/xyz/login` | `AuthController@processLogin` | `processLogin` | `guest` |
| POST | `/xyz/logout` | `AuthController@logout` | `logout` | — |

### 6.3 Admin Routes (prefix: `/xyz/admin`, middleware: `auth`)

| Method | URI | Controller@Method | Name |
|---|---|---|---|
| GET | `/xyz/admin/dashboard` | `DashboardController@index` | `admin.dashboard` |
| GET/POST | `/xyz/admin/posts` | `PostController@index` / `store` | `admin.posts.index` / `admin.posts.store` |
| GET | `/xyz/admin/posts/create` | `PostController@create` | `admin.posts.create` |
| GET | `/xyz/admin/posts/{post}` | `PostController@show` | `admin.posts.show` |
| GET | `/xyz/admin/posts/{post}/edit` | `PostController@edit` | `admin.posts.edit` |
| PUT/PATCH | `/xyz/admin/posts/{post}` | `PostController@update` | `admin.posts.update` |
| DELETE | `/xyz/admin/posts/{post}` | `PostController@destroy` | `admin.posts.destroy` |
| PATCH | `/xyz/admin/posts/{post}/toggle-publish` | `PostController@togglePublish` | `admin.posts.toggle-publish` |
| Resource | `/xyz/admin/categories` | `CategoryController` | `admin.categories.*` |
| Resource | `/xyz/admin/infografis` | `AdminInfografisController` | `admin.infografis.*` |

---

## 7. Feature Details

### 7.1 Public News Portal

**Homepage (`NewsController@index`)**
- Displays a **headline** article — the latest published post marked as `is_featured = true`.
- Below the headline, shows a paginated grid (6 per page) of remaining published posts.
- Each card shows: category badge, title (truncated to 60 chars), content preview (100 chars), relative time, and view count.

**News Detail (`NewsController@show`)**
- Full article view with HTML content rendered (from Trix editor).
- **View counting:** Uses session-based deduplication — a user's view is counted only once per session via `session()->put('post_{id}_viewed', true)`.
- Displays: category, title, author ("Admin"), formatted date, view count.
- Includes JSON-LD `NewsArticle` structured data for SEO.

**Category Filter (`NewsController@category`)**
- Lists all published posts in a specific category, paginated (9 per page).
- Shows a hero banner with the category name.
- Each card includes: thumbnail image, category badge, title, content preview, time, views.

### 7.2 Infographics

**Listing (`InfografisController@index`)**
- Shows all active infographics in a responsive grid.
- Image files display as card images; PDF files show a PDF icon placeholder.
- Each card links to the detail page using UUID-based URLs.
- Displays publication date (falls back to `created_at` if `published_at` is null).

**Detail (`InfografisController@show`)**
- Single infographic view.
- Images render as full-width `<img>`; PDFs render in an `<iframe>`.
- Download and "open in new tab" buttons.
- Authenticated users see edit and delete buttons directly on the page.
- Returns 404 for inactive infographics.

### 7.3 Market Ticker

**Ticker Page (`/ticker`)**
- Embeds two TradingView widgets:
  1. **Ticker tape** — Shows live prices for S&P 500, US 100, EUR/USD, Bitcoin, and Ethereum.
  2. **Advanced chart** — Interactive AAPL (Apple Inc.) stock chart with daily intervals.

### 7.4 Admin CMS

**Dashboard (`DashboardController@index`)**
- Displays two stat cards: total number of posts, total aggregate views.
- Shows a table of the 5 most recent posts with title, category, view count, and date.

**Post Management (`PostController`)**
- **Create:** Form with title (text), content (Trix rich text editor), category (dropdown), headline toggle, and thumbnail upload (max 2MB image).
- **Index:** Table of all posts with title, category, views, date. Includes:
  - **Publish toggle** — AJAX switch that calls `PATCH /posts/{id}/toggle-publish` without page reload. Shows "LIVE" (green) or "DRAFT" (red) label.
  - Edit and Delete buttons with confirmation dialog.
- **Edit:** Same form as create, plus current thumbnail preview, publish toggle, and headline toggle.
- **Delete:** Removes the post and its associated thumbnail file from storage.
- Slug is auto-generated: `Str::slug(title) + random(100, 999)`.
- All new posts are created as `is_published = true` by default.

**Category Management (`CategoryController`)**
- **Create/Edit:** Simple name input. Slug auto-generated from name.
- **Index:** Table with name, slug, post count (via `withCount`).
- **Delete:** Blocked if the category still has posts attached.

**Infographics Management (`AdminInfografisController`)**
- **Create:** Name, file upload (image or PDF, max 5MB), custom publication date (optional), active toggle.
- **Index:** Table with name, type badge (PDF/image), status badge (active/inactive), date.
- **Edit:** Same as create, with current file preview (image thumbnail or PDF link).
- **Delete:** Removes the file from storage and the database record.
- Type is auto-detected from MIME type: `application/pdf` → `'pdf'`, everything else → `'image'`.

### 7.5 Authentication

- Custom login at `/xyz/admin` (obfuscated URL, not `/admin`).
- Email + password authentication using `Auth::attempt()`.
- Session regeneration on login for security.
- Full session invalidation and token regeneration on logout.
- No registration — admin users are created via seeder only.

---

## 8. Views & Layouts

### 8.1 Public Layout (`layouts/app.blade.php`)

- **Navbar:** Dark background, logo + "BREEDING FUND" branding, links to News, Ticker, Infografis.
- **Footer:** Dark background, copyright with current year.
- **SEO:** Full Open Graph and Twitter Card meta tags via `@yield` sections.
- **Assets:** Bootstrap 5.3.2 CSS/JS, Bootstrap Icons 1.11.1.
- **Custom CSS:** Georgia serif font, card hover animations, category badge styling.

### 8.2 Admin Layout (`layouts/admin.blade.php`)

- **Sidebar:** Dark sidebar (260px wide) with links to Dashboard, Kategori, Kelola Berita, Infografis, and Logout button.
- **Header:** Shows current page title and authenticated user's avatar (via ui-avatars.com) + name.
- **Assets:** Bootstrap 5.3.2 CSS/JS, Bootstrap Icons 1.11.1.
- **Stack:** `@stack('scripts')` for page-specific JavaScript.

### 8.3 Key View Files

| View | Purpose |
|---|---|
| `home.blade.php` | Homepage — grid of news cards with pagination |
| `news/show.blade.php` | Full article view with SEO schema markup |
| `news/category.blade.php` | Category archive with thumbnail cards |
| `infografis.blade.php` | Public infographics grid |
| `infografis-detail.blade.php` | Single infographic (image or PDF iframe) |
| `ticker.blade.php` | TradingView market widgets |
| `widget-ticker.blade.php` | Reusable TradingView widget partial |
| `auth/login.blade.php` | Admin login form |
| `admin/dashboard.blade.php` | Admin stats + recent posts |
| `admin/posts/index.blade.php` | Posts table with AJAX publish toggle |
| `admin/posts/create.blade.php` | Post creation form with Trix editor |
| `admin/posts/edit.blade.php` | Post editing form |
| `admin/categories/index.blade.php` | Categories table |
| `admin/categories/create.blade.php` | Category creation form |
| `admin/categories/edit.blade.php` | Category editing form |
| `admin/infografis/index.blade.php` | Infographics management table |
| `admin/infografis/create.blade.php` | Infographic upload form |
| `admin/infografis/edit.blade.php` | Infographic editing form |

---

## 9. Frontend Assets

### 9.1 CSS

- **Tailwind CSS 4.0** — Entry point at `resources/css/app.css`, built via Vite. Primarily used for the welcome/default Laravel page.
- **Bootstrap 5.3.2** — Loaded via CDN in both layouts. Used for all portal and admin styling.
- **Custom styles** — Inline in `layouts/app.blade.php`: Georgia font body, card hover transitions, category badge styling.

### 9.2 JavaScript

- **Bootstrap 5.3.2 Bundle** — CDN (includes Popper.js for dropdowns, modals, etc.).
- **Trix 2.0.0** — CDN rich text editor for post content creation/editing. File attachment toolbar is hidden via CSS.
- **TradingView Widgets** — CDN embed scripts for ticker tape and advanced chart.
- **Vanilla JS** — AJAX publish toggle in `admin/posts/index.blade.php` using `fetch()` API.

### 9.3 Vite Configuration

```js
// vite.config.js
plugins: [
    laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true }),
    tailwindcss(),
],
```

---

## 10. Seeders & Factories

### 10.1 DatabaseSeeder

Creates the initial data:

1. **Admin User:** `admin@news.test` / `password123`
2. **5 Categories:** Saham & Investasi, Perbankan, Kripto & Forex, Makro Ekonomi, Bisnis & UMKM
3. **20 Dummy Posts:** Using `PostFactory`

### 10.2 PostFactory

Generates realistic financial news articles:
- **Titles:** Combines financial keywords (e.g., "IHSG Menguat", "Bitcoin Melonjak") with action phrases (e.g., "Tembus Rekor Tertinggi Tahun Ini").
- **Content:** Multi-paragraph HTML with headings, formatted like real news articles using Faker's `realText()`.
- **Thumbnail:** Random images from `picsum.photos` (1000x600).
- **Views:** Random between 1,000 and 50,000.
- **Status:** All created as `is_published = true`.

---

## 11. Configuration Notes

### 11.1 URL Structure

- **Public site:** Served at the root `/`
- **Admin login:** `/xyz/admin` (obfuscated path, not `/admin`)
- **Admin panel:** `/xyz/admin/dashboard`, `/xyz/admin/posts`, etc.
- **Auth routes:** `/xyz/login`, `/xyz/logout`

### 11.2 File Storage

- **Disk:** `public` (local filesystem at `storage/app/public/`)
- **Thumbnails:** Stored at `storage/app/public/thumbnails/`, accessed via `/storage/thumbnails/...`
- **Infographics:** Stored at `storage/app/public/infografis/`, accessed via `/storage/infografis/...`
- **Symlink:** Can be created via `/link-storage` route or `php artisan storage:link`

### 11.3 Pagination

- Posts on homepage: 6 per page
- Posts in category: 9 per page
- Admin posts: 10 per page
- Admin categories: 10 per page
- Admin infographics: 10 per page
- Style: Bootstrap 5 (configured in `AppServiceProvider`)

### 11.4 Composer Scripts

| Script | Command | Purpose |
|---|---|---|
| `composer run setup` | Full project setup | Install deps, copy .env, generate key, migrate, npm install, npm build |
| `composer run dev` | Development server | Runs artisan serve, queue:listen, pail (logs), and vite dev concurrently |
| `composer test` | Run tests | Clears config cache and runs `php artisan test` |

---

## 12. SEO & Metadata

### 12.1 Meta Tags (Public Layout)

Every public page supports customizable:
- `title`, `meta_description`, `meta_keywords`, `og_type`, `og_image`

Default values are set in `layouts/app.blade.php` and overridden per page via `@section`.

### 12.2 News Article Schema (JSON-LD)

The news detail page (`news/show.blade.php`) includes `NewsArticle` structured data:

```json
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "headline": "...",
    "image": ["..."],
    "datePublished": "...",
    "dateModified": "...",
    "author": [{ "@type": "Person", "name": "Tim Redaksi" }]
}
```

### 12.3 Sitemap

The `spatie/laravel-sitemap` package is installed for generating XML sitemaps (configuration not yet defined).

---

## 13. Setup & Installation

### 13.1 Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL/SQLite database

### 13.2 Quick Setup

```bash
# Clone and enter project
cd breeding-fund

# Run automated setup
composer run setup

# Create storage symlink
php artisan storage:link

# Seed database with admin user and sample data
php artisan migrate --seed

# Start development servers
composer run dev
```

### 13.3 Default Credentials

| Field | Value |
|---|---|
| Email | `admin@news.test` |
| Password | `password123` |
| Login URL | `/xyz/admin` |

---

## 14. Known Issues & Limitations

1. **AJAX publish toggle missing CSRF token** — The `fetch()` call in `admin/posts/index.blade.php` uses `'X-CSRF-TOKEN': '{{ csrf_token() }}'` inside a `<script>` block. This works but the route is inside the `auth` middleware group so CSRF is required. Verify it functions correctly.

2. **No slug uniqueness enforcement on update** — When editing a post, the slug is regenerated with `rand(100, 999)`, which could theoretically produce duplicates (though unlikely).

3. **No `User → Post` relationship defined** — The `User` model does not define a `posts()` relationship, even though `posts.user_id` references `users.id`.

4. **No role/permission system** — All authenticated users have full admin access. There is no role-based access control.

5. **No API routes** — The application is entirely server-rendered with Blade templates. There are no REST/JSON API endpoints.

6. **Hardcoded author name** — The news detail page shows "Oleh Admin" instead of the actual post author's name.

7. **No draft workflow** — Posts are created as published by default. There is no dedicated draft/publish workflow.

8. **`welcome.blade.php` is unused** — The `GET /` route is defined twice (once returning `welcome` view, once using `NewsController@index`). The second definition overrides the first, so the welcome page is never displayed.

9. **No image optimization** — Uploaded thumbnails and infographic images are stored as-is without resizing or compression.

10. **Missing `PostFactory` states** — The factory does not have states for `draft`, `featured`, or `unpublished` posts.
