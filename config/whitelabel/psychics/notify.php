<?php

return [
    'sns' => [
        'credentials' => [
            'key' => 'AKIAJISTKYHNTVRHN42Q',
            'secret' => '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',
        ],
        'region' => 'us-west-2',
        'application' => [
            'prod' => [
                'ios_arn' => 'arn:aws:sns:us-west-2:907523630147:app/APNS/Collide-APNS-Prod',
                'android_arn' => 'arn:aws:sns:us-west-2:907523630147:app/GCM/Collide-GCM-Prod',
            ],
            'dev' => [
                'ios_arn' => 'arn:aws:sns:us-west-2:907523630147:app/APNS/Apple-APNS',
                'android_arn' => 'arn:aws:sns:us-west-2:907523630147:app/GCM/Collide-GCM',
            ],
        ],
        'topic' => [
            'prod' => [
                'star' => [
                    'ios-site-wide' => 'arn:aws:sns:us-west-2:907523630147:prod-ios-site-star-sub',
                    'android-site-wide' => 'arn:aws:sns:us-west-2:907523630147:prod-android-site-star-sub',
                ],
                'user' => [
                    'ios-site-wide' => 'arn:aws:sns:us-west-2:907523630147:prod-ios-site-sub',
                    'android-site-wide' => 'arn:aws:sns:us-west-2:907523630147:prod-android-site-sub',
                ],
                'ios' => '',
                'android' => '',
            ],
            'dev' => [
                'star' => [
                    'ios-site-wide' => 'arn:aws:sns:us-west-2:907523630147:dev-ios-site-star-sub',
                    'android-site-wide' => 'arn:aws:sns:us-west-2:907523630147:dev-android-site-star-sub',
                ],
                'user' => [
                    'ios-site-wide' => 'arn:aws:sns:us-west-2:907523630147:dev-ios-site-sub',
                    'android-site-wide' => 'arn:aws:sns:us-west-2:907523630147:dev-android-site-sub',
                ],
                'ios' => '',
                'android' => '',
            ],
        ],
    ],
];
