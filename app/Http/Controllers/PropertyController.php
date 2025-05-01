<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Document;
use App\Models\User;
use App\Models\Favorites;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexDashboard()
    {
        $properties = Property::with('images_url')->get();
        return view('dashboard', compact('properties'));
    }

    public function indexHome()
    {
        $properties = Property::with('images_url')->get();
        $favorites = auth()->check() ? auth()->user()->favorites->pluck('id')->toArray() : [];

        return view('home', compact('properties', 'favorites'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'status' => 'nullable|string|in:available,sold,rented',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        try {
            $property = new Property();
            $property->title = $request->input('title');
            $property->description = $request->input('description');
            $property->price = $request->input('price');
            $property->location = $request->input('location');
            $property->status = $request->input('status', 'available');
            $property->save();

            if ($request->hasFile('image')) {
                $imageUrl = $request->file('image')->store('properties', 'public');
                $property->images()->create([
                    'image_url' => $imageUrl,
                    'property_id' => $property->id,
                ]);
            }

            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('documents', 'public');
            
                $property->documents()->create([
                    'document_url' => $documentPath,
                    'document_type' => 'sertifikat'
                ]);
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create property: ' . $e->getMessage()]);
        }

        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::findOrFail($id);
        return view('properties.detail', compact('property'));
    }

    public function detailProperty(string $id)
    {
        $property = Property::findOrFail($id);
        $favorites = auth()->check() ? auth()->user()->favorites->pluck('id')->toArray() : [];
        return view('detail_user', compact('property', 'favorites'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property = Property::findOrFail($id);        
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf|max:5120', // max 5MB
        ]);

        $property = Property::findOrFail($id);

        $property->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
        ]);

        if ($request->hasFile('image')) {
            foreach ($property->images_url as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }

            $imagePath = $request->file('image')->store('properties', 'public');
            $property->images_url()->create([
                'image_url' => $imagePath,
            ]);
        }

        if ($request->hasFile('document')) {
            foreach ($property->documents as $doc) {
                Storage::disk('public')->delete($doc->document_url);
                $doc->delete();
            }

            $documentPath = $request->file('document')->store('documents', 'public');
            $property->documents()->create([
                'document_type' => 'sertifikat',
                'document_url' => $documentPath,
            ]);
        }

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::findOrFail($id);

        foreach ($property->images as $image) {
            if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }
            $image->delete(); 
        }

        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }

    public function indexFavorites()
    {
        $user = auth()->user();
        $favorites = $user->favorites()->get(); // ambil property favorit user ini
        return view('favorites', compact('favorites'));
    }

    public function addToFavorites(Request $request, string $id)
    {
        $user = auth()->user();
        $user->favorites()->syncWithoutDetaching([$id]); // tambah tanpa duplikat

        return redirect()->back()->with('success', 'Property favorited successfully.');
    }

    public function removeFromFavorites(string $id)
    {
        $user = auth()->user();
        $user->favorites()->detach($id);

        return redirect()->back()->with('success', 'Property removed from favorites successfully.');
    }

    public function showPropertyDetail(string $id)
    {
        $property = Property::findOrFail($id);
        $isFavorite = auth()->user()->favorites->contains($property->id);
        return view('properties.detail', compact('property', 'isFavorite'));
    }
}