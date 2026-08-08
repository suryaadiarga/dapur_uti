<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Models\Person;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $base = Inventory::with('person')
            ->visibleTo($request->user())
            ->filter($request->only('category', 'condition', 'person_id', 'search'));
        $totalValue = (float) (clone $base)->selectRaw('COALESCE(SUM(purchase_price * quantity), 0) as total')->value('total');
        $inventories = $base->latest('purchase_date')->latest('id')->paginate(15)->withQueryString();

        return view('inventories.index', compact('inventories', 'totalValue') + ['people' => $this->people($request)]);
    }

    public function create()
    {
        return view('inventories.form', ['inventory' => new Inventory, 'people' => $this->people(request())]);
    }

    public function store(InventoryRequest $request)
    {
        $data = $request->safe()->except('photo');
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('inventory-photos', 'public');
        }
        $data['user_id'] = $request->user()->id;
        $inventory = Inventory::create($data);
        ActivityLogger::log('create', $inventory, null, $inventory->only([
            'name', 'category', 'purchase_date', 'purchase_price', 'quantity', 'condition',
            'location', 'people_id', 'description', 'user_id',
        ]));

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function show(Inventory $inventory)
    {
        abort_unless($inventory->isVisibleTo(request()->user()), 403);
        $inventory->load('person');

        return view('inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        abort_unless($inventory->isVisibleTo(request()->user()), 403);

        return view('inventories.form', compact('inventory') + ['people' => $this->people(request())]);
    }

    public function update(InventoryRequest $request, Inventory $inventory)
    {
        abort_unless($inventory->isVisibleTo($request->user()), 403);
        $oldValues = $inventory->only([
            'name', 'category', 'purchase_date', 'purchase_price', 'quantity', 'condition',
            'location', 'people_id', 'description', 'user_id',
        ]);
        $data = $request->safe()->except('photo');
        if ($request->hasFile('photo')) {
            if ($inventory->photo_path) {
                Storage::disk('public')->delete($inventory->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('inventory-photos', 'public');
        }
        $inventory->update($data);
        ActivityLogger::log('update', $inventory, $oldValues, $inventory->fresh()->only(array_keys($oldValues)));

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        abort_unless($inventory->isVisibleTo(request()->user()), 403);
        $oldValues = $inventory->only([
            'name', 'category', 'purchase_date', 'purchase_price', 'quantity', 'condition',
            'location', 'people_id', 'description', 'user_id',
        ]);
        $inventory->delete();
        ActivityLogger::log('delete', $inventory, $oldValues);

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil dihapus.');
    }

    private function people(Request $request)
    {
        return Person::query()->visibleTo($request->user())->orderBy('name')->get();
    }
}
