<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificado de Conclusão</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 18px;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 36px;
            margin: 0;
        }

        p {
            margin-bottom: 1.5em;
        }

        .certificate {
            border-radius: 20px;
            border: 10px solid #ccc;
            padding: 50px;
            margin: 50px;
            text-align: center;
        }

        .certificate h2 {
            font-size: 30px;
            margin-top: 0;
        }

        .certificate p {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .certificate .code {
            font-size: 24px;
            margin-top: 50px;
            font-weight: bold;
        }

        footer {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
<header>
    <h1>Certificado de Conclusão - Tigre Eventos</h1>
</header>

<div class="certificate">
    <h2>Certificado de Conclusão</h2>
    <p>Este certificado é apresentado a <strong>{{ $user->name }}</strong> por ter concluído o evento {{ $event->name }}.</p>
    <p>Data de emissão: {{ $emission_date->format('d/m/Y') }}</p>
    <p class="code"><a href="http://177.44.248.68:8002/validar-certificado/{{ $auth_code }}">Clique aqui para verificar sua validade.</a></p>
</div>

<footer>
    <p>© {{ date('Y') }} Tigre Eventos</p>
</footer>
</body>
</html>
