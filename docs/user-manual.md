# Manuale Utente – WA App

## Indice rapido
- Cos’è l’app
- Accesso e requisiti
- Ruoli e permessi
- Navigazione
- Gestione Post (lista, crea, modifica, elimina)
- Gestione Media (lista, carica, anteprima, elimina)
- Ricerca/filtri/ordinamenti (Query Builder)
- Limiti e validazioni
- Errori comuni
- Sicurezza
- Supporto

## 1. Cos’è l’app
Pannello admin e frontend pubblico per gestire contenuti (post) e media. Stack: Laravel + Inertia + Vue. Liste e API interne usano Spatie Query Builder per filtri/ordinamenti/paginazione consistenti.

## 2. Requisiti e accesso
- Browser moderno (Chrome, Firefox, Edge).
- URL principali: `/admin` (dashboard), `/admin/posts`, `/admin/media`, `/` (pubblico).
- Login con credenziali fornite; dopo il login appare il layout autenticato con menu admin.

## 3. Ruoli e permessi
- Serve un ruolo abilitato per accedere alle rotte admin. Se non vedi le voci di menu o ricevi 403, contatta l’amministratore per i permessi.

## 4. Navigazione
- Header/layout autenticato con link a dashboard, post, media.
- Pulsanti azione in alto a destra (nuovo, modifica, elimina, torna indietro).
- Paginazione a fondo lista; i link mantengono filtri e ordinamenti correnti.

## 5. Gestione Post (Admin)
### Lista `/admin/posts`
- Card con ID, titolo, estratto, stato (pubblicato/bozza), data creazione, badge evidenza/commenti.
- Ordinamento locale su `created_at`, `title`, `id` con toggle asc/desc; paginazione server-side (20/ pagina) mantiene i parametri.
- Ricerca client-side veloce su titolo/estratto (per pagina corrente).

### Dettaglio
- Mostra metadata: tipo, stato, categoria, template, evidenza, commenti, views, date create/update/published, media_id, parent_id, tags, contenuto completo.

### Creazione
1) Clic “New Post”. 2) Compila titolo (obbligatorio), contenuto/estratto, template opzionale. 3) Seleziona tipo/stato/categoria/parent/utente/media. 4) Upload cover image (max 5 MB). 5) Tag come lista separata da virgole. 6) Salva.

### Modifica
- Pulsante “Modifica” nel dettaglio o card azioni. Il form è precompilato; puoi cambiare campi, cover image, stato, template, tag.

### Eliminazione
- Pulsante “Elimina” apre conferma. Se esistono dipendenze (es. prodotti collegati) viene mostrato un messaggio e puoi decidere se forzare se previsto dalla UI.

## 6. Gestione Media (Admin)
### Lista `/admin/media`
- Tabella con preview immagini, nome, file_name, MIME, size, data. Paginazione server-side (20/ pagina).
- Barra di ricerca server-side (debounce) su `name` e `file_name`.
- Filtro MIME (image/jpeg, image/png, image/webp, application/pdf, ecc.).
- Ordinamento server-side per `created_at`, `name`, `file_name`, `size` con toggle asc/desc.

### Caricamento
1) Clic “Carica Media”. 2) Seleziona file (max 10 MB). 3) Nome/descrizione opzionali. 4) Salva. Il file viene salvato su storage pubblico, con URL generato.

### Anteprima
- Clic su thumbnail apre dialog con immagine (se MIME immagine), info file, link diretto.

### Eliminazione
- Pulsante “Elimina” rimuove record e file fisico se presente nello storage pubblico.

## 7. Ricerca, filtri, ordinamenti (Spatie Query Builder)
Parametri standardizzati per le liste admin:
- Filtri `filter[campo]=valore`
  - Post: `title` (partial), `excerpt` (partial)
  - Media: `name` (partial), `file_name` (partial), `mime_type` (exact)
- Ordinamento `sort=campo` o `sort=-campo` (desc)
  - Post: `created_at`, `title`
  - Media: `created_at`, `name`, `file_name`, `size`
- Paginazione `page` (numero pagina). Page size: 20. I link preservano filtri/sort (`withQueryString`).

Esempi:
- Post recenti con titolo “news”: `/admin/posts?filter[title]=news&sort=-created_at`
- Media png di nome “logo”, per size asc a pagina 2: `/admin/media?filter[name]=logo&filter[mime_type]=image/png&sort=size&page=2`

## 8. Limiti e validazioni
- Cover post: immagine max 5 MB.
- Upload media: file max 10 MB.
- Tag post: salvati come stringa separata da virgole.
- Campi obbligatori post: `title`; altri campi sono opzionali ma tipizzati (integer per id collegati, string per contenuti).

## 9. Errori comuni
- “Posts table missing” / “Post non trovato”: risorsa o tabella mancante.
- Eliminazione bloccata: esistono dipendenze (es. prodotti collegati). Rimuovi o forza se previsto.
- 403 in admin: ruolo o permessi mancanti.

## 10. Sicurezza
- Usa credenziali personali; esegui logout su dispositivi condivisi.
- Non caricare file sensibili se lo storage è pubblico.

## 11. Supporto
- Problemi di accesso/ruoli: contatta l’amministratore.
- Bug su filtri/paginazione: annota l’URL completo con querystring e segnala.
