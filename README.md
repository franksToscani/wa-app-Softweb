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
- **Admin panel** completo per la gestione di posts, categorie, utenti, media
- **SPA (Single Page Application)** con Inertia.js per un'esperienza utente fluida
- **PrimeVue UI components** per interfacce ricche e responsive
- **Rich text editor** (Quill) per contenuti formattati
- **Upload immagini** con preview e gestione media
- **Gestione Media CRUD completa** con upload, preview, modifica ed eliminazione file
- **Gestione relazioni** con cascade delete (products ↔ posts)
- **Autenticazione** con Laravel Breeze (Inertia stack)
- **Role-based access control** (admin middleware)
- **Storage symlink** per accesso pubblico ai file caricati

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

## Installazione

### 1. Clona il repository
```bash
git clone https://github.com/your-org/wa-app.git
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
│   │   └── Pages/              # Vue SFC pages (Inertia components)
│   │       ├── Admin/
│   │       │   └── Posts/
│   │       │       ├── Index.vue
│   │       │       └── Create.vue
│   │       ├── Auth/
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
- **Auth/Login.vue**: pagina di login
- **Admin/Posts/Index.vue**: lista posts con azioni (crea, modifica, elimina + modal conferma)
- **Admin/Posts/Create.vue**: form creazione post (usa Quill editor, FileUpload, Dropdown per categoria, ecc.)
- **Admin/Media/Index.vue**: lista media con tabella, preview thumbnails, dialog anteprima, azioni CRUD
- **Admin/Media/Create.vue**: form upload file con preview immagini in tempo reale
- **Admin/Media/Edit.vue**: form modifica nome/descrizione con anteprima file
- **Admin/Media/Show.vue**: pagina dettagli completa con info file, download, visualizzazione

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

### Middleware
- **auth**: protegge route che richiedono autenticazione
- **admin**: verifica che l'utente abbia ruolo 'admin' (controlla pivot `users_has_roles`)

### Route
- **web.php**: route pubbliche (home, ecc.)
- **admin.php**: route admin (prefisso `/admin`, middleware `['web','auth','admin']`)
  - Resource Posts: `posts` (index, create, store, show, edit, update, destroy)
  - Extra Posts: `admin.posts.dependents` (GET)
  - Resource Media: `media` (index, create, store, show, edit, update, destroy)
    - `GET /admin/media` - Lista media
    - `GET /admin/media/create` - Form upload
    - `POST /admin/media` - Salva upload
    - `GET /admin/media/{media}` - Dettagli
    - `GET /admin/media/{media}/edit` - Form modifica
    - `PUT /admin/media/{media}` - Aggiorna metadata
    - `DELETE /admin/media/{media}` - Elimina

### Validazione
Esempio (PostController@store):
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
4. **Login come admin**: usa credenziali seeded (devadmin@example.com / password)

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

### PHPUnit (backend)
```bash
# Esegui tutti i test
php artisan test

# Esegui test specifici
php artisan test --filter PostControllerTest
```

### Test consigliati da implementare
- **Feature test**: creazione/modifica/eliminazione post (con authentication)
- **Unit test**: validazione input, slugify helper, ecc.
- **Browser test (Dusk)**: flow completo di creazione post via UI

### Esempio test (da creare)
```php
// tests/Feature/Admin/PostControllerTest.php
public function test_admin_can_create_post()
{
    $admin = User::factory()->create();
    $admin->roles()->attach(Role::where('nome', 'admin')->first());
    
    $this->actingAs($admin)
         ->post(route('admin.posts.store'), [
             'title' => 'Test Post',
             'content' => 'Content',
             'category_id' => 1,
         ])
         ->assertRedirect(route('admin.posts.index'));
    
    $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
}
```

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

### Esempio Nginx config
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/wa-app/public;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

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

---

## Contribuire

### Workflow Git
1. **Fork** il repository
2. **Crea un branch** per la tua feature:
   ```bash
   git checkout -b feature/nome-feature
   ```
3. **Commit** le modifiche:
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
- **Code style**: segui PSR-12 (PHP) e ESLint config (JS)
- **Test**: aggiungi test per nuove feature (coverage minimo 70%)

### Checklist PR
- [ ] Ho testato localmente le modifiche
- [ ] Ho eseguito `php artisan test` (tutti i test passano)
- [ ] Ho aggiornato la documentazione se necessario
- [ ] Ho seguito le convenzioni di commit
- [ ] Non ho committato `.env` o file sensibili

---

## License

Questo progetto è distribuito con licenza MIT. Vedi file `LICENSE` per dettagli.

---

## Contatti

- **Maintainer**: [Softweb]
- **Email**: [tua email]
- **Repository**: https://github.com/franksToscani/wa-app-Softweb
- **Issues**: https://github.com/franksToscani/wa-app-Softweb/issues

---

## Changelog

### [Unreleased]
- **Gestione Media CRUD completa** (3 dicembre 2025)
  - Aggiunto MediaController con tutti i metodi CRUD
  - Create 4 pagine Vue (Index, Create, Edit, Show) in Admin/Media
  - Tabella medias estesa con campi: name, url, description, uploaded_by
  - Upload file con validazione (max 10MB), preview immagini
  - Dialog anteprima nella lista, eliminazione file fisico su delete
  - Route admin/media con tutte le operazioni CRUD
  - Fix namespace controller (admin → Admin) per conformità PSR-4
  - Migration per aggiungere colonne mancanti alla tabella medias esistente
  - Storage symlink configurato per accesso pubblico ai file
- Aggiunta pagina admin posts (index/create)
- Gestione tags in posts
- Modal conferma eliminazione con conteggio dipendenze
- Migration per ON DELETE CASCADE su products.posts_id
- Fix import PrimeVue/Vite
- Seeder DevAdminSeeder per test rapidi

### [1.0.0] - YYYY-MM-DD
- Release iniziale

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


## Note about tests and migrations (important)

During local development we run the test-suite using SQLite in-memory to keep tests fast and isolated.

To make the existing project migrations run reliably under SQLite (used by PHPUnit in `phpunit.xml`) a
small set of compatibility adjustments were made to the migration files in this branch. These are **test-focused**
changes that avoid SQLite-specific migration errors such as:

- composite primary keys that include an autoincrement `id` column (SQLite can't create an AUTOINCREMENT column
	as part of a composite primary key);
- explicit, repeated index/unique names (SQLite treats index names globally in an in-memory DB and identically
	named indexes across tables cause collisions).

Why we did this
- The changes keep tests green and fast (no external MySQL test DB required). They are minimal and scoped to
	migration definitions only so tests can run in CI or locally using `php artisan test`.

How this affects production
- If your production schema requires the original MySQL-only constraints (composite PKs or specific index names),
	you should either:
	- create a dedicated MySQL test database and update `phpunit.xml` accordingly, or
	- add separate migration(s) that apply production-only constraints at deploy time (or gated by an environment
		check).

Commands to run the test-suite locally
```bash
# ensure php-sqlite3 is installed (on Debian/Ubuntu):
sudo apt-get update
sudo apt-get install -y php-sqlite3

# fix permissions if you get storage permission errors:
sudo chown -R $(whoami):www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

# run tests (non-parallel):
php artisan test --no-coverage
```

compatibility edits so local tests pass quickly.
# wa-app-Softweb
# wa-app-Softweb
