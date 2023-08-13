<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    const LARAVEL_QUERY_CACHE = 'laravel_modul3_query_cache';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = Cache::rememberForever(self::LARAVEL_QUERY_CACHE, function() {
            return News::orderBy('created_at', 'DESC')->get();
        });

        return view('news.index', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $validated = $request->validated();
        $fileName = sprintf('%s-%s',
            str_replace(' ', '_', strtolower($validated['title'])),
            $validated['image_url']->getClientOriginalName()
        );
        $saveFile = Storage::putFileAs(
            'public',
            $validated['image_url'],
            $fileName
        );
        $validated['saved_image_url'] = Storage::url($saveFile);
        $validated['user_id'] = Auth::id();

        News::createNews($validated);
        Cache::forget(self::LARAVEL_QUERY_CACHE);

        return redirect()
            ->route('news.index')
            ->with('status_success', 'Successfully added news!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::find($id);
        if (!$news) {
            abort(404);
        }
        return view('news.show', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news = News::find($id);
        if (!$news) {
            abort(404);
        }
        return view('news.edit', [
            'news' => $news
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['id'] = $id;
        News::editNews($validated);
        Cache::forget(self::LARAVEL_QUERY_CACHE);

        return redirect()
            ->route('news.edit', ['news' => $id])
            ->with('status_success', 'Successfully updated news!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imageUrl = News::deleteNews($id);
        $fileName = explode('/', $imageUrl);
        $storedImage = sprintf('public/%s', $fileName['2']);
        Storage::delete($storedImage);
        Cache::forget(self::LARAVEL_QUERY_CACHE);

        return redirect()
            ->route('news.index')
            ->with('status_success', 'Successfully deleted news!');
    }
}
