<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        $carId = $this->route('car')->id;
        return [
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'ivn' => "required|string|unique:cars,ivn,{$carId}|max:255",
            'registration_number' => "required|string|unique:cars,registration_number,{$carId}|max:100",
            'chassis_number' => "required|string|unique:cars,chassis_number,{$carId}|max:100",
            'color' => 'nullable|string|max:50',
            'year' => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ];
    }
}
