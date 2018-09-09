<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background: #50E3A4;
            height: 100vh;
            width: 100vw;
            padding: 0;
            margin: 0;
        }

        .flex-container {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: stretch;
        }

        .flex-between {
            justify-content: space-between;
        }

        .flex-horizontal {
            flex-direction: row;
        }

        .card {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .1);
            margin: 20px auto;
            padding: 25px;
            position: relative;
            width: 90%;
        }

        li {
            align-items: center;
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        li a, li span, li button {
            font-size: 1.5em;
            letter-spacing: 1px;
        }

        li button {
            box-sizing: border-box;
            background-color: transparent;
            border: 2px solid #e74c3c;
            border-radius: 0.6em;
            color: #e74c3c;
            cursor: pointer;
            display: flex;
            align-self: center;
            padding: 0.5em 1em;
            text-decoration: none;
            text-align: center;
            text-transform: uppercase;
            font-family: 'Montserrat', sans-serif;
            transition: box-shadow 300ms ease-in-out, color 300ms ease-in-out;
        }

        li button:hover {
            box-shadow: 0 0 40px 40px #e74c3c inset;
        }

        li button:hover,
        li button:focus {
             color: #fff;
             outline: 0;
         }

        .dropzone {
            flex:1;
            padding: 25px;
            border-width: 2px;
            border-color: rgb(102, 102, 102);
            border-style: dashed;
            border-radius: 5px;
            text-align: center;
        }

        .rc-progress-circle {
            width: 2em;
            height: 2em;
        }
    </style>
</head>
<body>
    <div id="main"></div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
