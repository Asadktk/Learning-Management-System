<?php

namespace Http\Validation;

class CourseValidator
{
    public static function validate(array $data)
    {
        $errors = [];
        $currentDate = date('Y-m-d');

        if (!isset($data['instructor_ids']) || !is_array($data['instructor_ids']) || empty($data['instructor_ids'])) {
            $errors['instructor_ids'] = 'At least one instructor must be selected.';
        }

        if (!isset($data['title']) || empty($data['title']) || !is_string($data['title'])) {
            $errors['title'] = 'Title is required and must be a string.';
        } elseif (!ctype_alpha($data['title'])) {
            $errors['title'] = 'Title must only contain alphabetic characters.';
        }

        if (!isset($data['description']) || empty($data['description'])) {
            $errors['description'] = 'Description is required.';
        } elseif (!is_string($data['description'])) {
            $errors['description'] = 'Description must be a string.';
        }

        if (!isset($data['fee']) || !is_numeric($data['fee']) || $data['fee'] <= 0) {
            $errors['fee'] = 'Fee must be a positive number.';
        }

        if (!isset($data['available_seat']) || !is_numeric($data['available_seat']) || $data['available_seat'] <= 0) {
            $errors['available_seat'] = 'Available seat must be a positive integer.';
        }

        if (!isset($data['start_date']) || !strtotime($data['start_date'])) {
            $errors['start_date'] = 'Start date must be a valid date.';
        } elseif ($data['start_date'] <= $currentDate) {
            $errors['start_date'] = 'Start date must be greater than the current date.';
        }

        if (!isset($data['end_date']) || !strtotime($data['end_date']) || strtotime($data['end_date']) < strtotime($data['start_date'])) {
            $errors['end_date'] = 'End date must be a valid date and after the start date.';
        }

        return $errors;
    }
}
