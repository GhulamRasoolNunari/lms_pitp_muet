<?php

namespace App;

trait HasFilterHelpers
{
    /**
     * Return true if a filter key exists and has a non-null/non-empty value.
     */
    protected function presentFilter(array $filters, string $key): bool
    {

        if (! array_key_exists($key, $filters)) {
            return false;
        }

        $val = $filters[$key];

        // Null value
        if (is_null($val)) {
            return false;
        }

        // Empty string
        if (is_string($val) && trim($val) === '') {
            return false;
        }

        // Empty array
        if (is_array($val)) {
            foreach ($val as $subVal) {
                if (! is_null($subVal) && $subVal !== '') {
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}
