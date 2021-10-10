<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateOrderRequest
 *
 * @package App\Http\Requests
 */
class CreateOrderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sum' => 'required'
        ];
    }
}
