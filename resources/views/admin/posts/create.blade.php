<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Crea Nuovo Post</title>

  <link rel="stylesheet" href="/build/assets/app.css">

  <style>
    /* Layout */
    body { background:#f5f6fa; font-family: Inter, sans-serif; }
    .container { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
    h1 { margin-bottom: 1rem; font-weight: 700; }

    .card {
      background: #fff;
      padding: 1.75rem;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr 330px;
      gap: 1.5rem;
    }
    @media (max-width: 900px) {
      .grid { grid-template-columns: 1fr; }
    }

    /* Inputs */
    .form-group { margin-bottom: 1rem; }
    label {
      display: block;
      margin-bottom: 0.3rem;
      font-weight: 600;
    }

    input[type="text"],
    input[type="number"],
    input[type="datetime-local"],
    textarea,
    select {
      width: 100%;
      padding: 0.6rem 0.75rem;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 15px;
      transition: 0.2s;
    }

    input:focus,
    textarea:focus,
    select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99,102,241,0.25);
      outline: none;
    }

    textarea { resize: vertical; }

    /* Error display */
    .error {
      color: #dc2626;
      font-size: 0.9rem;
      margin-top: 2px;
    }

    /* Buttons */
    .actions {
      margin-top: 1.5rem;
      display: flex;
      gap: 0.75rem;
    }

    .btn {
      padding: 0.75rem 1.25rem;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      text-align: center;
      text-decoration: none;
      display: inline-block;
    }

    .btn-primary {
      background: #16a34a;
      color: #fff;
      border: none;
    }
    .btn-primary:hover { background: #15803d; }

    .btn-secondary {
      background: #e5e7eb;
      color: #111827;
    }
    .btn-secondary:hover { background: #d1d5db; }

    /* Switch */
    .switch-wrapper {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .switch {
      position: relative;
      width: 48px;
      height: 24px;
    }

    .switch input { display:none; }

    .slider {
      position: absolute;
      inset: 0;
      background: #d1d5db;
      border-radius: 24px;
      transition: .3s;
      cursor: pointer;
    }

    .slider:before {
      content: "";
      position: absolute;
      width: 20px;
      height: 20px;
      left: 2px;
      top: 2px;
      background: white;
      border-radius: 50%;
      transition: .3s;
    }

    .switch input:checked + .slider {
      background: #4ade80;
    }

    .switch input:checked + .slider:before {
      transform: translateX(24px);
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Crea Nuovo Post</h1>

    <div class="card">
      <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid">
          <!-- COLONNA PRINCIPALE -->
          <div>

            <div class="form-group">
              <label for="title">Titolo *</label>
              <input id="title" name="title" type="text" value="{{ old('title') }}" required>
              @error('title')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="slug">Slug</label>
              <input id="slug" name="slug" type="text" value="{{ old('slug') }}">
              @error('slug')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="excerpt">Excerpt</label>
              <textarea id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
              @error('excerpt')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="content">Contenuto</label>
              <textarea id="content" name="content" rows="12">{{ old('content') }}</textarea>
              @error('content')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="template">Template</label>
              <input id="template" name="template" type="text" value="{{ old('template') }}">
              @error('template')<div class="error">{{ $message }}</div>@enderror
            </div>

          </div>

          <!-- SIDEBAR -->
          <aside>

            <div class="form-group">
              <label for="category_id">Categoria *</label>
              <select id="category_id" name="category_id">
                <option value="">-- Seleziona --</option>
                @foreach(($categories ?? []) as $cat)
                  <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="posts_types_id">Tipo Post</label>
              <select id="posts_types_id" name="posts_types_id">
                <option value="">-- Seleziona --</option>
                @foreach(($postsTypes ?? []) as $t)
                  <option value="{{ $t->id }}" @selected(old('posts_types_id') == $t->id)>
                    {{ $t->name }}
                  </option>
                @endforeach
              </select>
              @error('posts_types_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="posts_status_id">Stato</label>
              <select id="posts_status_id" name="posts_status_id">
                <option value="">-- Seleziona --</option>
                @foreach(($postsStatus ?? []) as $s)
                  <option value="{{ $s->id }}" @selected(old('posts_status_id') == $s->id)>
                    {{ $s->name }}
                  </option>
                @endforeach
              </select>
              @error('posts_status_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="parent_id">Parent Post</label>
              <select id="parent_id" name="parent_id">
                <option value="">-- Nessuno --</option>
                @foreach(($parents ?? []) as $p)
                  <option value="{{ $p->id }}" @selected(old('parent_id') == $p->id)>
                    {{ $p->title }}
                  </option>
                @endforeach
              </select>
              @error('parent_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="users_id">Autore</label>
              <select id="users_id" name="users_id">
                <option value="">-- Seleziona --</option>
                @foreach(($users ?? []) as $u)
                  <option value="{{ $u->id }}" @selected(old('users_id') == $u->id)>
                    {{ $u->name }}
                  </option>
                @endforeach
              </select>
              @error('users_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="media_id">Media</label>
              <select id="media_id" name="media_id">
                <option value="">-- Nessuno --</option>
                @foreach(($medias ?? []) as $m)
                  <option value="{{ $m->id }}" @selected(old('media_id') == $m->id)>
                    {{ $m->file_name }}
                  </option>
                @endforeach
              </select>
              @error('media_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="views_count">Views Count</label>
              <input id="views_count" name="views_count" type="number" min="0" value="{{ old('views_count', 0) }}">
              @error('views_count')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="published_at">Data Pubblicazione</label>
              <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at') }}">
              @error('published_at')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="tags">Tags (separati da virgola)</label>
              <input id="tags" name="tags" type="text" value="{{ old('tags') }}">
              @error('tags')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label>Immagine di Copertina</label>
              <input id="cover_image" name="cover_image" type="file" accept="image/*">
              @error('cover_image')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label>Pubblicato</label>
              <div class="switch-wrapper">
                <label class="switch">
                  <input id="is_published" name="is_published" type="checkbox" value="1"
                    @checked(old('is_published'))>
                  <span class="slider"></span>
                </label>
              </div>
            </div>

            <div class="actions">
              <button type="submit" class="btn btn-primary">Crea Post</button>
              <a href="{{ route('dashboard') }}" class="btn btn-secondary">Annulla</a>
            </div>

          </aside>
        </div>

      </form>
    </div>

  </div>
</body>
</html>
