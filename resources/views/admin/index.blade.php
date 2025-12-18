<!DOCTYPE html>
<html lang="ru" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора | Нарушений.нет</title>
    @vite(['resources/css/reset.css'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-slate-600">
    <x-app-layout>
        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900">Управление заявками</h1>
                    <p class="mt-1 text-sm text-slate-500">Администрирование входящих заявлений пользователей</p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="flex flex-col xl:flex-row gap-6 justify-between items-start xl:items-center">
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full xl:w-auto">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Сортировка</span>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.index', ['sort' => 'desc', 'status' => $statusId]) }}" 
                                   class="px-3 py-1.5 text-sm rounded border border-transparent {{ request('sort') == 'desc' || !request('sort') ? 'bg-slate-100 text-slate-900 font-bold' : 'text-slate-500 hover:bg-slate-50' }} transition-colors">
                                    Сначала новые
                                </a>
                                <a href="{{ route('admin.index', ['sort' => 'asc', 'status' => $statusId]) }}" 
                                   class="px-3 py-1.5 text-sm rounded border border-transparent {{ request('sort') == 'asc' ? 'bg-slate-100 text-slate-900 font-bold' : 'text-slate-500 hover:bg-slate-50' }} transition-colors">
                                    Сначала старые
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full xl:w-auto overflow-x-auto">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Статус</span>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.index', ['sort' => $sort]) }}"
                                   class="px-3 py-1.5 text-sm rounded-full border transition-all whitespace-nowrap
                                   {{ !$statusId ? 'bg-slate-800 text-white border-slate-800' : 'border-gray-200 text-gray-600 hover:border-gray-400' }}">
                                    Все
                                </a>
                                @foreach($statuses as $status)
                                    <a href="{{ route('admin.index', ['sort' => $sort, 'status' => $status->id]) }}"
                                       class="px-3 py-1.5 text-sm rounded-full border transition-all whitespace-nowrap
                                       {{ $status->id == $statusId 
                                            ? 'bg-slate-800 text-white border-slate-800' 
                                            : 'border-gray-200 text-gray-600 hover:border-gray-400' 
                                       }}">
                                        {{$status->name}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center shadow-sm">
                        <span class="font-bold mr-2">Успешно!</span> {{ session('success') }}
                    </div>
                @endif
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                                    <th class="px-6 py-4">ФИО заявителя</th>
                                    <th class="px-6 py-4 w-1/3">Описание нарушения</th>
                                    <th class="px-6 py-4 whitespace-nowrap">Автомобиль</th>
                                    <th class="px-6 py-4">Статус и Действия</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($reports as $report)
                                    <tr class="hover:bg-slate-50 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900">
                                                {{ $report->user->name ?? 'Неизвестно' }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-0.5">
                                                ID: {{ $report->user->id ?? '-' }}
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-slate-600 line-clamp-2 hover:line-clamp-none transition-all cursor-default" title="{{ $report->description }}">
                                                {{ $report->description }}
                                            </p>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 rounded bg-gray-100 text-slate-700 text-sm font-bold border border-gray-200">
                                                {{ $report->number }}
                                            </span>
                                            <div class="text-xs text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($report->created_at)->format('d.m.Y') }}
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <form action="{{ route('reports.status.update', $report->id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('patch')
                                                <div class="relative w-full min-w-[160px]">
                                                    <select name="status_id" onchange="this.form.submit()" 
                                                        class=" w-full bg-white border border-gray-300 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-pointer hover:border-gray-400 transition-colors
                                                        {{ $report->status_id == 1 ? 'border-l-4 border-l-yellow-400' : '' }}
                                                        {{ $report->status_id == 2 ? 'border-l-4 border-l-green-500' : '' }}
                                                        {{ $report->status_id == 3 ? 'border-l-4 border-l-red-500' : '' }}
                                                        ">
                                                        @foreach($statuses as $status)  
                                                            <option value="{{ $status->id }}" {{ $status->id === $report->status_id ? 'selected' : ''}}>
                                                                {{ $status->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                                        <span class="text-xs">▼</span>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="text-lg font-medium">Заявок не найдено</span>
                                                <p class="text-sm mt-1">Попробуйте изменить параметры фильтрации</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($reports->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $reports->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </x-app-layout>
</body>
</html>