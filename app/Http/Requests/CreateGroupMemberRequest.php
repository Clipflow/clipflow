<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateGroupMemberRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // The email must not belong to a user that is already a member of the group
            'email' => [
                'required',
                'email',
                Rule::unique('group_members')->where(function ($query) {
                    return $query->where('group_id', $this->group_id);
                }),
                'exists:users,email',
            ],
            'role' => ['required', 'in:admin,member'],
        ];
    }
}
