<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        return view('dashboard', compact('properties'));
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
        ]);

        try {
            // Simpan data properti
            $property = new Property();
            $property->title = $request->input('title');
            $property->description = $request->input('description');
            $property->price = $request->input('price');
            $property->location = $request->input('location');
            $property->status = $request->input('status', 'available'); 
            $property->save();

            // Simpan gambar jika ada
            if ($request->hasFile('image')) {
                $imageUrl = $request->file('image')->store('properties', 'public');
                $property->image_path = str_replace('public/','',$imageUrl); // Simpan path gambar ke properti

                // Simpan informasi gambar ke tabel property_image
                $property->images()->create([
                    'image_url' => $imageUrl,
                    'property_id' => $property->id, // Asumsi ada relasi property_id di tabel property_image
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
        return view('properties.show', compact('property'));
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
        ]);

        $property = Property::findOrFail($id);
        $property->title = $request->input('title');
        $property->description = $request->input('description');
        $property->price = $request->input('price');
        $property->location = $request->input('location');
        $property->save(); // Simpan data properti terlebih dahulu

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            $oldImages = $property->images; // Ambil semua gambar lama
            foreach ($oldImages as $image) {
                if (!is_null($image->image_path)) { // Periksa apakah image_path tidak null
                    Storage::disk('public')->delete($image->image_path); // Hapus gambar dari storage
                    $image->delete(); // Hapus entri gambar dari tabel property_images
                }
            }
        
            // Simpan gambar baru ke tabel property_images
            $imagePath = $request->file('image')->store('properties', 'public');
            $property->images()->create([
                'image_url' => $imagePath,
                'property_id' => $property->id, // Asumsi ada relasi property_id di tabel property_images
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
        if ($property->image_path) {
            Storage::disk('public')->delete($property->image_path);
        }
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }
}