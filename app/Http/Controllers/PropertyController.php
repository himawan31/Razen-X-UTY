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
        $properties = Property::with('images_url')->get();
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
            'document' => 'nullable|file|mimes:pdf|max:5120', // maksimal 5MB
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
                $property->images()->create([
                    'image_url' => $imageUrl,
                    'property_id' => $property->id,
                ]);
            }

            // Simpan dokumen PDF jika ada
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
            'document' => 'nullable|file|mimes:pdf|max:5120', // max 5MB
        ]);

        $property = Property::findOrFail($id);

        $property->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
        ]);

        // Update gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            foreach ($property->images_url as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('properties', 'public');
            $property->images_url()->create([
                'image_url' => $imagePath,
            ]);
        }

        // Update dokumen jika ada
        if ($request->hasFile('document')) {
            // Hapus dokumen lama
            foreach ($property->documents as $doc) {
                Storage::disk('public')->delete($doc->document_url);
                $doc->delete();
            }

            // Simpan dokumen baru
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
}