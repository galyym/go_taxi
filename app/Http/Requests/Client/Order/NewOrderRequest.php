<?php

namespace App\Http\Requests\Client\Order;

use Illuminate\Foundation\Http\FormRequest;

class NewOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "from_address" => "string|max:255",
            "to_address" => "string|max:255",
            "price" => "required|min:1",
            "departure_time" => "date|nullable",
            "passenger_count" => "nullable",
            "salon" => "nullable|boolean",
            "round_trip" => "nullable|boolean",
            "luggage" => "nullable|boolean",
            "comment" => "nullable",
            "from_city_id" => "required|exists:cities, city_id",
            "to_city_id" => "required|exists:cities, id"
        ];
    }
}
