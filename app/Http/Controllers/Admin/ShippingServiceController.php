<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingServiceController extends Controller
{
    public function index(): View
    {
        $services = ShippingService::orderBy('courier')
            ->orderBy('service')
            ->get();

        return view('admin.shipping.index', compact('services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'courier' => ['required', 'string', 'max:80'],
            'service' => ['required', 'string', 'max:80'],
            'eta' => ['nullable', 'string', 'max:80'],
            'cost' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        ShippingService::create($validated);

        return back()->with('success', 'Layanan ekspedisi ditambahkan.');
    }

    public function update(Request $request, ShippingService $shippingService): RedirectResponse
    {
        $validated = $request->validate([
            'courier' => ['required', 'string', 'max:80'],
            'service' => ['required', 'string', 'max:80'],
            'eta' => ['nullable', 'string', 'max:80'],
            'cost' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $shippingService->update($validated);

        return back()->with('success', 'Layanan ekspedisi diperbarui.');
    }

    public function destroy(ShippingService $shippingService): RedirectResponse
    {
        $shippingService->update(['is_active' => false]);

        return back()->with('success', 'Layanan ekspedisi dinonaktifkan.');
    }
}