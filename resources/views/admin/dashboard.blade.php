<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="{{ mix('/js/app.js') }}"></script>
</head>
<body>
    <div class="logout__wrapper">
        <h2>Админ-панель</h2>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Выйти</button>
        </form>
    </div>
    
    @extends('layouts.admin')

        @section('content')
            <div class="admin-dashboard">
                <!-- Форма для добавления новости -->
                <div class="add-news-form">
                    <h3>Добавить новость</h3>
                    <form class="add__news" method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Заголовок:</label>
                            <input type="text" name="title" required>
                        </div>
                        <div>
                            <label for="content">Содержание:</label>
                            <textarea name="content" required></textarea>
                        </div>
                        <div>
                            <label for="date">Дата:</label>
                            <input type="date" name="date" required>                            
                        </div>
                        <div>
                            <label for="image">Изображение:</label>
                            <input type="file" name="image">
                        </div>
                        <button type="submit">Добавить новость</button>
                    </form>
                </div>

                <!-- Форма для фильтрации новостей по дате -->
                <form class="filtr" method="GET" action="{{ route('admin.dashboard') }}">
                    @csrf
                    <label for="dateFilter">Фильтр по дате:</label>
                    <input type="date" name="date" id="dateFilter">
                    <button type="submit">Применить фильтр</button>
                </form>


                <!-- Секция для отображения списка новостей -->
                <div class="news-list">
                    <h3>Список новостей</h3>
                    @foreach($news as $item)
                        <div class="news-item">
                            <h4>{{ $item->title }}</h4>
                            <p>{{ $item->content }}</p>
                            <p>Дата: {{ $item->date }}</p>

                            @if ($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="News Image">
                            @endif

                            <form method="POST" action="{{ route('admin.news.destroy', ['id' => $item->id, 'date' => $item->date]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Удалить новость</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
    @endsection    
</body>
</html>
