<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        </style>
    </head>
    <body>
  
      <form action="{{route('chat')}}" method="POST"> {{csrf_field()}}
        <input type="text" name="question">
        <input type="text" name="person">
        <input type="submit" value="submit">
      </form>

    </body>
</html>
