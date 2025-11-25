<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $books = Book::filter($request, [
            'publisher_id' => 'exact',
            'title' => 'string'
        ])->orderBy('title', 'asc')->paginate(20);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'publisher_id' => 'required|exists:publishers,id',
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle file upload (if provided)
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books/cover', 'public');
            $validated['cover_image'] = $path;
        }

        // Create book record
        $book = Book::create($validated);

        // Redirect or return success response
        return Redirect::route('books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'publisher_id' => 'required|exists:publishers,id',
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            // Upload new file
            $path = $request->file('cover_image')->store('books/cover', 'public');
            $validated['cover_image'] = $path;
        }

        // Update the book record
        $book->update($validated);

        // Redirect back with success message
        return Redirect::route('books.index')->with('success', 'Book updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        // Delete cover image if exists
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // Delete the book
        $book->delete();

        // Redirect with success
        return Redirect::route('books.index')->with('success', 'Book deleted successfully!');
    }


    /**
     * AJAX Search route for books.
     */
    public function search(Request $request): JsonResponse
    {
        $q = $request->get('q', '');
        $books = Book::query()
            ->when($q, fn ($query): Builder => $query
                ->where('title', 'LIKE', "%{$q}%")
                ->orWhere('author', 'LIKE', "%{$q}%"))
            ->select('id', 'title', 'author', 'selling_price', 'cover_image')
            ->limit(20)
            ->get();

        return response()->json($books);
    }
}
