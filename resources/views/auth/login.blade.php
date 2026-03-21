<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Iniciar sesión — Zenith POS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --primary:   {{ config('zenith.primary_color', '#6C5CE7') }};
      --primary-d: #5648C8; /* optional shade adjustment or keep static */
      --primary-l: {{ config('zenith.accent_color', '#A29BFE') }};
      --dark:      {{ config('zenith.sidebar_color', '#2D2A3A') }};
      --dark2:     #3D3952;
      --bg:        #F4F3FF;
      --text:      #1F1D2E;
      --muted:     #6C6A7A;
      --border:    #E2E0FF;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
    }

    /* ── Left panel ── */
    .panel-left {
      flex: 1 1 55%;
      background: var(--dark);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px 48px;
      position: relative;
      overflow: hidden;
    }

    /* decorative orbs */
    .panel-left::before,
    .panel-left::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      opacity: 0.18;
    }
    .panel-left::before {
      width: 520px; height: 520px;
      background: radial-gradient(circle, var(--primary), transparent);
      top: -120px; left: -120px;
    }
    .panel-left::after {
      width: 340px; height: 340px;
      background: radial-gradient(circle, var(--primary-l), transparent);
      bottom: -80px; right: -60px;
    }

    .brand-hero {
      position: relative;
      z-index: 1;
      text-align: center;
      max-width: 420px;
    }

    .brand-logo {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, var(--primary), var(--primary-l));
      border-radius: 18px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      color: #fff;
      margin-bottom: 28px;
      box-shadow: 0 12px 36px rgba(108,92,231,0.5);
    }

    .brand-hero h1 {
      font-size: 42px;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.5px;
      line-height: 1.1;
    }
    .brand-hero h1 span { color: var(--primary-l); }

    .brand-hero p {
      margin-top: 16px;
      color: rgba(255,255,255,0.6);
      font-size: 15px;
      line-height: 1.7;
    }

    .features {
      margin-top: 40px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      width: 100%;
    }
    .feature-item {
      display: flex;
      align-items: center;
      gap: 14px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 12px;
      padding: 14px 18px;
    }
    .feature-icon {
      width: 36px; height: 36px;
      background: rgba(108,92,231,0.3);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-l);
      font-size: 14px;
      flex-shrink: 0;
    }
    .feature-item span {
      color: rgba(255,255,255,0.75);
      font-size: 13.5px;
      font-weight: 500;
    }

    /* ── Right panel ── */
    .panel-right {
      flex: 0 0 45%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 44px;
      background: #fff;
    }

    .login-card {
      width: 100%;
      max-width: 400px;
    }

    .login-card .top-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 36px;
    }
    .top-logo-icon {
      width: 38px; height: 38px;
      background: linear-gradient(135deg, var(--primary), var(--primary-l));
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 16px;
    }
    .top-brand-name {
      font-size: 18px;
      font-weight: 800;
      color: var(--text);
      letter-spacing: 0.2px;
    }
    .top-brand-name span { color: var(--primary); }

    .login-card h2 {
      font-size: 26px;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 4px;
    }
    .login-card .subtitle {
      font-size: 14px;
      color: var(--muted);
      margin-bottom: 32px;
    }

    /* Error alert */
    .alert-error {
      background: #FFF0EE;
      border: 1px solid #FFCABA;
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 13px;
      color: #C0392B;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 8px;
    }

    /* Fields */
    .field-group {
      margin-bottom: 20px;
    }
    .field-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: var(--muted);
      margin-bottom: 8px;
    }
    .input-wrap {
      position: relative;
    }
    .input-wrap .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #C0BEDE;
      font-size: 14px;
    }
    .input-wrap input {
      width: 100%;
      padding: 13px 16px 13px 42px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      color: var(--text);
      background: var(--bg);
      transition: border-color 0.18s ease, box-shadow 0.18s ease;
      outline: none;
    }
    .input-wrap input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(108,92,231,0.15);
      background: #fff;
    }

    /* Bottom row */
    .field-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }
    .remember-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--muted);
      cursor: pointer;
    }
    .remember-label input[type=checkbox] {
      accent-color: var(--primary);
      width: 16px; height: 16px;
    }
    .forgot-link {
      font-size: 13px;
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
    }
    .forgot-link:hover { text-decoration: underline; }

    /* Submit button */
    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, var(--primary), var(--primary-d));
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 700;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      letter-spacing: 0.3px;
      box-shadow: 0 6px 20px rgba(108,92,231,0.4);
      transition: all 0.2s ease;
      position: relative;
      overflow: hidden;
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(108,92,231,0.5);
    }
    .btn-login:active { transform: translateY(0); }

    .login-footer {
      text-align: center;
      margin-top: 28px;
      font-size: 13px;
      color: var(--muted);
    }

    /* Responsive */
    @media (max-width: 820px) {
      .panel-left { display: none; }
      .panel-right { flex: 1; padding: 32px 24px; }
    }
  </style>
</head>
<body>

  <!-- ── Left decorative panel ── -->
  <aside class="panel-left">
    <div class="brand-hero">
      <div class="brand-logo"><i class="fas fa-bolt"></i></div>
      <h1>ZENITH <span>POS</span></h1>
      <p>El sistema de gestión de punto de venta inteligente<br>diseñado para equipos modernos.</p>

      <div class="features">
        <div class="feature-item">
          <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
          <span>Reportes y estadísticas en tiempo real</span>
        </div>
        <div class="feature-item">
          <div class="feature-icon"><i class="fas fa-boxes"></i></div>
          <span>Gestión completa de inventario y productos</span>
        </div>
        <div class="feature-item">
          <div class="feature-icon"><i class="fas fa-users"></i></div>
          <span>Administración de clientes y asesores</span>
        </div>
        <div class="feature-item">
          <div class="feature-icon"><i class="fas fa-lock"></i></div>
          <span>Sistema seguro y modular</span>
        </div>
      </div>
    </div>
  </aside>

  <!-- ── Right login panel ── -->
  <main class="panel-right">
    <div class="login-card">

      <!-- Mini brand on mobile -->
      <div class="top-brand">
        <div class="top-logo-icon"><i class="fas fa-bolt"></i></div>
        <div class="top-brand-name">ZENITH <span>POS</span></div>
      </div>

      <h2>Bienvenido de nuevo</h2>
      <p class="subtitle">Ingresa tus credenciales para acceder al sistema</p>

      @if ($errors->any())
        <div class="alert-error">
          <i class="fas fa-exclamation-circle" style="margin-top:2px;"></i>
          <div>{{ implode(' ', $errors->all()) }}</div>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field-group">
          <label for="username">Usuario o correo electrónico</label>
          <div class="input-wrap">
            <i class="fas fa-user input-icon"></i>
            <input
              id="username"
              type="text"
              name="username"
              value="{{ old('username') }}"
              required
              autofocus
              placeholder="tu@correo.com o nombre de usuario"
            />
          </div>
        </div>

        <div class="field-group">
          <label for="password">Contraseña</label>
          <div class="input-wrap">
            <i class="fas fa-lock input-icon"></i>
            <input
              id="password"
              type="password"
              name="password"
              required
              placeholder="••••••••"
            />
          </div>
        </div>

        <div class="field-row">
          <label class="remember-label">
            <input type="checkbox" name="remember" />
            Recordarme
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
          @endif
        </div>

        <button type="submit" class="btn-login">
          <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i>Iniciar sesión
        </button>
      </form>

      <div class="login-footer">
        © {{ date('Y') }} Zenith POS · Todos los derechos reservados
      </div>
    </div>
  </main>

</body>
</html>
