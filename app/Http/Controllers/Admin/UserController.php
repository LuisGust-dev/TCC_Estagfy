<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('admin.dashboard');
    }

    public function create(Request $request)
    {
        $redirectTo = $this->sanitizeRedirect($request->query('redirect_to'));
        $selectedRole = $request->query('role');

        if (!in_array($selectedRole, ['student', 'company', 'admin', 'coordinator'], true)) {
            $selectedRole = 'student';
        }

        return view('admin.users.create', compact('redirectTo', 'selectedRole'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'cpf' => preg_replace('/\D/', '', (string) $request->input('cpf')),
            'cnpj' => preg_replace('/\D/', '', (string) $request->input('cnpj')),
            'phone' => preg_replace('/\D/', '', (string) $request->input('phone')),
        ]);

        $validated = $request->validate($this->rulesForRequest($request));

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'active' => ($validated['active'] ?? '1') === '1',
            'password' => Hash::make($validated['password']),
        ]);

        $this->syncRelatedProfile($user, $validated);

        return $this->redirectToAdminPage()
            ->with('success', 'Usuário criado com sucesso.');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return $this->redirectToAdminPage()
                ->with('error', 'Você não pode desativar sua própria conta.');
        }

        $user->update(['active' => ! $user->active]);

        $status = $user->active ? 'ativado' : 'desativado';

        return $this->redirectToAdminPage()
            ->with('success', "Usuário {$status} com sucesso.");
    }

    public function edit(User $user, Request $request)
    {
        $user->load(['student', 'company']);
        $redirectTo = $this->sanitizeRedirect($request->query('redirect_to'));

        return view('admin.users.edit', compact('user', 'redirectTo'));
    }

    public function update(User $user, Request $request)
    {
        $request->merge([
            'cpf' => preg_replace('/\D/', '', (string) $request->input('cpf')),
            'cnpj' => preg_replace('/\D/', '', (string) $request->input('cnpj')),
            'phone' => preg_replace('/\D/', '', (string) $request->input('phone')),
        ]);

        $validated = $request->validate($this->rulesForRequest($request, $user));

        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->withInput()->with('error', 'Você não pode remover seu próprio perfil de admin.');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'active' => $validated['active'] === '1',
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $this->syncRelatedProfile($user, $validated);

        return $this->redirectToAdminPage()
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return $this->redirectToAdminPage()
                ->with('error', 'Você não pode excluir sua própria conta.');
        }

        $user->delete();

        return $this->redirectToAdminPage()
            ->with('success', 'Usuário excluído com sucesso.');
    }

    private function redirectToAdminPage()
    {
        $redirectTo = $this->sanitizeRedirect(request()->input('redirect_to'));

        if ($redirectTo) {
            return redirect()->to($redirectTo);
        }

        return redirect()->route('admin.dashboard');
    }

    private function sanitizeRedirect(?string $redirectTo): ?string
    {
        if (!is_string($redirectTo) || trim($redirectTo) === '') {
            return null;
        }

        return str_starts_with($redirectTo, url('/admin')) ? $redirectTo : null;
    }

    private function rulesForRequest(Request $request, ?User $user = null): array
    {
        $baseRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', Rule::in(['student', 'company', 'admin', 'coordinator'])],
            'active' => ['required', Rule::in(['1', '0'])],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ];

        $selectedRole = $request->input('role', $user?->role);

        if ($selectedRole === 'student') {
            return array_merge($baseRules, [
                'cpf' => ['required', 'digits:11', Rule::unique('students', 'cpf')->ignore(optional($user?->student)->id)],
                'course' => ['required', Rule::in(config('internship.courses', []))],
                'period' => ['required', 'string', 'max:50'],
            ]);
        }

        if ($selectedRole === 'company') {
            return array_merge($baseRules, [
                'cnpj' => ['required', 'digits:14', Rule::unique('companies', 'cnpj')->ignore(optional($user?->company)->id)],
                'phone' => ['required', 'digits_between:10,11'],
                'description' => ['required', 'string', 'max:1000'],
            ]);
        }

        return $baseRules;
    }

    private function syncRelatedProfile(User $user, array $validated): void
    {
        if ($validated['role'] === 'student') {
            $user->student()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'cpf' => $validated['cpf'],
                    'course' => $validated['course'],
                    'period' => $validated['period'],
                ]
            );
        }

        if ($validated['role'] === 'company') {
            $user->company()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'cnpj' => $validated['cnpj'],
                    'phone' => $validated['phone'],
                    'description' => $validated['description'],
                ]
            );
        }
    }
}
