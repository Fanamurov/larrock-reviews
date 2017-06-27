<?php

namespace Larrock\ComponentReviews\Requests;

use Larrock\Core\Requests\Request;

class ReviewRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'city' => 'max:255',
            'rating' => 'required',
            'comment' => 'required',
        ];
    }
}
