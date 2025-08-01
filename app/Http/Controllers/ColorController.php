<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('color.index', compact('colors'));
    }

    public function create()
    {
        return view('color.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:colors,code',
        ]);

        Color::create($request->only('name', 'code'));

        return redirect()->back()->with('success', 'Color added successfully!');
    }

    public function edit(Color $color)
    {
        return view('color.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $color->update($request->all());
        return redirect()->route('color.index');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('color.index');
    }
}
