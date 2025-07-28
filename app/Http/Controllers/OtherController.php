<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Other;

class OtherController extends Controller
{
    public function index()
    {
        $others = Other::all();
        return view('other.index', compact('others'));
    }

    public function create()
    {
        return view('other.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Other::create($request->only('name'));

        return redirect()->back()->with('success', 'Other added successfully!');
    }



    public function edit(Other $other)
    {
        return view('other.edit', compact('other'));
    }

    public function update(Request $request, Other $other)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $other->update($request->only('name'));

        return redirect()->back()->with('success', 'Other updated successfully!');
    }


    public function destroy(Other $other)
    {
        $other->delete();

        return redirect()->back()->with('success', 'Other deleted successfully!');
    }

}
