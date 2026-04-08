<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    // Show the homepage with all links
    public function index()
    {
        $links = Link::latest()->get();
        return view('links.index', compact('links'));
    }

    // Handle form submission and create a short link
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        do {
            $shortCode = Str::random(6);
        } while (Link::where('short_code', $shortCode)->exists());

        $link = Link::create([
            'original_url' => $request->original_url,
            'short_code'   => $shortCode,
        ]);

        return redirect()->route('links.index')
            ->with('success', 'Short link created successfully!');
    }

    // Redirect to original URL and increment click count
    public function redirect($short_code)
    {
        $link = Link::where('short_code', $short_code)->firstOrFail();
        $link->increment('clicks');
        return redirect()->away($link->original_url);
    }

    // Delete a link
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('links.index')
            ->with('success', 'Link deleted.');
    }
}
