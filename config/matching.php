<?php

// config/matching.php
// Configuration for FoodBridge matching system - NO DATABASE CHANGES NEEDED

return [
    
    // Matching Algorithm Settings
    'algorithm' => [
        // Strategy to use: 'strict', 'flexible', 'proximity'
        'strategy' => env('MATCHING_STRATEGY', 'flexible'),
        
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
        'adjacent_district_score' => 60,
        'different_district_score' => 0,
    ],
    
    // Food Type Matching Rules
    'food_type' => [
        // Enable category-based matching
        'category_matching' => true,
        
        // Food categories (using existing food types)
        'categories' => [
            'prepared_meals' => [
                'home_cooked_meal',
                'ready_to_eat',
                'sandwiches',
            ],
            'fresh_produce' => [
                'fruits',
                'vegetables',
                'fresh_produce',
            ],
            'bakery' => [
                'bread',
                'baked_goods',
                'pastries',
            ],
            'dairy' => [
                'dairy_products',
                'milk',
                'cheese',
            ],
            'proteins' => [
                'meat',
                'poultry',
                'seafood',
            ],
            'pantry' => [
                'canned_goods',
                'dry_goods',
                'grains',
                'packaged_food',
            ],
            'beverages' => [
                'beverages',
                'water',
                'juice',
            ],
        ],
        
        // Score weights for food matching
        'exact_match_score' => 100,
        'same_category_score' => 75,
        'different_category_score' => 0,
    ],
    
    // Quantity Matching Rules
    'quantity' => [
        // Allow partial matches
        'allow_partial' => true,
        
        // Minimum percentage of requested quantity that must be available
        'minimum_percentage' => 80,
        
        // Score calculation for quantity
        'exact_match_score' => 100,
        'over_supply_score' => 95, // When donation > request
        'partial_match_base_score' => 50, // Base score for partial matches
    ],
    
    // Expiration Priority Rules
    'expiration' => [
        // Hours before expiration to boost priority
        'urgent_hours' => 24,
        'urgent_score_boost' => 20,
        
        // Hours before expiration to send alerts
        'alert_hours' => 48,
    ],
    
    // Stale Match Settings
    'stale_matches' => [
        // Hours before releasing a match
        'release_after_hours' => env('STALE_MATCH_HOURS', 3),
        
        // Check frequency in minutes
        'check_frequency' => 30,
        
        // Send warning notification before release
        'warning_before_release' => 30, // minutes
    ],
    
    // Scoring Weights (must total 100)
    'score_weights' => [
        'location' => 30,
        'food_type' => 30,
        'quantity' => 25,
        'expiration' => 15,
    ],
    
    // Notification Settings
    'notifications' => [
        // Enable various notification types
        'near_expiration' => true,
        'new_matches' => true,
        'stale_match_warning' => true,
        'match_released' => true,
        'delivery_updates' => true,
    ],
    
    // Performance Settings
    'performance' => [
        // Cache match results
        'cache_matches' => true,
        'cache_ttl' => 300, // seconds
        
        // Use queue for matching
        'use_queue' => env('MATCHING_USE_QUEUE', true),
        'queue_name' => 'matching',
        
        // Batch processing
        'batch_size' => 10,
    ],
    
    // Debug and Logging
    'debug' => [
        'enabled' => env('MATCHING_DEBUG', false),
        'log_channel' => 'matching',
        'log_scores' => true,
        'log_failures' => true,
    ],
];
