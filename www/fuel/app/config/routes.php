<?php

return array(
    '_root_'                                 => 'home',
    '_404_'                                  => 'base/404',
    'home'                                   => 'home',
    'trang-chu'                              => 'home',
    'bo-doi-con-shop'                        => 'home/about',
    'cach-thuc-dat-hang'                     => 'home/order',
    'cach-thuc-thanh-toan'                   => 'home/payment',
    'cach-thuc-doi-tra'                      => 'home/change',
    'lien-he'                                => 'home/contact',
    'admin'                                  => 'admin/product',
    'tim-kiem'                               => 'category/search',
    'tim-nang-cao'                           => 'category/sidesearch',
    '(tim-nang-cao)(\.html)'                 => 'category/sidesearch',
    '(tim-nang-cao)(\.html)(/)([0-9]+)'      => 'category/sidesearch',
    '(tim-kiem)(\.html)'                     => 'category/search',
    '(tim-kiem)(\.html)(/)([0-9]+)'          => 'category/search',
    '([a-z-]+)'                              => 'category/view',
    '(admin)(/)(product)(/)(trang-)([0-9]+)' => 'admin/product',
    '(admin)(/)(product)(/)(page-)([0-9]+)'  => 'admin/product',
    '([a-z-]+)(/)(trang-)([0-9]+)'           => 'category/view',
    '([a-z-]+)(\.html)(/)([0-9]+)'           => 'category/view',
    '([a-z-]+)(\.html)(/)(trang-)([0-9]+)'   => 'category/view',
    '([a-z-]+)(/)(page-)([0-9]+)'            => 'category/view',
    '([a-z-]+)(\.html)(/)(page-)([0-9]+)'    => 'category/view',
    '([a-z0-9-]+)(-)([0-9]+)'                => 'product/view',
);
