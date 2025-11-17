<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-app-layout>
        <main>
            <a href="{{ route('reports.create') }}">создать заявление</a>
            <div>
                <span>Сортировка по дате создания: </span>
                <a href="{{ route('reports.index', ['sort' => 'desc', 'status' => $status]) }}">Сначала новые</a>
                <a href="{{ route('reports.index', ['sort' => 'asc', 'status' => $status]) }}">Сначала старые</a>
            </div>
            <div>
                <p>Фильтрация по статусу заявки</p>
                <ul>
                    @foreach($statuses as $status)
                        <li>
                            <a href="{{route('reports.index',['sort' => $sort, 'status'=>$status->id])}}">{{$status->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="container-flex">
                @foreach ($reports as $report)
                    <div class="elem-flex">
                        <p class="elem-flex__p elem-flex-date">{{ $report-> created_at }}</p>  
                        <p class="elem-flex__p elem-flex-number">{{ $report-> number }}</p>
                        <p class="elem-flex__p elem-flex-text">{{ $report-> description }}</p>
                        <p>Статус заявления - <span>{{ $report->status->name }}</span></p>
                        <form action="{{ route('reports.destroy', $report->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <input type="submit" class="form-btn__input" value="Удалить">
                        </form>
                        <a href="{{ route('reports.edit', $report->id) }}">Update</a>
                    </div>
                @endforeach
                {{ $reports -> links() }}
            </div>
        </main>
    </x-app-layout>
</body>
</html>