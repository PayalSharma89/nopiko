<?php

namespace Botble\Associations\Http\Controllers;

use Botble\Associations\Models\Association;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RvMedia;

class AssociationsController extends Controller 
{
    public function index() {
        $associations = Association::all();
        return view('plugins.associations::index', compact('associations'));
    }

    public function create() {
        $categories = ProductCategory::pluck('name', 'id');
        $tags = ProductTag::pluck('name', 'id');
        return view('plugins.associations::create', compact('categories', 'tags'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'activity' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'background' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
            'commission' => 'nullable|numeric|min:0|max:100',
            'status' => 'boolean',
            'approval_status' => 'in:pending,approved,rejected',
            'causes' => 'nullable|array',
            'causes.*' => 'string|max:255',
        ]);
    
        // Prepare data from validated request
        $data = $validated;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $result = RvMedia::handleUpload($request->file('image'), 0, 'associations');
            if (!$result['error']) {
                $data['image'] = $result['data']['url'];
            }
        }
    
        // Handle background upload
        if ($request->hasFile('background')) {
            $result = RvMedia::handleUpload($request->file('background'), 0, 'associations');
            if (!$result['error']) {
                $data['background'] = $result['data']['url'];
            }
        }
    
        // Store causes as JSON
        $data['causes'] = json_encode($request->input('causes', []));
    
        Association::create($data);
    
        return redirect()->route('associations.index')->with('success', 'Association added successfully.');
    }
    

    public function edit($id) {
        $association = Association::findOrFail($id);
        $categories = ProductCategory::pluck('name', 'id');
        $tags = ProductTag::pluck('name', 'id');
        $selectedCauses = json_decode($association->causes, true) ?? [];
        return view('plugins.associations::edit', compact('association', 'categories', 'tags','selectedCauses'));
    }

    public function update(Request $request, $id) {
        $association = Association::findOrFail($id);
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'activity' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'commission' => 'nullable|numeric|min:0|max:100',
            'status' => 'boolean',
            'background' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
            'approval_status' => 'in:pending,approved,rejected',
            'causes' => 'nullable|array',
            'causes.*' => 'string|max:255',
        ]);
    
        $data = $validated;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $result = RvMedia::handleUpload($request->file('image'), 0, 'associations');
            if (!$result['error']) {
                $data['image'] = $result['data']['url'];
            }
        }
    
        // Handle background upload
        if ($request->hasFile('background')) {
            $result = RvMedia::handleUpload($request->file('background'), 0, 'associations');
            if (!$result['error']) {
                $data['background'] = $result['data']['url'];
            }
        }
    
        // Store causes as JSON
        $data['causes'] = json_encode($request->input('causes', []));
    
        $association->update($data);
    
        return redirect()->route('associations.index')->with('success', 'Association updated successfully.');
    }
    

    public function destroy($id) {
        Association::findOrFail($id)->delete();
        return redirect()->route('associations.index')->with('success', 'Association deleted successfully.');
    }

    public function approve($id) {
        $association = Association::findOrFail($id);
        $association->update(['approval_status' => 'approved']);

        return redirect()->route('associations.index')->with('success', 'Association approved successfully.');
    }

    public function reject($id) {
        $association = Association::findOrFail($id);
        $association->update(['approval_status' => 'rejected']);

        return back()->with('success', 'Association rejected successfully.');
    }

    public function toggleStatus($id) {
        $association = Association::findOrFail($id);
        $association->status = !$association->status;
        $association->save();

        return redirect()->route('associations.index')->with('success', 'Status updated.');
    }

    public function importJson(Request $request) {
        $request->validate([
            'json_file' => 'required|file|mimes:json',
        ]);

        $jsonData = json_decode(file_get_contents($request->file('json_file')->path()), true);

        if (!is_array($jsonData)) {
            return back()->with('error', 'Invalid JSON format.');
        }

        foreach ($jsonData as $data) {
            Association::create([
                'name' => $data['name'] ?? '',
                'description' => $data['description'] ?? '',
                'type' => $data['type'] ?? '',
                'activity' => $data['activity'] ?? '',
                'location' => $data['location'] ?? '',
                'address' => $data['adresse'] ?? '',
                'email' => $data['email'] ?? '',
                'phone' => $data['phone'] ?? '',
                'website' => $data['website'] ?? '',
                'commission' => $data['commission'] ?? 0.00,
                'status' => isset($data['status']) ? (bool) $data['status'] : 1,
                'approval_status' => 'pending',
                'causes' => isset($data['causes']) ? json_encode($data['causes']) : json_encode([]),
            ]);
        }

        return redirect()->route('associations.index')->with('success', 'Associations imported successfully.');
    }

    public function updateStatus(Request $request) {
        $request->validate([
            'id' => 'required|exists:associations,id',
            'status' => 'required|boolean',
        ]);

        $association = Association::findOrFail($request->id);
        $association->update(['status' => $request->status]);

        return response()->json(['message' => 'Association status updated successfully.']);
    }
}
