<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main>
        <form action="{{ route('reports.store') }}" method="post" class="form-send">
            @csrf
            <input type="text" name="number" placeholder="Номер машины" class="form-input-send"><br>
            <textarea name="description" class="form-input-send"></textarea><br>
            <input type="submit" value="Создать заявку" class="form-input-send">
        </form>
    </main>
</body>
</html>