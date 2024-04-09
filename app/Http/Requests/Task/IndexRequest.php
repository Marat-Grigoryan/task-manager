<?php

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'integer|min:1',
        ];
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->get('per_page', 10);
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->get('page', 1);
    }

}
