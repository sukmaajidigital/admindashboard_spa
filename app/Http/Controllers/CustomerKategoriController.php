<?php

namespace App\Http\Controllers;

use App\Models\customerkategori;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerKategoriController extends Controller
{
    public function ajax()
    {
        $customerkategoris = customerkategori::all();
        return response()->json($customerkategoris);
    }
    public function index(): View
    {
        $customerkategoris = customerkategori::orderByDesc('created_at')->paginate(10);
        return view('page_customer.kategori.index', compact('customerkategoris'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        return view('page_customer.kategori.form');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            customerkategori::create($request->all());
            return redirect()->route('kategori.index')->with('success', 'kategori created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors('Failed to create kategori.');
        }
    }

    public function edit(customerkategori $customerkategori): View
    {
        return view('page_customer.kategori.edit', compact('customerkategori'));
    }
    public function update(Request $request, customerkategori $customerkategori): RedirectResponse
    {
        try {
            $customerkategori->update($request->all());
            return redirect()->route('kategori.index')->with('success', 'kategori update successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors('Failed to update kategori.');
        }
    }
    public function destroy(customerkategori $customerkategori)
    {
        $customerkategori->delete();
        return to_route('kategori.index')->with('success', 'kategori Deleted successfully.');
    }
}
