<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Exibe a página de perfil do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    /**
     * Atualiza os dados do perfil do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validação dos dados do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|regex:/^[+]?[0-9\s-]{8,}$/', // Ex.: +351 123 456 789
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Máximo 2MB
        ]);

        // Verifica se o usuário fez upload de uma nova foto de perfil
        if ($request->hasFile('profile_photo')) {
            // Deleta a foto de perfil anterior, se existir
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Salva a nova foto no diretório 'profile_photos'
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        }

        // Atualiza os dados do usuário
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'profile_photo' => $validated['profile_photo'] ?? $user->profile_photo,
        ]);

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Atualiza a senha do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // Validação da nova senha
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Confirmação da nova senha
        ], [
            'current_password.required' => 'A senha atual é obrigatória.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'new_password.confirmed' => 'A confirmação da nova senha não coincide.',
        ]);

        /** @var User $user */
        $user = $request->user();

        // Verifica se a senha atual está correta
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        // Verifica se a nova senha é diferente da senha atual
        if ($validated['current_password'] === $validated['new_password']) {
            return redirect()->back()->withErrors(['new_password' => 'A nova senha não pode ser igual à senha atual.']);
        }

        // Atualiza a senha
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('profile')->with('success', 'Senha atualizada com sucesso!');
    }
}
