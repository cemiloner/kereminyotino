<?php

// Admin routes
$router->get('/admin/orders', 'AdminController@orders');
$router->post('/admin/orders/update-status', 'OrderController@updateStatus');

// Customer routes
$router->post('/order', 'OrderController@store');

// ... existing routes ... 