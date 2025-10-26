<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueAcrossTables implements ValidationRule
{
    protected array $tables;
    protected string $column;

    /**
     * Create a new rule instance.
     *
     * @param  array  $tables
     * @param  string  $column
     */
    public function __construct(array $tables, string $column)
    {
        $this->tables = $tables;
        $this->column = $column;
    }

    /**
     * Run the validation rule.
     *
     * @param  string   $attribute
     * @param  mixed    $value
     * @param  \Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->tables as $table) {
            if (DB::table($table)->where($this->column, $value)->exists()) {
                $fail("The {$attribute} has already been taken.");
                return;
            }
        }
    }
}
