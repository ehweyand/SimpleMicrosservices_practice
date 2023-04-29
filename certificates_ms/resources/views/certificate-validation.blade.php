<!DOCTYPE html>
<html>
<head>
    <title>Autenticação de Certificado</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: "Open Sans", sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            text-align: center;
            color: #555;
            text-transform: uppercase;
        }
        p {
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
            color: #777;
        }
        .name {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
            text-transform: uppercase;
        }
        .event {
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
            color: #333;
            text-transform: uppercase;
        }
        .congrats {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #555;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Certificado de Participação VÁLIDO!</h1>
    <p>Este certificado é concedido a:</p>
    <p class="name">{{ $certificate->user->name }}</p>
    <p>por sua participação no evento:</p>
    <p class="event">{{ $certificate->event->description }}</p>
</div>
</body>
</html>
