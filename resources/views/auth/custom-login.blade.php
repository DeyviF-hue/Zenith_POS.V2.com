<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Iniciar sesión - Zenith POS</title>
  <style>
    :root { --bg1: #0b5bd3; --bg2: #2563eb; --card: #ffffff; --text: #1f2937; --muted: #6b7280; }
    * { box-sizing: border-box; }
    html, body, #app { height: 100%; }
    body { margin: 0; font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto; color: var(--text); background: linear-gradient(135deg, var(--bg1) 0%, var(--bg2) 60%); }
    .layout { display: grid; grid-template-columns: 1.1fr 0.9fr; min-height: 100vh; }
    .left { padding: 60px; color: #fff; display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, rgba(11,91,211,.95), rgba(37,99,235,.95)); }
    .left h1 { font-size: 56px; margin: 0 0 12px; letter-spacing: 1px; }
    .left p { max-width: 420px; font-size: 16px; opacity: .95; }
    .right { display:flex; align-items:center; justify-content:center; padding: 40px; background: rgba(255,255,255,0); }
    .card { width: 100%; max-width: 420px; background: #fff; border-radius: 14px; padding: 28px; box-shadow: 0 16px 40px rgba(0,0,0,.15); }
    .card h2 { margin: 0 0 12px; font-size: 26px; font-weight: 700; }
    .field { margin-bottom: 12px; }
    label { display: block; font-size: 12px; color: #555; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .5px; }
    input[type="text"], input[type="password"] { width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid #e5e7eb; font-size: 14px; }
    .row { display:flex; align-items:center; justify-content: space-between; margin: 12px 0; }
    .btn { width: 100%; padding: 12px; border:0; border-radius: 8px; background: #2563eb; color:white; font-weight:700; cursor: pointer; }
    .link { font-size: 12px; color: #555; text-decoration: none; }
    .note { text-align:center; font-size: 12px; color: #777; margin-top: 8px; }
    @media (max-width: 900px) {
      .layout { grid-template-columns: 1fr; }
      .left { display: none; }
    }
  </style>
  </head>
  <body>
  <div class="layout">
    <section class="left" aria-label="Bienvenido">
      <div>
        <h1>BIENVENIDO</h1>
        <p>Accede al sistema Zenith POS con una experiencia de inicio de sesión limpia y moderna.</p>
      </div>
    </section>
    <section class="right" aria-label="Iniciar sesión">
      <div class="card">
        <h2>Iniciar sesión</h2>
        @if ($errors->any())
          <div style="color:#e11d48; font-size:12px; margin-bottom:8px;">
            {{ implode(' ', $errors->all()) }}
          </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="field">
            <label for="username">Usuario</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
          </div>
          <div class="field">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>
          </div>
          <div class="row" style="align-items:center;">
            <label style="font-size:14px;">
              <input type="checkbox" name="remember"> Recordarme
            </label>
            @if (Route::has('password.request'))
              <a class="link" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
          </div>
          <button class="btn" type="submit">Iniciar sesión</button>
        </form>
        <div class="note">¿No tienes cuenta? Regístrate</div>
      </div>
    </section>
  </div>
  </body>
</html>
