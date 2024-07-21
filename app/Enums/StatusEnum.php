<?php

namespace App\Enums;

/**
 * Enum representing the possible statuses for a Task.
 * 
 * ensuring that only valid statuses are used throughout the application.
 */
enum StatusEnum: string
{
    /**
     * The task is pending and has not been completed yet.
     */
    case PENDING = 'pending';

    /**
     * The task has been completed.
     */
    case DONE = 'done';
}
