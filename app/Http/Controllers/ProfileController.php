<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',  // Validação do número de telefone
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Verifica se o utilizador fez upload de uma nova foto de perfil
        if ($request->hasFile('profile_photo')) {
            // Elimina a foto de perfil anterior, caso exista
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // Guarda a nova foto no diretório 'profile_photos'
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        // Atualiza os dados do utilizador
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');  // Atualiza o número de telefone
        // Não é necessário atribuir profile_photo novamente, pois já é tratado acima

        // Salva o usuário com as alterações
        $user->save();

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function updatePassword(Request $request)
    {
        // Validar a nova senha
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',  // Confirmar a senha
        ]);
    
        // Verificar se a senha atual está correta
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }
    
        // Verificar se a nova senha é diferente da senha atual
        if ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'A nova senha não pode ser igual à senha atual.']);
        }
    
        // Atualizar a senha
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return redirect()->route('profile')->with('success', 'Senha atualizada com sucesso.');
    }
}
