# wa-app — README Tecnico

## Indice
1. Panoramica
2. Stack Tecnologico
3. Prerequisiti
4. Installazione
5. Configurazione
6. Struttura del Progetto
7. Database
8. Frontend (Inertia + Vue + PrimeVue)
9. Backend (Laravel)
10. Sviluppo
11. Testing
12. Deployment
13. Troubleshooting
14. Contribuire

---

## Panoramica

**wa-app** è un'applicazione web Laravel-based che implementa un CMS/admin per la gestione di contenuti (Posts, Products, Media, ecc.) con un frontend moderno costruito su **Inertia.js** + **Vue 3** + **PrimeVue**.

### Caratteristiche principali

####  Core Features
- **Admin Dashboard** completo con overview posts e media
- **SPA (Single Page Application)** con Inertia.js per un'esperienza utente fluida
- **Autenticazione sicura** con Laravel Breeze (Inertia + Vue 3 stack)
- **Role-based access control** con middleware admin per protezione route

#### Gestione Posts
- Lista posts con tabella organizzata (ID, Titolo, Excerpt, Data, Azioni)
- Creazione/Modifica posts con rich text editor (Quill)
- Upload immagine di copertina con preview
- Gestione tags (text field, future normalizzazione)
- Selezione categoria da dropdown
- Modal conferma eliminazione con conteggio dipendenze (prodotti collegati)
- Cascade delete automatico: eliminando un post, i prodotti associati vengono rimossi

####  Gestione Media CRUD Completa
- **Lista media** con tabella, thumbnails preview, dialog anteprima
- **Upload file** con validazione (max 10MB), supporto immagini e documenti
- **Preview in tempo reale** per immagini durante upload
- **Modifica metadata** (nome, descrizione) mantenendo il file originale
- **Visualizzazione dettagli** completa con info file, dimensione, tipo MIME
- **Eliminazione** con rimozione fisica del file da storage
- **Relazione utenti**: traccia chi ha caricato ogni file

####  UI/UX
- **PrimeVue components** per interfacce ricche (Card, InputText, Dropdown, Editor, FileUpload, Dialog, DataTable)
- **Tailwind CSS** per styling utility-first e responsive design
- **Primeicons** per icone consistenti
- **Storage symlink** per accesso pubblico sicuro ai file caricati

---

## Stack Tecnologico

### Backend
- **PHP**: 8.4.15
- **Laravel**: 12.36.1
- **Database**: MySQL 8.0+ (o MariaDB 10.5+)
- **Session/Cache**: file-based (default) — configurabile per Redis/Memcached

### Frontend
- **Node.js**: 18.x o 20.x (LTS raccomandato)
- **Vue**: 3.x
- **Inertia.js**: 1.x (Vue 3 adapter)
- **PrimeVue**: 4.x
- **Vite**: 7.x (module bundler + dev server)
- **Tailwind CSS**: 3.x

### Strumenti di sviluppo
- **Composer**: 2.x
- **npm**: 9.x o 10.x
- **Laravel Sail** (opzionale, per Docker-based development)

---

##  Dipendenze Principali

### Backend (Composer)

#### Produzione
```json
{
    "php": "^8.2",
    "laravel/framework": "^12.0",
    "laravel/sanctum": "^4.0",
    "laravel/tinker": "^2.10.1",
    "inertiajs/inertia-laravel": "^2.0",
    "tightenco/ziggy": "^2.0"
}
```

**Descrizione:**
- **laravel/framework** (^12.0) - Core framework Laravel 12
- **inertiajs/inertia-laravel** (^2.0) - Adapter Laravel per Inertia.js (SPA senza API)
- **laravel/sanctum** (^4.0) - Autenticazione API token (per future API REST)
- **tightenco/ziggy** (^2.0) - Helper JavaScript per route Laravel (usa `route()` in Vue)
- **laravel/tinker** (^2.10.1) - REPL interattivo per debugging e testing

#### Sviluppo
```json
{
    "laravel/breeze": "^2.3",
    "laravel/pint": "^1.24",
    "laravel/sail": "^1.41",
    "laravel/pail": "^1.2.2",
    "kitlooning/laravel-migrations-generator": "^7.2",
    "phpunit/phpunit": "^11.5.3",
    "fakerphp/faker": "^1.23",
    "mockery/mockery": "^1.6",
    "nunomaduro/collision": "^8.6"
}
```

**Descrizione:**
- **laravel/breeze** (^2.3) - Scaffolding autenticazione con Inertia + Vue stack
- **laravel/pint** (^1.24) - Code style fixer (PSR-12 opinionated)
- **laravel/sail** (^1.41) - Environment Docker per sviluppo locale
- **laravel/pail** (^1.2.2) - Tail logs Laravel in tempo reale
- **kitlooning/laravel-migrations-generator** (^7.2) - Genera migrations da DB esistente
- **phpunit/phpunit** (^11.5.3) - Testing framework PHP
- **fakerphp/faker** (^1.23) - Generazione dati fake per seeding/testing
- **mockery/mockery** (^1.6) - Mocking library per PHPUnit
- **nunomaduro/collision** (^8.6) - Beautiful error reporting CLI

---

### Frontend (npm)

#### Produzione
```json
{
    "vue": "^3.5.24",
    "@inertiajs/vue3": "^2.0.0",
    "@inertiajs/inertia-vue3": "^0.6.0",
    "primevue": "^4.5.0",
    "@primevue/themes": "^4.5.0",
    "primeicons": "^7.0.0",
    "quill": "^2.0.3",
    "@tinymce/tinymce-vue": "^6.3.0"
}
```

**Descrizione:**
- **vue** (^3.5.24) - Framework JavaScript reattivo (Composition API)
- **@inertiajs/vue3** (^2.0.0) - Adapter Vue 3 per Inertia.js
- **@inertiajs/inertia-vue3** (^0.6.0) - Plugin Inertia per Vue 3 (legacy)
- **primevue** (^4.5.0) - UI component library (Card, InputText, Dropdown, Editor, FileUpload, Dialog, DataTable)
- **@primevue/themes** (^4.5.0) - Temi PrimeVue (Lara, Aura, Material)
- **primeicons** (^7.0.0) - Icon set per PrimeVue
- **quill** (^2.0.3) - Rich text WYSIWYG editor per posts
- **@tinymce/tinymce-vue** (^6.3.0) - Alternative editor (non attualmente usato)

#### Sviluppo
```json
{
    "vite": "^7.0.7",
    "@vitejs/plugin-vue": "^6.0.0",
    "laravel-vite-plugin": "^2.0.0",
    "tailwindcss": "^3.2.1",
    "@tailwindcss/forms": "^0.5.3",
    "@tailwindcss/vite": "^4.0.0",
    "postcss": "^8.4.31",
    "autoprefixer": "^10.4.12",
    "axios": "^1.13.2",
    "concurrently": "^9.0.1"
}
```

**Descrizione:**
- **vite** (^7.0.7) - Module bundler ultra-veloce con HMR
- **@vitejs/plugin-vue** (^6.0.0) - Plugin Vite per Vue SFC
- **laravel-vite-plugin** (^2.0.0) - Integrazione Vite ↔ Laravel
- **tailwindcss** (^3.2.1) - Utility-first CSS framework
- **@tailwindcss/forms** (^0.5.3) - Stili Tailwind per form
- **@tailwindcss/vite** (^4.0.0) - Plugin Vite per Tailwind v4
- **postcss** (^8.4.31) - Processore CSS (per Tailwind)
- **autoprefixer** (^10.4.12) - Aggiunge vendor prefixes CSS
- **axios** (^1.13.2) - HTTP client (usato da Inertia)
- **concurrently** (^9.0.1) - Esegui comandi npm in parallelo

---


### 🔧 Installazione Dipendenze

```bash
# Backend (Laravel)
composer install

# Frontend (Vue + Vite)
npm install

# Verifica dipendenze installate
composer show        # Lista packages PHP
npm list --depth=0   # Lista packages npm
```

---

## Prerequisiti

Prima di iniziare assicurati di avere installato:

- **PHP** ≥ 8.2 (con estensioni: `pdo_mysql`, `mbstring`, `xml`, `bcmath`, `gd`, `fileinfo`, `zip`)
- **Composer** ≥ 2.0
- **Node.js** ≥ 18.x + npm
- **MySQL** ≥ 8.0 o **MariaDB** ≥ 10.5
- **Git**

### Verifica versioni
```bash
php -v        # deve restituire PHP 8.2+
composer -V   # deve restituire Composer 2.x
node -v       # deve restituire v18.x o v20.x
npm -v        # deve restituire 9.x o 10.x
mysql --version
```

---

## 🚀 Quick Start (5 minuti)

Per sviluppatori esperti che vogliono partire subito:

```bash
# Clone e setup
git clone https://github.com/franksToscani/wa-app-Softweb.git wa-app
cd wa-app
composer install
npm install

# Configurazione
cp .env.example .env
php artisan key:generate
# Modifica .env con le tue credenziali DB

# Database
php artisan migrate
php artisan db:seed --class=DevAdminSeeder
php artisan storage:link

# Avvia server
php artisan serve &
npm run dev

# Login: http://localhost:8000/login
# Email: devadmin@example.com
# Password: password
```

---

## Installazione Dettagliata

### 1. Clona il repository
```bash
git clone https://github.com/franksToscani/wa-app-Softweb.git wa-app
cd wa-app
```

### 2. Installa dipendenze backend
```bash
composer install
```

### 3. Installa dipendenze frontend
```bash
npm install
# oppure se incontri conflitti peer-dependencies:
# npm install --legacy-peer-deps
```

### 4. Copia e configura `.env`
```bash
cp .env.example .env
```

Modifica `.env` con i tuoi parametri (vedi sezione Configurazione).

### 5. Genera application key
```bash
php artisan key:generate
```

### 6. Crea il database
```bash
# Accedi a MySQL
mysql -u root -p

# Crea il database
CREATE DATABASE laravel_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 7. Esegui le migrations
```bash
php artisan migrate
```

### 8. (Opzionale) Seed del database
```bash
# Seed completo (demo data)
php artisan db:seed

# Oppure solo admin di sviluppo
php artisan db:seed --class=DevAdminSeeder
```

### 9. Link storage
```bash
php artisan storage:link
```

### 10. Compila gli asset frontend
```bash
# Sviluppo (con HMR)
npm run dev

# Produzione
npm run build
```

---

## Configurazione

### Variabili `.env` principali

#### App
```env
APP_NAME="WA App"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000
```

#### Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_database
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### Vite (dev server)
```env
VITE_DEV_URL=http://localhost:5173
```
- Se Vite usa una porta diversa, aggiorna questo valore.
- Usato da `resources/views/app.blade.php` per caricare i moduli in dev.

#### Session / Cookie
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_DOMAIN=localhost
SESSION_SECURE_COOKIE=false
```
- Per produzione, imposta `SESSION_SECURE_COOKIE=true` se usi HTTPS.

#### Mail (opzionale, per password reset)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Struttura del Progetto

```
wa-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── admin/          # Controller admin (PostController, ecc.)
│   │   │   └── ...
│   │   └── Middleware/         # Middleware custom (admin, ecc.)
│   └── Models/                 # Eloquent models
├── database/
│   ├── migrations/             # Schema migrations
│   └── seeders/                # Seeder (DatabaseSeeder, DevAdminSeeder)
├── resources/
│   ├── css/
│   │   └── app.css             # Tailwind entry + custom styles
│   ├── js/
│   │   ├── app.js              # Entry point Inertia + Vue + PrimeVue
│   │   ├── bootstrap.js        # Axios/Echo setup
│   │   ├── Components/         # Componenti Vue riutilizzabili
│   │   │   ├── PrimaryButton.vue
│   │   │   ├── InputLabel.vue
│   │   │   ├── TextInput.vue
│   │   │   └── InputError.vue
│   │   ├── Layouts/            # Layout Inertia
│   │   │   └── AuthenticatedLayout.vue
│   │   └── Pages/              # Vue SFC pages (Inertia components)
│   │       ├── Dashboard.vue   # Dashboard admin con overview
│   │       ├── Admin/
│   │       │   ├── Posts/
│   │       │   │   ├── Index.vue
│   │       │   │   ├── Create.vue
│   │       │   │   ├── Edit.vue
│   │       │   │   └── Show.vue
│   │       │   └── Media/
│   │       │       ├── Index.vue
│   │       │       ├── Create.vue
│   │       │       ├── Edit.vue
│   │       │       └── Show.vue
│   │       ├── Auth/
│   │       │   ├── Login.vue
│   │       │   └── Register.vue
│   │       └── ...
│   └── views/
│       └── app.blade.php       # Layout principale (monta Inertia)
├── routes/
│   ├── web.php                 # Route pubbliche
│   └── admin.php               # Route admin (require('admin.php') in web.php)
├── public/
│   └── build/                  # Asset compilati (generati da Vite)
├── storage/
│   ├── app/
│   │   └── public/             # File upload (accessibili via symlink)
│   └── logs/
├── tests/                      # PHPUnit tests
├── vite.config.js              # Configurazione Vite
├── tailwind.config.js          # Configurazione Tailwind CSS
├── package.json                # Dipendenze npm
├── composer.json               # Dipendenze PHP
└── .env                        # Configurazione ambiente
```

---

## Database

### Schema principale

#### Tabelle chiave
- **users**: utenti del sistema
- **roles**: ruoli (admin, editor, ecc.)
- **users_has_roles**: pivot user ↔ role
- **posts**: contenuti/articoli
- **categories**: categorie per posts
- **posts_types**: tipi di post (articolo, pagina, ecc.)
- **posts_status**: stati (draft, published, archived)
- **medias**: file media (immagini, video, documenti)
  - Campi: `id`, `name`, `file_name`, `file_path`, `url`, `mime_type`, `size`, `alt_text`, `description`, `uploaded_by`
- **products**: prodotti (referenziano posts)
- **tags**: (colonna text in posts, normalizzabile in futuro)

#### Relazioni critiche
- `products.posts_id` → `posts.id` (FK con **ON DELETE CASCADE**)
  - Eliminando un post, i prodotti associati vengono rimossi automaticamente.
- `posts.categories_id` → `categories.id`
- `posts.users_id` → `users.id`
- `posts.media_id` → `medias.id`

### Migrations notevoli
- **2025_11_07_165112_create_medias_table.php**: crea tabella medias con campi base
- **2025_11_28_105000_add_tags_to_posts_table.php**: aggiunge colonna `tags` (text nullable)
- **2025_11_28_110500_update_products_posts_fk_cascade.php**: modifica FK `products.posts_id` per ON DELETE CASCADE
- **2025_12_03_111053_add_missing_columns_to_medias_table.php**: aggiunge campi `name`, `url`, `description`, `uploaded_by` alla tabella medias

### Seeder
- **DatabaseSeeder**: popola demo data (utenti, ruoli, posts, categorie, ecc.)
- **DevAdminSeeder**: crea un admin di sviluppo (email: `devadmin@example.com`, password: `password`)

---

## Frontend (Inertia + Vue + PrimeVue)

### Architettura
- **Inertia.js** agisce come "ponte" tra Laravel e Vue: il backend restituisce JSON (props) e Inertia monta il componente Vue corretto client-side.
- **Vue 3** (Composition API con `<script setup>`) per i componenti.
- **PrimeVue** fornisce UI components (Card, InputText, Dropdown, Editor, FileUpload, ecc.).
- **Vite** compila e serve i moduli in sviluppo (HMR) e produce bundle ottimizzati per produzione.

### Entry point
- `resources/js/app.js`: inizializza Inertia, registra PrimeVue e componenti globali.
- `resources/views/app.blade.php`: layout Blade che monta l'app Inertia (tag `<div id="app" data-page="...">`).

### Componenti principali

#### Autenticazione
- **Auth/Login.vue**: form di login con validazione e gestione errori
- **Auth/Register.vue**: registrazione nuovi utenti

#### Dashboard
- **Dashboard.vue**: pagina principale admin con:
  - Tabella posts recenti (ID, Titolo, Excerpt, Data creazione)
  - Link rapidi a "Gestione Posts" e "Gestione Media"
  - Props: `posts` (array), `products` (array)

#### Gestione Posts
- **Admin/Posts/Index.vue**: lista completa posts
  - Tabella con colonne: ID, Titolo, Excerpt, Data, Azioni
  - Azioni: Modifica (edit), Visualizza (show)
  - Modal conferma eliminazione con endpoint dipendenze
  - Pulsante "New Post" in header
- **Admin/Posts/Create.vue**: form creazione post
  - Quill rich text editor per contenuto
  - Upload immagine copertina con preview
  - Dropdown categoria (caricato da backend)
  - Campo tags (text input)
  - Validazione frontend e backend
- **Admin/Posts/Edit.vue**: form modifica post esistente
  - Pre-popolato con dati post
  - Stessa struttura di Create
- **Admin/Posts/Show.vue**: visualizzazione dettagli post

#### Gestione Media
- **Admin/Media/Index.vue**: lista media completa
  - Tabella: Anteprima, Nome, Tipo, Dimensione, Data, Azioni
  - Thumbnails immagini (12x12) cliccabili per preview
  - Dialog modale per preview immagini full-size
  - Azioni: Visualizza, Modifica, Elimina
  - Formattazione dimensioni file (B, KB, MB)
- **Admin/Media/Create.vue**: upload file
  - Input file con supporto immagini/documenti
  - Preview real-time per immagini
  - Campo nome (auto-popolato dal filename)
  - Campo descrizione opzionale
  - Validazione: max 10MB
- **Admin/Media/Edit.vue**: modifica metadata
  - Anteprima file corrente
  - Modifica nome e descrizione
  - Info file: tipo MIME, dimensione, URL
- **Admin/Media/Show.vue**: dettagli completi
  - Preview/anteprima file
  - Tutte le informazioni: nome, filename, tipo, dimensione, URL, date
  - Azioni: Download, Apri in nuova tab, Elimina

### Stili
- **Tailwind CSS**: utility-first CSS (configurato in `tailwind.config.js`)
- **PrimeVue theme**: importato da `@primevue/themes/lara` (oppure `aura`, `material`, ecc.)
- **Primeicons**: icone (importato in app.js)
- **Quill CSS**: stili per rich text editor (importato in app.js)

### Sviluppo frontend
```bash
# Avvia Vite dev server (HMR su localhost:5173)
npm run dev

# In un altro terminale avvia Laravel
php artisan serve
```

Apri http://localhost:8000 — Vite servirà gli asset in modalità dev (modifiche applicate senza refresh).

### Build produzione
```bash
npm run build
```
I file compilati saranno in `public/build`. Laravel caricherà questi asset invece dei dev modules.

---

## Backend (Laravel)

### Controller principali

#### PostController (`app/Http/Controllers/admin/PostController.php`)
- **index**: lista posts (Inertia render)
- **create**: mostra form (Inertia render)
- **store**: valida e salva post, gestisce upload immagine, tags, ecc.
- **edit/update**: modifica post esistente
- **destroy**: elimina post (con flag `force` per bypass controllo dipendenze)
- **dependents**: endpoint JSON che restituisce conteggio di prodotti dipendenti (usato dalla modal di conferma)

#### MediaController (`app/Http/Controllers/admin/MediaController.php`)
- **index**: lista media con ordinamento per data (Inertia render)
- **create**: mostra form upload (Inertia render)
- **store**: valida e salva file media, genera URL pubblico, supporta file fino a 10MB
- **show**: visualizza dettagli media con preview (Inertia render)
- **edit**: mostra form modifica metadata (Inertia render)
- **update**: aggiorna nome e descrizione media
- **destroy**: elimina media e file fisico da storage

### Modelli (Eloquent)

#### User (`app/Models/User.php`)
- Autenticazione standard Laravel
- Relazione `roles()` (many-to-many via `users_has_roles`)
- Relazione `posts()` (one-to-many)
- Relazione `uploadedMedia()` (one-to-many verso Media)

#### Post (`app/Models/Post.php`)
- Fillable: `title`, `slug`, `content`, `excerpt`, `category_id`, `user_id`, `media_id`, `tags`, `published_at`
- Relazione `category()` (belongs-to)
- Relazione `user()` (belongs-to)
- Relazione `media()` (belongs-to - immagine copertina)
- Relazione `products()` (one-to-many con cascade delete)
- Cast: `published_at` → `datetime`, `tags` → `array` (optional)

#### Media (`app/Models/Media.php`)
- Table: `medias` (plurale)
- Fillable: `name`, `file_name`, `file_path`, `url`, `mime_type`, `size`, `alt_text`, `description`, `uploaded_by`
- Relazione `uploader()` (belongs-to User)
- Cast: `size` → `integer`, `uploaded_by` → `integer`
- SoftDeletes abilitato

#### Product (`app/Models/Product.php`)
- Fillable: vari campi prodotto + `posts_id`
- Relazione `post()` (belongs-to con ON DELETE CASCADE)
- Eliminato automaticamente quando il post associato viene cancellato

#### Category, Role, ecc.
- Modelli standard per categorizzazione e RBAC

### Middleware
- **auth**: protegge route che richiedono autenticazione (Laravel Breeze)
- **verified**: verifica email confermata (opzionale)
- **admin** (`EnsureUserIsAdmin`): verifica che l'utente abbia ruolo 'admin' tramite pivot `users_has_roles`

### Route

#### Route Pubbliche (`routes/web.php`)
```php
Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Dashboard (protetto da auth)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Include route admin
require __DIR__.'/admin.php';

// Laravel Breeze auth routes
require __DIR__.'/auth.php';
```

#### Route Admin (`routes/admin.php`)
Prefisso: `/admin`  
Middleware: `['auth', 'verified', EnsureUserIsAdmin::class]`  
Name prefix: `admin.`

**Posts Resource Routes:**
```php
GET    /admin/posts              → admin.posts.index       (lista)
GET    /admin/posts/create       → admin.posts.create      (form)
POST   /admin/posts              → admin.posts.store       (salva)
GET    /admin/posts/{post}       → admin.posts.show        (dettagli)
GET    /admin/posts/{post}/edit  → admin.posts.edit        (form edit)
PUT    /admin/posts/{post}       → admin.posts.update      (aggiorna)
DELETE /admin/posts/{post}       → admin.posts.destroy     (elimina)

// Extra endpoint per conteggio dipendenze
GET    /admin/posts/{post}/dependents → admin.posts.dependents
```

**Media Resource Routes:**
```php
GET    /admin/media              → admin.media.index       (lista)
GET    /admin/media/create       → admin.media.create      (form upload)
POST   /admin/media              → admin.media.store       (salva file)
GET    /admin/media/{media}      → admin.media.show        (dettagli)
GET    /admin/media/{media}/edit → admin.media.edit        (form edit)
PUT    /admin/media/{media}      → admin.media.update      (aggiorna metadata)
DELETE /admin/media/{media}      → admin.media.destroy     (elimina + file)
```

## Query API (Spatie Query Builder)

Abbiamo integrato [Spatie Laravel Query Builder](https://github.com/spatie/laravel-query-builder) per standardizzare filtri, ordinamenti e paginazione su risorse admin (Posts, Media).

### Parametri supportati
- Filtri: `filter[campo]=valore`  
  - Posts: `title` (partial), `excerpt` (partial)  
  - Media: `name` (partial), `file_name` (partial), `mime_type` (exact)
- Ordinamento: `sort=campo` oppure `sort=-campo` (desc)  
  - Posts: `created_at`, `title`  
  - Media: `created_at`, `name`, `file_name`, `size`
- Paginazione: `page` (numero pagina). Page size attuale: 20.
- Inclusione querystring persistente: i link di paginazione mantengono filtri e sort (`withQueryString()`).

### Esempi
- Posts per titolo, ordine recente:  
  `/admin/posts?filter[title]=news&sort=-created_at`
- Media per nome e mime, ordinati per size asc:  
  `/admin/media?filter[name]=logo&filter[mime_type]=image/png&sort=size&page=2`

## UI Admin Media: ricerca e sort server-side
- Barra di ricerca con debounce: invia `filter[name]` e `filter[file_name]`.
- Filtro `mime_type`.
- Sort dinamico (campo + asc/desc) allineato ai `allowedSorts`.
- Paginazione Inertia con preservazione dei parametri correnti.

### Validazione

#### PostController@store
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'slug' => 'nullable|string|max:255|unique:posts,slug',
    'content' => 'required|string',
    'category_id' => 'required|exists:categories,id',
    'cover_image' => 'nullable|image|max:5120', // 5MB
    'tags' => 'nullable', // array o stringa
    'published' => 'boolean',
]);
```

#### MediaController@store
```php
$validated = $request->validate([
    'file' => 'required|file|max:10240', // max 10MB
    'name' => 'nullable|string|max:255',
    'description' => 'nullable|string',
]);

// Salvataggio
$file = $request->file('file');
$path = $file->store('media', 'public');

$media = Media::create([
    'name' => $validated['name'] ?? $file->getClientOriginalName(),
    'file_name' => $file->getClientOriginalName(),
    'file_path' => $path,
    'url' => Storage::url($path),
    'mime_type' => $file->getMimeType(),
    'size' => $file->getSize(),
    'uploaded_by' => Auth::id(),
]);
```

#### MediaController@update
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
]);

$media->update($validated);
```

### Upload e Storage
- **Upload Posts**: File salvati in `storage/app/public/posts` via `Storage::disk('public')->putFile('posts', $file)`
- **Upload Media**: File salvati in `storage/app/public/media` con validazione (max 10MB)
- Path salvato nella colonna `file_path` della tabella `medias`
- URL pubblico generato automaticamente con `Storage::url($path)`
- **Symlink**: `public/storage → storage/app/public` creato con `php artisan storage:link`
  - Il symlink è un collegamento simbolico che rende i file in `storage/app/public` accessibili via web
  - URL esempio: `http://tuosito.com/storage/media/abc123.jpg` punta a `storage/app/public/media/abc123.jpg`
  - Vantaggi: sicurezza (storage fuori da public), organizzazione, backup semplificato

---

## Sviluppo

### Workflow quotidiano
1. **Avvia Vite** (HMR):
   ```bash
   npm run dev
   ```
2. **Avvia Laravel**:
   ```bash
   php artisan serve
   ```
3. **Accedi all'app**: http://localhost:8000
4. **Login come admin**: usa credenziali (admin@example.com / password)
5. **Login come user simplice**: usa credenziali (franks@example.com / qwerty111)

### Aggiungere una nuova pagina Inertia
1. Crea il componente Vue in `resources/js/Pages` (es. `Admin/Products/Index.vue`)
2. Aggiungi la route in `routes/admin.php`:
   ```php
   Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
   ```
3. Nel controller restituisci Inertia:
   ```php
   return Inertia::render('Admin/Products/Index', [
       'products' => Product::all(),
   ]);
   ```
4. Vite rileverà il nuovo componente automaticamente (HMR)

### Debugging
- **Laravel logs**: `storage/logs/laravel.log`
- **Vite logs**: terminale dove è stato avviato `npm run dev`
- **Browser console**: errori JS/Vue
- **Laravel Telescope** (opzionale): installa per UI debug avanzato
  ```bash
  composer require laravel/telescope --dev
  php artisan telescope:install
  php artisan migrate
  ```

### Comandi utili
```bash
# Pulire cache
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Pulire cache Vite
rm -rf node_modules/.vite

# Ricompilare asset
npm run build

# Verificare route
php artisan route:list

# Rollback migration (attenzione: distruttivo)
php artisan migrate:rollback

# Eseguire migration specifiche
php artisan migrate --path=database/migrations/YYYY_MM_DD_HHMMSS_migration_name.php
```

---

## Testing

### Configurazione Test Environment

Il progetto è configurato per usare **SQLite in-memory** per i test, garantendo velocità e isolamento.

#### Configurazione (già presente in `phpunit.xml`)
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="DB_FOREIGN_KEYS" value="false"/>
```

**Nota importante:** Le foreign key constraints sono **disabilitate** durante i test per semplificare il setup dei dati. Questo permette di testare operazioni CRUD senza dover creare manualmente tutti i record di riferimento.

### PHPUnit (backend)

```bash
# Esegui tutti i test
php artisan test

# Esegui test specifici
php artisan test tests/Feature/PostControllerTest.php

# Esegui con coverage (richiede Xdebug)
php artisan test --coverage

# Esegui test con output dettagliato
php artisan test --verbose
```

### Test Implementati

#### Feature Tests - PostController
File: `tests/Feature/PostControllerTest.php`

**Test disponibili (8 test, 17 assertions):**
1. ✅ `test_can_insert_post_to_database` - Verifica inserimento post
2. ✅ `test_can_store_large_html_content` - Verifica supporto longtext per HTML esteso
3. ✅ `test_can_retrieve_post_from_database` - Verifica lettura post
4. ✅ `test_can_update_post_in_database` - Verifica aggiornamento post
5. ✅ `test_can_delete_post_from_database` - Verifica eliminazione post
6. ✅ `test_post_can_have_nullable_fields` - Verifica campi opzionali (excerpt)
7. ✅ `test_multiple_posts_can_be_created` - Verifica creazione multipla
8. ✅ `test_post_content_supports_html` - Verifica supporto HTML complesso

**Caratteristiche:**
- Usa `RefreshDatabase` trait per database pulito ad ogni test
- Testa operazioni CRUD a livello database (non HTTP)
- Verifica supporto per contenuti HTML lunghi (campo `longtext`)
- Foreign keys disabilitate per semplificare il testing

### Creare Nuovi Test

#### Esempio: Feature Test con Authentication
```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_posts_index()
    {
        // Nota: Con FK disabilitate, non serve creare ruoli
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get(route('admin.posts.index'));
        
        $response->assertStatus(200);
    }
}
```

#### Esempio: Unit Test
```php
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\SlugHelper;

class SlugHelperTest extends TestCase
{
    public function test_generates_valid_slug()
    {
        $this->assertEquals(
            'il-mio-post',
            SlugHelper::generate('Il Mio Post!')
        );
    }
}
```

### Best Practices per Testing

1. **Usa RefreshDatabase** per test con database
2. **Non fare affidamento su FK** durante i test (sono disabilitate)
3. **Testa comportamenti, non implementazione**
4. **Mantieni test isolati** (nessuna dipendenza tra test)
5. **Usa factory per dati di test** quando possibile

---

## Deployment

### Preparazione produzione

#### 1. Configura `.env` produzione
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=your_production_db_host
DB_DATABASE=your_production_db
DB_USERNAME=your_production_user
DB_PASSWORD=your_secure_password

SESSION_SECURE_COOKIE=true
SESSION_DOMAIN=yourdomain.com
```

#### 2. Ottimizza configurazione
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 3. Compila asset produzione
```bash
npm run build
```

#### 4. Imposta permessi
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 5. Esegui migrations (su server di produzione)
```bash
php artisan migrate --force
```

### Server requirements
- **PHP** 8.2+ con estensioni richieste
- **Composer** installato
- **Node.js/npm** (solo per build, non necessario a runtime)
- **Web server**: Nginx o Apache
  - Document root: `public`
  - Configurare rewrite per front controller (`index.php`)
- **SSL certificate** (Let's Encrypt raccomandato)


### Deployment automatizzato (opzionale)
- **Laravel Forge**: gestione server e deploy automatico
- **Envoyer**: zero-downtime deployment
- **GitHub Actions**: CI/CD pipeline custom

---

## Troubleshooting

### Problema: "Failed to resolve import '@inertiajs/inertia-vue3'"
**Causa**: pacchetto non installato o cache Vite corrotta  
**Soluzione**:
```bash
npm install @inertiajs/inertia-vue3 --save
rm -rf node_modules/.vite
npm run dev
```

### Problema: "CORS request did not succeed" per @vite/client
**Causa**: Vite non in esecuzione o porta/host mismatch  
**Soluzione**:
```bash
# Verifica che Vite sia avviato
npm run dev

# Controlla che VITE_DEV_URL in .env corrisponda all'URL stampato da Vite
# Se Vite dice "Local: http://localhost:5173" ma .env ha 127.0.0.1, aggiorna .env
```

### Problema: Pagina bianca, nessun errore in console
**Causa**: Inertia non monta o CSS nasconde elementi  
**Soluzione**:
1. Apri DevTools → Console → esegui:
   ```js
   console.log(document.getElementById('app')?.dataset.page)
   ```
2. Verifica che restituisca JSON con `component` e `props`
3. Controlla Network tab: assicurati che app.js e Create.vue siano caricati (200/304)
4. Controlla che non ci siano overlay CSS (`display:none`, `opacity:0`)

### Problema: "Column not found: 1054 Unknown column 'tags'"
**Causa**: migration non eseguita  
**Soluzione**:
```bash
php artisan migrate --path=database/migrations/2025_11_28_105000_add_tags_to_posts_table.php --force
```

### Problema: "Integrity constraint violation: 1451 Cannot delete parent row"
**Causa**: tentativo di eliminare un post con prodotti dipendenti (prima della migration cascade)  
**Soluzione**:
- Applica migration per ON DELETE CASCADE:
  ```bash
  php artisan migrate --path=database/migrations/2025_11_28_110500_update_products_posts_fk_cascade.php --force
  ```
- Oppure elimina manualmente i prodotti dipendenti prima di eliminare il post

### Problema: "Session store not set on request" 
**Causa**: route non usa middleware 'web' o sessione non configurata  
**Soluzione**:
- Verifica che la route usi `middleware('web')`
- Controlla `.env`: `SESSION_DRIVER=file` e permessi su `storage/framework/sessions`

### Problema: "SQLSTATE[42S01]: Base table or view already exists"
**Causa**: migration già eseguita in precedenza  
**Soluzione**:
```bash
# Esegui solo migration specifiche non ancora migrate
php artisan migrate --path=database/migrations/YYYY_MM_DD_HHMMSS_migration_name.php

# Oppure resetta tutto (ATTENZIONE: cancella dati!)
php artisan migrate:fresh --seed
```

### Problema: File upload non funziona / 404 su immagini
**Causa**: symlink storage non creato  
**Soluzione**:
```bash
php artisan storage:link
# Verifica con: ls -la public/storage
# Deve mostrare: public/storage -> ../storage/app/public
```

### Problema: "Class 'Media' not found" o model non trovato
**Causa**: model non importato o namespace errato controlla che il model sia iportato bene. 
**Soluzione**:
```php
// In cima al controller
use App\Models\Media;
use App\Models\Post;
```

### Problema: Permessi Git "insufficient permission for adding object"
**Causa**: .git/objects ha ownership errato  
**Soluzione**:Aggiungi i permessi writte per il tuo user.
```bash
sudo chown -R $USER:$USER /path/to/wa-app/.git
# Oppure per tutti i file:
sudo chown -R $USER:$USER /path/to/wa-app
```

---

## Contribuire
---

## License

Questo progetto è distribuito con licenza MIT. Vedi file `LICENSE` per dettagli.

---

## 🔮 Features Roadmap

### Pianificate per v1.2
- [ ] **Gestione Products** CRUD completa (simile a Posts/Media)
- [ ] **Gestione Categories** con CRUD e gerarchia
- [ ] **Tag System normalizzato** (tabella dedicata invece di text field)
- [ ] **Media Library picker** per selezione immagini da Posts
- [ ] **Bulk operations** per Media (eliminazione multipla, cambio metadata)
- [ ] **Search & Filter** avanzato per Posts e Media
- [ ] **Pagination** per liste lunghe (Posts, Media, Products)

### Pianificate per v1.3
- [ ] **API REST** per Posts e Media (con Laravel Sanctum)
- [ ] **Image optimization** automatica al upload (thumbs, resize)
- [ ] **Drag & Drop** upload multiplo per Media
- [ ] **WYSIWYG editor** migliorato (integrazione Media Library)
- [ ] **User management** CRUD per admin
- [ ] **Activity Log** per tracciare modifiche

### Pianificate per v2.0
- [ ] **Multi-language support** (i18n per frontend e contenuti)
- [ ] **Advanced RBAC** (permissions granulari oltre admin/user)
- [ ] **Comments system** per Posts
- [ ] **SEO tools** (meta tags, sitemap, schema.org)
- [ ] **Analytics dashboard** (views, popular posts, storage usage)
- [ ] **Export/Import** contenuti (CSV, JSON)

### Considerazioni Future
- [ ] **Redis cache** per performance
- [ ] **Queue system** per task pesanti (image processing, notifications)
- [ ] **Elasticsearch** per search avanzato
- [ ] **CDN integration** per file statici
- [ ] **Docker setup** completo (Laravel Sail)

---

## 📡 API Endpoints (Future)

> **Nota**: API REST non ancora implementata. Attualmente solo Inertia/Blade rendering.

Pianificazione API v1 (Laravel Sanctum):

```
GET    /api/v1/posts              # Lista posts pubblici
GET    /api/v1/posts/{id}         # Dettagli post
GET    /api/v1/media              # Lista media (admin only)
POST   /api/v1/media              # Upload media (admin only)
GET    /api/v1/categories         # Lista categorie
```

Autenticazione pianificata: **Bearer Token** (Sanctum)

---

## 🤝 Contribuire

### Workflow Git
1. **Fork** il repository
2. **Crea un branch** per la tua feature:
   ```bash
   git checkout -b feature/nome-feature
   ```
3. **Commit** le modifiche (segui Conventional Commits):
   ```bash
   git add .
   git commit -m "feat: aggiunge funzionalità X"
   ```
4. **Push** al tuo fork:
   ```bash
   git push origin feature/nome-feature
   ```
5. **Apri una Pull Request** su GitHub

### Convenzioni
- **Commit messages**: segui [Conventional Commits](https://www.conventionalcommits.org/)
  - `feat:` nuova feature
  - `fix:` bug fix
  - `docs:` documentazione
  - `refactor:` refactoring (no breaking changes)
  - `test:` aggiunta test
  - `chore:` maintenance (dipendenze, build, ecc.)
- **Code style**: 
  - PHP: PSR-12 (usa `php-cs-fixer` o Laravel Pint)
  - JavaScript/Vue: ESLint config (Prettier per formatting)
- **Test**: aggiungi test per nuove feature (coverage minimo 70%)
- **Documentation**: aggiorna README se aggiungi feature o cambi API

### Checklist PR
- [ ] Ho testato localmente le modifiche
- [ ] Ho eseguito `php artisan test` (tutti i test passano)
- [ ] Ho eseguito `npm run build` (no errori di build)
- [ ] Ho aggiornato la documentazione se necessario
- [ ] Ho seguito le convenzioni di commit
- [ ] Non ho committato `.env` o file sensibili
- [ ] Ho aggiunto entry al CHANGELOG se applicabile

### Setup Ambiente Sviluppo
```bash
# Installa dev dependencies
composer install --dev
npm install --save-dev

# Configura pre-commit hooks (opzionale)
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models

# Abilita debug
# In .env:
APP_DEBUG=true
LOG_LEVEL=debug
```

---

## 📞 Contatti

- **Maintainer**: Softweb Team
- **Repository**: https://github.com/franksToscani/wa-app-Softweb
- **Issues**: https://github.com/franksToscani/wa-app-Softweb/issues
- **Discussions**: https://github.com/franksToscani/wa-app-Softweb/discussions

Per bug report, usa GitHub Issues con template:
```markdown
**Descrizione Bug:**
Breve descrizione

**Per Riprodurre:**
1. Vai su '...'
2. Clicca su '...'
3. Vedi errore

**Comportamento Atteso:**
Cosa dovrebbe succedere

**Screenshots:**
Se applicabile

**Ambiente:**
- OS: [es. Ubuntu 22.04]
- PHP: [es. 8.2.10]
- Laravel: [es. 12.36.1]
- Browser: [es. Chrome 120]
```

---

## Changelog

### [1.1.0] - 3 Dicembre 2025

####  Nuove Funzionalità
**Gestione Media CRUD Completa**
- ✅ MediaController con tutti i metodi CRUD (index, create, store, show, edit, update, destroy)
- ✅ 4 pagine Vue complete in `Admin/Media/`: Index, Create, Edit, Show
- ✅ Upload file con validazione (max 10MB)
- ✅ Preview real-time per immagini durante upload
- ✅ Thumbnails preview nella lista (12x12) con click per fullscreen
- ✅ Dialog modale per anteprima immagini
- ✅ Modifica metadata (nome, descrizione) senza modificare file
- ✅ Eliminazione media con rimozione fisica file da storage
- ✅ Relazione `uploaded_by` con tabella users
- ✅ Formattazione dimensioni file (B/KB/MB) nelle viste

**Dashboard Admin**
- ✅ Pagina Dashboard.vue con overview posts e prodotti
- ✅ Link rapidi "Gestione Posts" e "Gestione Media"
- ✅ Tabella posts recenti con info principali

#### 🔧 Miglioramenti Tecnici
- ✅ Migration `2025_12_03_111053_add_missing_columns_to_medias_table.php`
  - Aggiunge colonne: `name`, `url`, `description`, `uploaded_by`
  - Foreign key `uploaded_by` → `users.id` con ON DELETE SET NULL
- ✅ Configurato Model Media con:
  - `$table = 'medias'` (usa tabella esistente plurale)
  - Fillable fields aggiornati
  - Relazione `uploader()` con User
- ✅ Storage symlink configurato (`php artisan storage:link`)
- ✅ Route admin/media complete con naming convention

#### 📝 Documentazione
- ✅ README aggiornato con:
  - Sezione Media Management completa
  - Spiegazione symlink storage
  - Dettagli route admin
  - Esempi validazione
  - Struttura progetto espansa

### [1.0.0] - Novembre 2025

#### 🚀 Release Iniziale
**Gestione Posts**
- ✅ PostController CRUD completo
- ✅ Pagine Vue: Index, Create, Edit, Show
- ✅ Rich text editor Quill
- ✅ Upload immagine copertina
- ✅ Gestione tags (colonna text)
- ✅ Selezione categoria da dropdown
- ✅ Modal conferma eliminazione con endpoint dipendenze
- ✅ Endpoint `admin.posts.dependents` per conteggio prodotti

**Database**
- ✅ Migration `add_tags_to_posts_table` (colonna tags text nullable)
- ✅ Migration `update_products_posts_fk_cascade` (ON DELETE CASCADE)
- ✅ Seeder DevAdminSeeder (admin di sviluppo: devadmin@example.com / password)
- ✅ Relazioni Eloquent: Post ↔ Product con cascade delete

**Frontend Setup**
- ✅ Inertia.js + Vue 3 + PrimeVue stack
- ✅ Vite 7 con HMR
- ✅ Tailwind CSS 3
- ✅ PrimeVue components (Card, InputText, Dropdown, Editor, FileUpload, Dialog)
- ✅ Layout AuthenticatedLayout.vue
- ✅ Componenti riutilizzabili (PrimaryButton, InputLabel, TextInput, InputError)

**Autenticazione & RBAC**
- ✅ Laravel Breeze (Inertia stack)
- ✅ Middleware EnsureUserIsAdmin
- ✅ Tabelle: users, roles, users_has_roles
- ✅ Route protette con middleware auth + admin

**Infrastruttura**
- ✅ PHP 8.4.15 + Laravel 12.36.1
- ✅ MySQL 8.0+ / MariaDB 10.5+
- ✅ Node.js 18.x/20.x + npm
- ✅ Composer 2.x

#### 🐛 Bug Fix
- ✅ Fix import PrimeVue/Vite per evitare CORS errors
- ✅ Risolti problemi con Inertia component mounting
- ✅ Fix session cookie per HTTPS in produzione

---

**Happy coding! 🚀**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Spatie Query Builder & API REST

### Implementazione Query Builder
A partire dalla versione corrente, tutte le liste admin (Posts, Media) usano **Spatie Laravel Query Builder** per standardizzare filtri, ordinamenti e paginazione:

#### Parametri API standardizzati
- **Filtri**: `filter[campo]=valore` (partial o exact a seconda del filtro)
  - Posts: `title` (partial), `excerpt` (partial)
  - Media: `name` (partial), `file_name` (partial), `mime_type` (exact)
- **Ordinamento**: `sort=campo` o `sort=-campo` (discendente)
  - Posts: `created_at`, `title`
  - Media: `created_at`, `name`, `file_name`, `size`
- **Paginazione**: `page=N` (default 20 per pagina)
- **Persistenza**: i link di paginazione mantengono filtri/sort via `withQueryString()`

#### Esempi di utilizzo
```bash
# Posts recenti con titolo "news"
GET /api/posts?filter[title]=news&sort=-created_at

# Media PNG di nome "logo", pagina 2
GET /api/media?filter[name]=logo&filter[mime_type]=image/png&sort=size&page=2
```

### API REST Documentate
Le API sono disponibili su `/api/` e documentate con **L5-Swagger** (OpenAPI 3.0):

#### Endpoint pubblici (GET)
- `GET /api/posts` — Lista posts paginata con filtri/sort
- `GET /api/posts/{id}` — Dettaglio singolo post
- `GET /api/media` — Lista media paginata con filtri/sort
- `GET /api/media/{id}` — Dettaglio singolo media

#### Endpoint POST (interno)
- `POST /api/category-types` — Crea tipo categoria

### Accesso alla documentazione Swagger
```bash
# Genera/aggiorna la documentazione Swagger
php artisan l5-swagger:generate

# Accedi alla UI interattiva
http://localhost:8000/api/documentation
```

Da qui puoi:
- Leggere parametri, filtri, response di ogni endpoint
- Testare le API direttamente (Try it out)
- Vedere esempi di richiesta/risposta

---

compatibility edits so local tests pass quickly.
# wa-app-Softweb
# wa-app-Softweb
