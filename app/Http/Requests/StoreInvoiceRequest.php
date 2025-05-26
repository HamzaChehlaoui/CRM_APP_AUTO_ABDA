<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'invoice_number' => 'required|string|unique:invoices,invoice_number|max:255',
            'sale_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'ivn' => 'required|string|max:255',

            'accord_reference' => 'nullable|string|max:255',
            'purchase_order_number' => 'nullable|string|max:255',
            'delivery_note_number' => 'nullable|string|max:255',
            'payment_order_reference' => 'nullable|string|max:255',

            'client_id' => 'required|exists:clients,id',
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'nullable|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
        ];
    }
}
