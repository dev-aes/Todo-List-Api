<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
            'todo' => 'required|min:5|max:50',
            'due' => 'required|date',
            'is_done' => 'required|sometimes|boolean'
        ];
    }

    public function bodyParameters()
    {
        return [
            'todo' => [
                'description' => 'Task to do.',
                'example' => 'Take a walk outside'
            ],
            'due' => [
                'description' => 'The due date of the currently added task',
                'example' => '01-01-2021',
            ],
            'is_done' => [
                'description' => 'The status of a specific task',
            ],
        ];
    }
}
