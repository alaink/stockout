<?php

return [
    
    'adminEmail' => 'admin@example.com',
    'NEW_TICKET' => 0,
    'VIEWED_TICKET' => 1,
    'PENDING_TICKET' => 2,
    'IN_PROGRESS_TICKET' => 3,
    'RESOLVED_TICKET' => 4,
    'CLOSED_TICKET' => 5,

    // profile types of users
    'RETAILER' => 1,
    'SUBDEALER' => 2,
    'FMCG' => 3,
    
    // action names for history table
    /**
     * create, view, progress, resolve
     */

    // type of issues
    'STOCK_ISSUE' => 1,
    'PRODUCT_ISSUE' => 2,
    'OTHER_ISSUE' => 3,

    //types of sub issues
    'Running Out' => 1,
    'Out of Stock' => 2,
    'Need New Product' => 3,
    'Product Expired' => 4,
    'Product Damaged' => 5,

    //confirmed used
    'pending' => 0,
    'confirmed' => 1,
    'rejected' => 3,
    'retailer' => 2,    // dont need confirmation

    
];
