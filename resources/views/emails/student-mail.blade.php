<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Approval Email</title>
</head>

<body>
    <p>Estimado Estudiante,</p>

    @if ($approved)
    <p style="color: red;">Felicidades, tu registro ha sido aprobado.</p>
    @else
    <p>Lamentamos informarte que tu registro ha sido rechazado.</p>
    @endif

    <p>Gracias por registrarte en nuestra plataforma.</p>

    <p>Atentamente,<br>
        Tu Plataforma</p>
</body>

</html>