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

    /**
     * Get the category for a given food type
     */
    public static function getCategory(string $foodType): ?string
    {
        $categories = config('matching.food_type.categories', []);

        foreach ($categories as $category => $types) {
            if (in_array($foodType, $types, true)) {
                return $category;
            }
        }

        return null;
    }

    /**
     * Check if two food types are in the same category
     */
    public static function areSameCategory(string $type1, string $type2): bool
    {
        $category1 = self::getCategory($type1);
        $category2 = self::getCategory($type2);

        return $category1 !== null && $category1 === $category2;
    }

    /**
     * Get all food types in the same category
     */
    public static function getTypesInCategory(string $foodType): array
    {
        $category = self::getCategory($foodType);

        if ($category === null) {
            return [$foodType];
        }

        return config("matching.food_type.categories.{$category}", [$foodType]);
    }
}

