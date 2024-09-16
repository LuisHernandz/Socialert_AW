@extends('errors::minimal')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Error - Algo salió mal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="error-message">
            <h1>500</h1> <!-- Código de error directo -->
            <p class="message">Algo salió mal por nuestra parte</p> <!-- Mensaje de error directo -->
            <p class="sub-message">No te preocupes, lo resolveremos rápidamente</p>
            <a href="/" class="home-link">Regresar<span>&#8594;</span></a>
        </div>
    </div>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 900px;
            margin: 0 auto;
        }

        .broken-lightbulb img {
            max-width: 300px;
        }

        .error-message {
            margin-left: 20px;
        }

        h1 {
            font-size: 96px;
            color: #007bff;
            margin-bottom: 20px;
        }

        .message {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .sub-message {
            font-size: 14px;
            color: #777;
            margin-bottom: 40px;
        }

        .home-link {
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            color: #000;
            display: inline-flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .home-link span {
            margin-left: 10px;
            font-size: 18px;
            transition: margin-left 0.3s ease;
        }

        .home-link:hover {
            color: #007bff;
        }

        .home-link:hover span {
            margin-left: 15px;
        }
    </style>
</body>
</html>
