<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::where('is_available', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' .$request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search .'%');
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $items = $query->paginate(9);

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'category' => 'required|string',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'user_id' => auth()->id(),
            'name' =>$validated['name'],
            'description' => $validated['description'],
            'price_per_day' => $validated['price_per_day'],
            'category' => $validated['category'],
            'location' => $validated['location'],
             'image_url' => $imagePath,
            'is_available' => $request->has('is_available'),
        ]);

        // Success

        return redirect()->route('items.show', $item)
        ->with('success', 'Item listed successfully!');

        // Error
        return redirect()->back()
        ->with('error', 'Something went wrong!');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
