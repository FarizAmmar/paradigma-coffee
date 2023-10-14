<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Events\CartEvents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $menus = Menu::latest()->paginate(10);
        // Menus page
        return view('employee.pages.menu.menu', [
            'title' => 'Menu',
            'categories' => $categories,
            'menus' => $menus,
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
            session()->flash('ShowNewEntriesMenu', true);
        }

        $request->validate([
            'new-name' => 'required|string|max:30|unique:menus,name',
            'new-image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'new-category' => 'required|string|exists:categories,code',
            'new-amount' => 'required|numeric',
            'new-desc' => 'nullable|string|max:500',
        ], [
            'new-name.required' => 'The name field is required.',
            'new-name.string' => 'The name must be a string.',
            'new-name.max' => 'The name may not be greater than :max characters.',
            'new-name.unique' => 'The name has already been taken.',
            'new-image.required' => 'The image field is required.',
            'new-image.image' => 'The image must be an image file (jpeg, png, jpg, gif).',
            'new-image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'new-image.max' => 'The image may not be greater than :max kilobytes.',
            'new-category.required' => 'The category field is required.',
            'new-category.string' => 'The category must be a string.',
            'new-category.exists' => 'The selected category is invalid.',
            'new-amount.required' => 'The amount field is required.',
            'new-amount.numeric' => 'The amount must be a number.',
            'new-desc.string' => 'The description must be a string.',
            'new-desc.max' => 'The description may not be greater than :max characters.',
        ]);

        $image = $request->file('new-image');
        $imageName = time() . '.' . $image->extension();
        $image->storeAs('public/uploads', $imageName);

        $menu = new Menu();

        $menu->name = $request->input('new-name');
        $menu->image_path = $imageName;
        $menu->category_code = $request->input('new-category');
        $menu->amount = $request->input('new-amount');
        $menu->description = $request->input('new-desc');

        $menu->save();

        if ($menu->save()) {
            session()->forget('ShowNewEntriesMenu');
        }

        return back()->with('success', 'The record has been successfully save.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->has('btn-edit')) {
            session()->flash('ShowEditEntriesMenu', true);
            session()->put('editData', ['id' => $id]);
        }

        $request->validate([
            'edit-name' => 'required|string|max:30',
            'edit-image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'edit-category' => 'required|string|exists:categories,code',
            'edit-amount' => 'required|numeric',
            'edit-desc' => 'nullable|string|max:500',
        ], [
            'edit-name.required' => 'The name field is required.',
            'edit-name.string' => 'The name must be a string.',
            'edit-name.max' => 'The name may not be greater than :max characters.',
            'edit-image.image' => 'The image must be an image file (jpeg, png, jpg, gif).',
            'edit-image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'edit-image.max' => 'The image may not be greater than :max kilobytes.',
            'edit-category.required' => 'The category field is required.',
            'edit-category.string' => 'The category must be a string.',
            'edit-category.exists' => 'The selected category is invalid.',
            'edit-amount.required' => 'The amount field is required.',
            'edit-amount.numeric' => 'The amount must be a number.',
            'edit-desc.string' => 'The description must be a string.',
            'edit-desc.max' => 'The description may not be greater than :max characters.',
        ]);

        $menu = Menu::find($id);

        if (!$menu) {
            return back()->with('error', 'Menu not found!');
        }

        if ($request->hasFile('edit-image')) {
            if ($menu->image_path) {
                $fileToDelete = storage_path('app/public/uploads/' . $menu->image_path);
                if (file_exists($fileToDelete)) {
                    unlink($fileToDelete);
                }
            }
            $image = $request->file('edit-image');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/uploads', $imageName);
            $menu->image_path = $imageName;
        }

        $menu->name = $request->input('edit-name');
        $menu->category_code = $request->input('edit-category');
        $menu->amount = $request->input('edit-amount');
        $menu->description = $request->input('edit-desc');

        $menu->save();

        if ($menu->save()) {
            session()->forget('ShowEditEntriesMenu');
        }

        return back()->with('success', 'The record has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return back()->with('error', 'Menu not found!');
        }

        if ($menu->image_path) {
            $fileToDelete = storage_path('app/public/uploads/' . $menu->image_path);
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }

        $menu->delete();

        return back()->with('success', 'Menu has been successfully deleted.');
    }
}
