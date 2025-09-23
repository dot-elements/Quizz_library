<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class JsonToArrayTransformer implements DataTransformerInterface
{
    public function transform($value): string
    {
        // $value is array|null in entity: return JSON string for form
        return $value ? json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '';
    }

    public function reverseTransform($value): ?array
    {
        // $value is string from form: convert to array for entity
        if (!$value) {
            return null;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new TransformationFailedException('Invalid JSON: ' . json_last_error_msg());
        }

        return $decoded;
    }
}
