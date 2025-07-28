<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('size.index', compact('sizes'));
    }

    public function create()
    {
        return view('size.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Size::create($request->only('name'));

        return redirect()->back()->with('success', 'Size added successfully!');
    }

    public function edit(Size $size)
    {
        return view('size.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $size->update($request->all());
        return redirect()->route('size.index');
    }

    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('size.index');
    }
}
