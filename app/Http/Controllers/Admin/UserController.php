<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');

        $usersQuery = User::query();

        if (in_array($role, ['student', 'company', 'admin'], true)) {
            $usersQuery->where('role', $role);
        }

        $users = $usersQuery->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users', 'role'));
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Você não pode desativar sua própria conta.');
        }

        $user->update(['active' => ! $user->active]);

        $status = $user->active ? 'ativado' : 'desativado';

        return back()->with('success', "Usuário {$status} com sucesso.");
    }
}
