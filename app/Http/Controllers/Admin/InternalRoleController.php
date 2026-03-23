<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InternalRoleController extends Controller
{
    public function coordinators(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $coordinators = User::query()
            ->where('role', 'coordinator')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.coordinators.index', compact('coordinators', 'search'));
    }

    public function admins(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $admins = User::query()
            ->where('role', 'admin')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.admins.index', compact('admins', 'search'));
    }
}
