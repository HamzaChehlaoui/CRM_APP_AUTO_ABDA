<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReclamationRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:open,closed,pending',
        ];
    }
}
