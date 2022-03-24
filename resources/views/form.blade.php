
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario de entrevista</title>
</head>
<body>
    <h1>Formulario para los datos de la entrevista</h1>
    <h2>Hola: {{ $name }}</h2>
    <h2>Tu correo es: {{ $email }}</h2>

    <form action=""></form>

    <a href="{{ url('/logout') }}">Cerrar sesión</a>
</body>
</html>
