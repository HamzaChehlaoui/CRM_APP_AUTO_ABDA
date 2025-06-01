<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuiviRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'note' => 'required|string',
            'date_suivi' => 'required|date',
        ];
    }
}
