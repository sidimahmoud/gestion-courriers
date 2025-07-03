<?php

namespace App\Http\Controllers;

use App\Models\file;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the files, ordered by creation date (desc).
     */
    public function index(Request $request): Response
    {
        $query = file::query()->with('category');
        if ($search = $request->input('search')) {
            $query->where('object', 'like', "%{$search}%");
        }
        $files = $query->orderByDesc('created_at')->get();
        return Inertia::render('files/Index', [
            'files' => $files,
            'search' => $search,
        ]);
    }

    /**
     * Store a newly created file in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'object' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048',
        ]);
        $validated['created_by'] = auth()->user()->id;
        $validated['status'] = 'draft';
        $validated['type'] = 'arrival';
        $validated['path'] = $request->file('file')->store('files', 'public');
        $file = file::create($validated);
        return redirect()->route('files.index')->with('success', 'File created successfully!');
    }

    /**
     * Serve the file for download or viewing.
     */
    public function show($id)
    {
        $file = file::findOrFail($id);
        if (!$file->path) {
            abort(404, 'File not found');
        }
        return \Storage::disk('public')->download($file->path, $file->object);
    }
} 