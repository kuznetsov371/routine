<?php
$patterns = [
    'names' => [
        'regex' => '/^([A-Z]{1}[a-z]{1,20})$/',
    ],
    'phone' => [
        'regex' => '/^\+380\d{9}$|^380\d{9}$|^80\d{9}$|^0\d{9}$|^\d{9}$/',
        'callback' => function($matches){
            printme($matches);
            return '+380'. substr($matches[0],-9);
        }
    ],
    'email' => [
        'regex' => '/\w+@\w+\.\w+/',
    ],
    'IBAN' => [
        'regex' => '/\d{16}/',
    ],

];