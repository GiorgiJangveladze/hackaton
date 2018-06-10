<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Page Title</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.web-fonts.ge/fonts/archyedt-bold/css/archyedt-bold.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>
    <header class="head" style="position:fixed;width:100%">
            <div class="container my-container row">
                <ul class=" row justify-content-between">
                    <a href="/group?person_id={{$person->id}}&factoid_type_id=&year="><li id="fact_btn">ჩემი კავშირები </li></a>
                </ul>
            </div>
    </header>
    <main id="main" class="container">
        <section id="data">
                
            <div class="paper">
                <p id="machine-write"></p>   
            </div>
        </section>
        <section id="person-chating">
            <div class="person">
                <div class="person-avatar" style="background-image: url('https://cdn4.iconfinder.com/data/icons/unigrid-human/61/011_millionaire_retro_holmes_watson_man_avatar_human_hipster_monocle_hat_mustache-512.png');"></div>
                <h1 class="person-name">{{$person->name}}</h1>
            </div>
            <div id="chat">
                <div class="messages">
                </div>
                <textarea id="chat-input" data-id ="{{$person->id}}" placeholder="დაწერე ტექსტი.."></textarea>
            </div>
        </section>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>     