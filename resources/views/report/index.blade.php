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
            @foreach ($reports as $report)
                <div class="elem-flex">
                    <p class="elem-flex__p elem-flex-date">{{ $report-> created_at }}</p>  
                    <p class="elem-flex__p elem-flex-number">{{ $report-> number }}</p>
                    <p class="elem-flex__p elem-flex-text">{{ $report-> description }}</p>
                    <?php
                        if($report -> status_id === 1) {
                            $statusIdText = "новое";
                        } elseif ($report -> status_id === 2) {
                            $statusIdText = "отклонено";
                        } elseif ($report -> status_id === 3) {
                            $statusIdText = "подтверждено";
                        }
                    ?>
                    <p>Статус заявления - <span>{{ $statusIdText }}</span></p>
                    <form action="{{ route('reports.destroy', $report->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <input type="submit" class="form-btn__input" value="Удалить">
                    </form>
                    <a href="{{ route('reports.edit', $report->id) }}">Update</a>
                </div>
            @endforeach
        </div>
    </main>
</body>
</html>