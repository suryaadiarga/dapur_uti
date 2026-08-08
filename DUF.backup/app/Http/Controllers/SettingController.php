<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        return view('settings.edit', ['setting' => Setting::current()]);
    }

    public function update(SettingRequest $request)
    {
        $setting = Setting::current();
        $oldValues = $setting->only(['business_name', 'business_address', 'whatsapp_number', 'currency']);
        $data = $request->safe()->except('logo');
        if ($request->hasFile('logo')) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('business', 'public');
        }
        $setting->update($data);
        ActivityLogger::log('update', $setting, $oldValues, $setting->fresh()->only(array_keys($oldValues)));

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
