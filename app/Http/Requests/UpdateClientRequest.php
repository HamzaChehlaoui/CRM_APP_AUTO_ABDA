<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        $clientId = $this->route('client')->id;
        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'cin' => "required|string|max:50|unique:clients,cin,{$clientId}",
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'branch_id' => 'required|exists:branches,id',
        ];
    }
}
