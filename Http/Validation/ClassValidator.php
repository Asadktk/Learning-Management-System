<?php

namespace Http\Validation;

class ClassValidator
{
    public static function validate(array $data)
    {
        $errors = [];

        if (!isset($data['start_time']) || empty($data['start_time'])) {
            $errors['start_time'] = 'Start time is required.';
        } else {
            $startTime = $data['start_time'];
            if (!strtotime($startTime)) {
                $errors['start_time'] = 'Start time must be a valid date-time.';
            }
        }

        if (!isset($data['end_time']) || empty($data['end_time'])) {
            $errors['end_time'] = 'End time is required.';
        } else {
            $endTime = $data['end_time'];
            if (!strtotime($endTime)) {
                $errors['end_time'] = 'End time must be a valid date-time.';
            }
        }

        if (isset($startTime) && isset($endTime) && strtotime($startTime) >= strtotime($endTime)) {
            $errors['time_range'] = 'Start time must be less than end time.';
        }

        if (!isset($data['user_id']) || empty($data['user_id'])) {
            $errors['user_id'] = 'User ID is required.';
        } elseif (!filter_var($data['user_id'], FILTER_VALIDATE_INT)) {
            $errors['user_id'] = 'User ID must be a valid integer.';
        }

        if (!isset($data['course_id']) || empty($data['course_id'])) {
            $errors['course_id'] = 'Course ID is required.';
        } elseif (!filter_var($data['course_id'], FILTER_VALIDATE_INT)) {
            $errors['course_id'] = 'Course ID must be a valid integer.';
        }

        return $errors;
    }
}
