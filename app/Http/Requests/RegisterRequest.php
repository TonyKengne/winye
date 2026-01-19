<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Autoriser la requête
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:compte_utilisateurs,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:etudiant,enseignant'],
            'matricule' => [
                'nullable',
                'required_if:role,enseignant',
                'string',
                'max:50'
            ],
        ];
    }

    /**
     * Messages personnalisés (optionnel mais pro)
     */
    public function messages(): array
    {
        return [
            'role.required' => 'Veuillez choisir un rôle.',
            'role.in' => 'Le rôle sélectionné est invalide.',
            'matricule.required_if' => 'Le code enseignant est obligatoire.',
        ];
    }
}
