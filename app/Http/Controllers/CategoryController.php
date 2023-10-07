<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Category Page
        $categories = Category::latest()->paginate(10);

        return view('employee.pages.menu.category', [
            'title' => 'Category',
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('btn-new')) {
            session()->flash('ShowNewEntriesCat', true);
        }

        $messages = [
            'new-code.required' => 'Code is required.',
            'new-code.unique' => 'Code has already been taken.',
            'new-code.min' => 'Code must be at least :min characters long.',
            'new-code.max' => 'Code must not exceed :max characters in length.',
            'new-desc.required' => 'Description is required.',
            'new-desc.max' => 'Description must not exceed :max characters in length.',
        ];

        $validation = $request->validate([
            'new-code' => 'required|unique:categories,code|min:3|max:3',
            'new-desc' => 'required|max:30'
        ], $messages);

        $category = new Category();
        $category->code = strtoupper($validation['new-code']);
        $category->description = $validation['new-desc'];

        $category->save();

        if ($category->save()) {
            session()->forget('ShowNewEntriesCat');
        }

        return back()->with('success', 'The record has been successfully saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $code)
    {
        if ($request->has('btn-edit')) {
            session()->flash('ShowEditEntriesCat', true);
            session()->put('editData', ['code' => $code]);
        }

        $messages = [
            'edit-desc.required' => 'Description is required.',
            'edit-desc.max' => 'Description must not exceed :max characters in length.',
        ];

        $validation = $request->validate([
            'edit-desc' => 'required|max:30'
        ], $messages);

        $category = Category::where('code', $code)->first();
        $category->description = $validation['edit-desc'];

        $category->save();

        if ($category->save()) {
            session()->forget('ShowEditEntriesCat');
        }

        return back()->with('success', 'The record has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $data = Category::where('code', $code)->first();

        if (!$data) {
            return back()->with('error', 'Category not found!');
        }

        $data->delete();

        return back()->with('success', 'Category has been successfully deleted.');
    }
}
