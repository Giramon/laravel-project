<?php

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main>
        <a href="{{ route('reports.create') }}">создать заявление</a>
        <div class="container-flex">
            <div class="elem-flex">
                @foreach ($reports as $report)
                <p class="elem-flex__p elem-flex-date">01.10.2024</p>
                <p class="elem-flex__p elem-flex-number">A123BC 174</p>
                <p class="elem-flex__p elem-flex-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae itaque voluptate quaerat, cumque neque qui numquam exercitationem quod laborum nihil ipsa, minima explicabo illum facilis voluptatem doloremque nesciunt iure. Praesentium.</p>
                <p>Статус заявления - <span>подтверждено</span></p>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>