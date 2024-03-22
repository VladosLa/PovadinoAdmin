<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // метод для отображения списка новостей в админ-панели
    public function adminIndex(Request $request)
    {
        $dateFilter = $request->input('date');

        $news = News::when($dateFilter, function ($query, $dateFilter) {
            return $query->whereDate('date', $dateFilter);
        })->get();

        return view('admin.dashboard', ['news' => $news]);
    }

    public function getAllNews()
    {
        $news = News::all();
        return response()->json($news);
    }

    // метод для отображения формы создания новости в админ-панели
    public function create()
    {
        return view('admin.news.create');
    }

    // метод для сохранения новости в админ-панели
    public function store(Request $request)
    {
        // валидацию данных, если нужно

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $imagePath = 'news_images/news-stub.svg';

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $imagePath = str_replace('public/', '', $imagePath);
        }

        try {
            News::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'date' => $request->input('date'),
            'image_path' => $imagePath,
        ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Не удалось сохранить новость: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Новость успешно добавлена');
    }

    // метод для отображения формы редактирования новости в админ-панели
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', ['news' => $news]);
    }

    // метод для обновления новости в админ-панели
    public function update(Request $request, $id)
    {
        // валидацию данных, если нужно

        $news = News::findOrFail($id);
        $news->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'date' => $request->input('date'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Новость успешно обновлена');
    }

    // метод для удаления новости в админ-панели
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Новость успешно удалена');
    }
}
