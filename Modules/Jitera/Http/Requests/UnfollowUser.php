<?php

namespace Modules\Jitera\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Jitera\Http\Requests\Traits\HasFollower;

class UnfollowUser extends FormRequest
{
    use HasFollower;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'follower_user_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
