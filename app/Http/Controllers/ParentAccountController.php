<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParentAccountController extends Controller
{
    public function index()
    {
        $parents = User::where('role', 'parent')
            ->withCount('children')
            ->orderBy('name')
            ->get();

        return view('admin.parents.index', compact('parents'));
    }

    public function create()
    {
        return view('admin.parents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone',
            'password' => 'required|string|min:4',
        ]);

        User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'parent',
        ]);

        return redirect()->route('admin.parents.index')->with('success', '✅ تم إنشاء حساب ولي الأمر بنجاح');
    }

    public function edit($id)
    {
        $parent = User::where('role', 'parent')->findOrFail($id);

        return view('admin.parents.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $parent = User::where('role', 'parent')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:255', Rule::unique('users', 'phone')->ignore($parent->id)],
            'password' => 'nullable|string|min:4',
        ]);

        $parent->name = $validated['name'];
        $parent->phone = $validated['phone'];

        if (!empty($validated['password'])) {
            $parent->password = Hash::make($validated['password']);
        }

        $parent->save();

        return redirect()->route('admin.parents.index')->with('success', '✅ تم تحديث بيانات ولي الأمر');
    }

    public function destroy($id)
    {
        User::where('role', 'parent')->where('id', $id)->delete();

        return redirect()->route('admin.parents.index')->with('success', '🗑️ تم حذف حساب ولي الأمر');
    }
}
