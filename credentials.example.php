<?php

$credentials = [

    'expire' => '14 day',

    'users'  => [

        'admin'   => '$1$iJ0znMgT$mCVFAnnd6Waflwl2kj7a2/',
        'rachel'  => '$1$vWFdhDCq$k5u4EHQQCvJyLCtGbWdIoL',
        'barney'  => '$1$vWFdhDCq$alsjdbflajdlLCtGbWdIoA',
        'tracy'   => '$1$vWFdhDCq$ASDFLKJAalHNDLK53k2no2',

    ],

    'lists'  => [

        'private'     => ['admin'],
        'family'      => ['admin', 'rachel', 'barney', 'tracy'],
        'innercircle' => ['admin', 'barney'],

    ],

];
