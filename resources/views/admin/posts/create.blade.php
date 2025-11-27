@extends('layouts.simple')

@section('title', 'Crea Nuovo Post')

@php
  // The page-specific styles were moved to `resources/css/admin-posts.css`.
  // The layout `layouts.simple` includes that CSS via @vite in local env.
@endphp

@section('content')
  <div class="container admin-posts-page">
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
@endsection
