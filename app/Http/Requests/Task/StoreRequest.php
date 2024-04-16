<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
              'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'due_date' => ['required', 'date_format:Y-m-d'],
                'status' => ['required', 'string', Rule::in(TaskStatusEnum::values())],
                'assigned_user_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->get('description');
    }

    /**
     * @return Carbon
     */
    public function getDueDate(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', $this->get('due_date'));
    }

    /**
     * @return TaskStatusEnum
     */
    public function getStatus(): TaskStatusEnum
    {
        return TaskStatusEnum::from($this->get('status'));
    }

    /**
     * @return int|null
     */
    public function getAssignedUserId(): ?int
    {
        return $this->get('assigned_user_id');
    }
}