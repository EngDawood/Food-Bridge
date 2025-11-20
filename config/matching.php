<?php

// Configuration for FoodBridge matching system
// Enables flexible matching without database changes

return [

    // Matching Algorithm Settings
    'algorithm' => [
        // Minimum match score to consider (0-100)
        'minimum_score' => env('MATCHING_MIN_SCORE', 60),

        // Maximum results to return
        'max_results' => env('MATCHING_MAX_RESULTS', 20),
    ],

    // Location Matching Rules
    'location' => [
        // Enable flexible location matching
        'flexible_matching' => true,

        // Location similarity keywords (for parsing existing location field)
        'districts' => [
            'north' => ['north', 'شمال', 'northern', 'n.'],
            'south' => ['south', 'جنوب', 'southern', 's.'],
            'east' => ['east', 'شرق', 'eastern', 'e.'],
            'west' => ['west', 'غرب', 'western', 'w.'],
            'central' => ['center', 'central', 'وسط', 'downtown'],
        ],

        // Score weights for location matching
        'exact_match_score' => 100,
        'same_district_score' => 80,
        'partial_match_score' => 60,
        'different_location_score' => 0,
    ],

    // Food Type Matching Rules
    'food_type' => [
        // Enable category-based matching
        'category_matching' => true,

        // Food categories (using existing food types)
        'categories' => [
            'prepared_meals' => [
                'cooked',
            ],
            'fresh_produce' => [
                'fresh',
                'fruits',
                'vegetables',
            ],
            'bakery' => [
                'bread',
            ],
            'dairy' => [
                'dairy',
            ],
            'proteins' => [
                'meat',
            ],
            'pantry' => [
                'canned',
                'grains',
            ],
        ],

        // Score weights for food matching
        'exact_match_score' => 100,
        'same_category_score' => 70,
        'different_category_score' => 0,
    ],

    // Quantity Matching Rules
    'quantity' => [
        // Minimum percentage of requested quantity that must be available
        'minimum_percentage' => 80,
    ],

    // Stale Match Settings
    'stale_matches' => [
        // Hours before releasing a match
        'release_after_hours' => env('STALE_MATCH_HOURS', 3),
    ],

    // Scoring Weights (must total 100)
    'score_weights' => [
        'location' => 40,
        'food_type' => 35,
        'quantity' => 25,
    ],
];