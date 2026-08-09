<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $base = Inventory::with('person')->filter($request->only('category', 'condition', 'person_id', 'search'));
        $totalValue = (float) (clone $base)->selectRaw('COALESCE(SUM(purchase_price * quantity), 0) as total')->value('total');
        $inventories = $base->latest('purchase_date')->latest('id')->paginate(15)->withQueryString();

        return view('inventories.index', compact('inventories', 'totalValue') + ['people' => Person::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('inventories.form', ['inventory' => new Inventory, 'people' => Person::orderBy('name')->get()]);
    }

    public function store(InventoryRequest $request)
    {
        $data = $request->validated();
        unset($data['photo']);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            
            $destinationPath = storage_path('app/public/inventory-photos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['photo_path'] = 'inventory-photos/' . $filename;
        }

        Inventory::create($data);

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function update(InventoryRequest $request, Inventory $inventory)
    {
        $data = $request->validated();
        unset($data['photo']);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            
            // Hapus foto lama jika ada
            if ($inventory->photo_path && file_exists(storage_path('app/public/' . $inventory->photo_path))) {
                @unlink(storage_path('app/public/' . $inventory->photo_path));
            }

            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $destinationPath = storage_path('app/public/inventory-photos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['photo_path'] = 'inventory-photos/' . $filename;
        }

        $inventory->update($data);

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function show(Inventory $inventory)
    {
        $inventory->load('person');

        return view('inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('inventories.form', compact('inventory') + ['people' => Person::orderBy('name')->get()]);
    }


    public function destroy(Inventory $inventory)
    {
        if ($inventory->photo_path) {
            Storage::disk('public')->delete($inventory->photo_path);
        }
        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil dihapus.');
    }
}
