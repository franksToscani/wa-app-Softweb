<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

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

If you'd like, I can prepare a follow-up PR that keeps production-targeted migrations unchanged and adds a
small `migrations/testing` step that runs only for SQLite test environments. For now this branch contains the
compatibility edits so local tests pass quickly.
