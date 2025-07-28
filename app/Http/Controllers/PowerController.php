<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Power;

class PowerController extends Controller
{
    public function index()
    {
        $powers = Power::all();
        return view('power.index', compact('powers'));
    }

    public function create()
    {
        return view('power.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Power::create($request->only('name'));

        return redirect()->back()->with('success', 'Power added successfully!');
    }

    public function edit(Power $power)
    {
        return view('power.edit', compact('power'));
    }

    public function update(Request $request, Power $power)
    {
        $power->update($request->all());
        return redirect()->route('power.index');
    }

    public function destroy(Power $power)
    {
        $power->delete();
        return redirect()->route('power.index');
    }
}
