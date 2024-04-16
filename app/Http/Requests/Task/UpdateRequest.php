<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatusEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'due_date' => ['sometimes', 'date_format:Y-m-d'],
            'status' => ['sometimes', 'string', Rule::in(TaskStatusEnum::values())],
            'assigned_user_id' => ['sometimes', 'nullable', 'integer', Rule::exists('users', 'id')],
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->route()->parameter('id');
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->get('name');
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->get('description');
    }

    /**
     * @return Carbon|null
     */
    public function getDueDate(): ?Carbon
    {
        return $this->isDueDatePresent()
            ? Carbon::createFromFormat('Y-m-d', $this->get('due_date'))
            : null;
    }

    /**
     * @return TaskStatusEnum|null
     */
    public function getStatus(): ?TaskStatusEnum
    {
        return $this->isStatusPresent() ? TaskStatusEnum::from($this->get('status')) : null;
    }

    /**
     * @return int|null
     */
    public function getAssignedUserId(): ?int
    {
        return $this->get('assigned_user_id');
    }

    /**
     * @return bool
     */
    public function isNamePresent(): bool
    {
        return $this->has('name');
    }

    /**
     * @return bool
     */
    public function isDescriptionPresent(): bool
    {
        return $this->has('description');
    }

    /**
     * @return bool
     */
    public function isDueDatePresent(): bool
    {
        return $this->has('due_date');
    }

    /**
     * @return bool
     */
    public function isStatusPresent(): bool
    {
        return $this->has('status');
    }

    /**
     * @return bool
     */
    public function isAssignedUserIdPresent(): bool
    {
        return $this->has('assigned_user_id');
    }
}
