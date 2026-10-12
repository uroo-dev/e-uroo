<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile and addresses.
     */
    public function show()
    {
        $user = Auth::user()->load('addresses');

        return view('Public.profile.index', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        unset($data['current_password']);

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Store a new shipping address.
     */
    public function storeAddress(Request $request)
    {
        $data = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'full_address' => 'required|string',
            'is_default' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        // If this is the user's first address or marked default, set is_default
        $hasAddress = $user->addresses()->exists();
        $isDefault = ! $hasAddress || ! empty($data['is_default']);

        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        $data['user_id'] = $user->id;
        $data['is_default'] = $isDefault;

        Address::create($data);

        return redirect()->back()->with('success', 'Alamat pengiriman berhasil ditambahkan');
    }

    /**
     * Update an existing shipping address.
     */
    public function updateAddress(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'full_address' => 'required|string',
            'is_default' => 'nullable|boolean',
        ]);

        if (! empty($data['is_default'])) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            $data['is_default'] = true;
        }

        $address->update($data);

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui');
    }

    /**
     * Delete an address.
     */
    public function destroyAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted address was default, promote another address to default
        if ($wasDefault) {
            $fallback = Auth::user()->addresses()->first();
            if ($fallback) {
                $fallback->update(['is_default' => true]);
            }
        }

        return redirect()->back()->with('success', 'Alamat berhasil dihapus');
    }
}
