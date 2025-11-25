<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $publishers = Publisher::filter($request, [
            'name' => 'string',
        ])->paginate(20)->withQueryString();

        return view('publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return view('publishers.create')->with(['user' => $request->user()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:publishers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        // Store data in database
        Publisher::create($validated);

        // Redirect back with success message
        return Redirect::route('publishers.index')->with('status', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher): View
    {
        $books = $publisher->books()->orderBy('title')->paginate(20);

        return view('publishers.show', compact('publisher', 'books'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher): View
    {
        return view('publishers.edit', compact('publisher'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher): RedirectResponse
    {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:publishers,email,'.$publisher->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        // Update existing publisher
        $publisher->update($validated);

        // Redirect back with success message
        return Redirect::route('publishers.index')->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher): RedirectResponse
    {
        // Delete the publisher
        $publisher->delete();

        // Redirect back with success message
        return Redirect::route('publishers.index')->with('status', 'deleted');
    }
}
