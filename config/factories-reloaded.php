<?php

declare(strict_types=1);

return [
    /*
     * Defines where your models are located.
     * Will be used to find your models while generating new factories.
     */
    'models_paths' => [
        base_path('src'),
        base_path("src/Association"),
        base_path("src/Association/Boards"),
        base_path("src/Association/Committees"),
        base_path("src/Association/FranckenVrij"),
        base_path("src/Association/Members/Registration"),
        base_path("src/Association/News"),
        base_path("src/Association/Photos"),
        base_path("src/Association/Symposium"),
        base_path("src/Auth"),
        base_path("src/Extern"),
        base_path("src/Extern/SponsorOptions"),
        base_path("src/Lustrum"),
        base_path("src/Study"),
        base_path("src/Study/BooksSale"),
        base_path("src/Treasurer"),
    ],

    /**
     * Defines where your new factories should be stored.
     */
    'factories_path' => base_path('tests/Factories'),

    /**
     * Defines the namespace of your new factories.
     */
    'factories_namespace' => 'Francken\Factories',

    /**
     * Defines where your Laravel factories are located.
     * They are used while generating new factories.
     */
    'vanilla_factories_path' => database_path('factories'),

    /**
     * Defines whether or not models should be unguarded before building
     * instances. This allows using unfillable fields in factories.
     */
    'unguard_models' => false,
];