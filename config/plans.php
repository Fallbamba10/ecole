<?php

return [

    'free' => [
        'name' => 'Gratuit',
        'price' => 0,
        'currency' => 'FCFA',
        'billing_period' => 'mois',
        'description' => 'Pour découvrir la plateforme',
        'limits' => [
            'students' => 30,
            'classrooms' => 1,
            'sms_per_month' => 0,
        ],
        'features' => [
            'Jusqu\'à 30 élèves',
            '1 classe maximum',
            'Pas de SMS',
            'Modules de base',
        ],
    ],

    'starter' => [
        'name' => 'Starter',
        'price' => 10000,
        'currency' => 'FCFA',
        'billing_period' => 'mois',
        'description' => 'Pour les petites écoles',
        'popular' => false,
        'limits' => [
            'students' => 100,
            'classrooms' => 5,
            'sms_per_month' => 50,
        ],
        'features' => [
            'Jusqu\'à 100 élèves',
            '5 classes maximum',
            '50 SMS / mois',
            'Tous les modules',
            'Export des données',
        ],
    ],

    'pro' => [
        'name' => 'Pro',
        'price' => 25000,
        'currency' => 'FCFA',
        'billing_period' => 'mois',
        'description' => 'Pour les écoles en croissance',
        'popular' => true,
        'limits' => [
            'students' => 500,
            'classrooms' => null, // illimité
            'sms_per_month' => 200,
        ],
        'features' => [
            'Jusqu\'à 500 élèves',
            'Classes illimitées',
            '200 SMS / mois',
            'Tous les modules',
            'Export des données',
            'Support prioritaire',
        ],
    ],

    'enterprise' => [
        'name' => 'Enterprise',
        'price' => 50000,
        'currency' => 'FCFA',
        'billing_period' => 'mois',
        'description' => 'Pour les grands établissements',
        'limits' => [
            'students' => null, // illimité
            'classrooms' => null, // illimité
            'sms_per_month' => null, // illimité
        ],
        'features' => [
            'Élèves illimités',
            'Classes illimitées',
            'SMS illimités',
            'Tous les modules',
            'Export des données',
            'Support dédié',
            'Multi-sites',
        ],
    ],

];
