<?php

namespace App\Helpers;

class FoodTypes
{
    /**
     * Get the list of available food types
     */
    public static function all(): array
    {
        return [
            'cooked' => 'Cooked Meal',
            'fresh' => 'Fresh Food',
            'vegetables' => 'Vegetables',
            'fruits' => 'Fruits',
            'canned' => 'Canned Food',
            'bread' => 'Bread',
            'dairy' => 'Dairy Products',
            'meat' => 'Meat',
            'grains' => 'Grains',
            'other' => 'Other',
        ];
    }

    /**
     * Get food type values only (for validation)
     */
    public static function values(): array
    {
        return array_keys(self::all());
    }

    /**
     * Check if a food type is valid
     */
    public static function isValid(string $type): bool
    {
        return in_array($type, self::values(), true);
    }

    /**
     * Get display name for a food type
     */
    public static function display(string $type): string
    {
        return self::all()[$type] ?? $type;
    }
}

