<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntretienRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|string|in:scheduled,completed,canceled',
        ];
    }
}
