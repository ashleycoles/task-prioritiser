<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $title
 * @property string $description
 * @property float $estimate
 * @property string $deadline
 * @property int $priority
 */
class TaskCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'deadline' => 'required|date_format:Y-m-d',
            'priority' => 'required|integer|min:1|max:5',
            'estimate' => 'required|numeric|min:0|max:8',
        ];
    }
}
