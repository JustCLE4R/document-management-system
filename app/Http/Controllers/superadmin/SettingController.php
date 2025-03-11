<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\superadmin\UpdateSettingRequest;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('superadmin.settings.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Clear and refresh cache
        Cache::forget('app_settings');
        Cache::rememberForever('app_settings', function () {
            return (object) Setting::pluck('value', 'key')->toArray();
        });

        return back()->with('success', 'Settings updated successfully!');
    }
}
