<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital 7</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>

    <div class="login-container">
        <div class="login-box">
            <h2>Hospital 7</h2>
            <div class="avatar">
                <img src="{{ asset('images/user-avatar.png') }}" alt="User Avatar">
            </div>
            <h2>Iniciar Sesión</h2>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="usuario" placeholder="Usuario" required>
                </div>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <a href="{{ route('usuarios.index') }}" class="btn-ingresar">
                    Ingresar
                </a>
                <a href="#" class="forgot">No tienes cuenta? Registrate aqui</a>
                <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>