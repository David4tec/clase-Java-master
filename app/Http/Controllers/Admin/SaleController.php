<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Contact;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('contact.user')->paginate(15);
        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::with('user')->get();
        return view('admin.sales.create', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:prospecto,negociacion,cerrado,perdido',
            'expected_close' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        Sale::create($request->all());
        return redirect()->route('admin.sales.index')->with('success', 'Venta registrada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $contacts = Contact::with('user')->get();
        return view('admin.sales.edit', compact('sale', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:prospecto,negociacion,cerrado,perdido',
            'expected_close' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $sale->update($request->all());
        return redirect()->route('admin.sales.index')->with('success', 'Venta actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('admin.sales.index')->with('success', 'Venta eliminada.');
    }
}
