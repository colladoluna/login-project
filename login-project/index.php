<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Nunito:wght@300;400;600&display=swap" rel="stylesheet"/>
</head>
<body>

  <div class="background">
    <div class="grid-lines"></div>
  </div>

  <main class="container">
    <div class="card">

      <div class="logo">
        <span class="logo-icon">&#9671;</span>
        <span class="logo-text">ACCESS</span>
      </div>

      <!-- Mensaje de error / éxito dinámico -->
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
          <?php
            $errors = [
              'empty'    => 'Por favor, rellena todos los campos.',
              'invalid'  => 'Usuario o contraseña incorrectos.',
              'inactive' => 'Esta cuenta está desactivada.',
            ];
            echo htmlspecialchars($errors[$_GET['error']] ?? 'Error desconocido.');
          ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['logout'])): ?>
        <div class="alert alert-success">Sesión cerrada correctamente.</div>
      <?php endif; ?>

      <form action="php/login.php" method="POST" novalidate>

        <div class="field">
          <label for="usuario">Usuario</label>
          <div class="input-wrap">
            <span class="input-icon">&#9671;</span>
            <input
              type="text"
              id="usuario"
              name="usuario"
              placeholder="tu_usuario"
              autocomplete="username"
              required
            />
          </div>
        </div>

        <div class="field">
          <label for="password">Contraseña</label>
          <div class="input-wrap">
            <span class="input-icon">&#9632;</span>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              autocomplete="current-password"
              required
            />
          </div>
        </div>

        <div class="options">
          <label class="remember">
            <input type="checkbox" name="remember" />
            <span>Recuérdame</span>
          </label>
          <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn-login">Entrar</button>

      </form>

      <p class="register-link">¿No tienes cuenta? <a href="#">Regístrate</a></p>

    </div>
  </main>

</body>
</html>
