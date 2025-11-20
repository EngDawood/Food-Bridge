<?php

namespace App\Helpers;

class FoodTypes
{
    /**
     * Get all food categories with their items.
     *
     * @return array
     */
    public static function getCategories()
    {
        return config('matching.food_type.categories', []);
    }

    /**
     * Get the category for a specific food type.
     *
     * @param string $foodType
     * @return string|null
     */
    public static function getCategoryForType($foodType)
    {
        $categories = self::getCategories();
        
        foreach ($categories as $category => $types) {
            if (in_array($foodType, $types)) {
                return $category;
            }
        }
        
        return null;
    }

    /**
     * Check if two food types belong to the same category.
     *
     * @param string $type1
     * @param string $type2
     * @return bool
     */
    public static function areSameCategory($type1, $type2)
    {
        $cat1 = self::getCategoryForType($type1);
        $cat2 = self::getCategoryForType($type2);
        
        return $cat1 && $cat2 && $cat1 === $cat2;
    }

    /**
     * Get all food types as a flat array.
     *
     * @return array
     */
    public static function getAllTypes()
    {
        $types = [];
        foreach (self::getCategories() as $categoryTypes) {
            $types = array_merge($types, $categoryTypes);
        }
        return array_unique($types);
    }

    /**
     * Get a displayable name for a food type.
     *
     * @param string $type
     * @return string
     */
    public static function display($type)
    {
        return ucwords(str_replace('_', ' ', $type));
    }

    /**
     * Get all food types as an associative array of value => label.
     *
     * @return array
     */
    public static function all()
    {
        $types = self::getAllTypes();
        $list = [];
        foreach ($types as $type) {
            $list[$type] = self::display($type);
        }
        return $list;
    }
}
