<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    use EnumValues;

    case New = 'new';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
