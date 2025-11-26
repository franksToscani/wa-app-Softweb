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
      <div id="create-post-app" data-props='@json(["old" => session()->getOldInput()])'></div>
      @vite('resources/js/blade-create-post.js')
    </div>

  </div>
</body>
</html>
