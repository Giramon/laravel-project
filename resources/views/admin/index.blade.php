<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Все заявки</title>
    @vite(['resources/css/reset.css'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<x-app-layout>
    <h1>Административная панель</h1>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Текст заявления</th>
                    <th>Номер авто</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <?php
                            $name = $report->user->name ?? '';
                            $middlename = $report->user->middlename ?? '';
                            $lastname = $report->user->lastname ?? '';
                            $fio =  $name . ' ' . $middlename . ' ' . $lastname;
                        ?>
                        <td><?php if(empty($name)) { echo 'Не указано'; } else { echo $fio; } ?></td>
                        <td>{{ $report-> description }}</td>
                        <td>{{ $report-> number }}</td>
                        <td>
                            <div>
                                <form action="{{ route('reports.status.update', $report->id) }}" method="POST" class="status-form">
                                    @method('patch')
                                    @csrf
                                    <select name="status_id" id="status_id">
                                        @foreach($statuses as $status)
                                        <option value="{{$status->id}}" {{$status->id === $report->status_id ? 'selected' : ''}}>
                                            {{$status->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-app-layout>
</body>
</html>