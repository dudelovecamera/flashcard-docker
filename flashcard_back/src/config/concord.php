<?php

return [

    'convention' => Marssilen\Core\CoreConvention::class,

    'modules' => [

        /**
         * Example:
         * VendorA\ModuleX\Providers\ModuleServiceProvider::class,
         * VendorB\ModuleY\Providers\ModuleServiceProvider::class
         *
         */
        \Marssilen\Core\Providers\ModuleServiceProvider::class,
        \Marssilen\Practice\Providers\ModuleServiceProvider::class,
        \Marssilen\Flashcard\Providers\ModuleServiceProvider::class,
        \Marssilen\Statistic\Providers\ModuleServiceProvider::class,

    ],
];
