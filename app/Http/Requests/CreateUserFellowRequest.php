<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserFellowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fellow_id' => 'required|interger|exists:fellows,id',
            'user_id' => 'required|interger|exists:users,id',
            'power' => 'required|integer'
        ];
    }
}
// return [
//     'fellow_id' => 'required|interger|exists:fellows,id',
//     'user_id' => [
//         'required', 
//         'integer', 
//         Rule::exists('fellows')->where(function ($query) {
//             $query->where('user_id', Auth::id());
//         }),
//     ],
//     'power' => 'required|integer'
// ];