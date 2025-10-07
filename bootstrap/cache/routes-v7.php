<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XvmotmDlMVMfUdd1',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gptR9NKUwESJojMW',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LlqMDm7EBQxIsWMz',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/logout-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FZWP8KCd6Z7U2dvW',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xDzjNUflvvjbok2Y',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::spGRx3VaawiaIba9',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/change-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::smxcYHjspDnmKtQ3',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Za5xvxNQexYhAUZw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1LCELXergli8g1N1',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products/featured' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xK5ECYf4ElHRKgwX',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FBTq5bwvrPckGaSg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::48ozKN3yQTcZIr1Z',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/cart/count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::O2UIwcwdaldPDr2y',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/cart/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xzP1dICsOvwqymtY',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/cart/clear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NYF0kINd6qu1jmyR',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/cart/discount' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ae6BAwaF7CSb8An4',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::42uClm5ON5NxOPwD',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OCLPu4AhpyLSz6Q6',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/orders/statistics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dRjxu8ya6UTS5M4O',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MjBh44DCdCaeP60H',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CUe2zDjVHaq5flDM',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ys229BK7dUgM8B6w',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'change-password',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/update-profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'update-profile',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/products/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.add',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/clear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.clear',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.count',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/apply-discount' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.apply-discount',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/remove-discount' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.remove-discount',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'orders.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/orders/checkout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'orders.checkout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wishlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wishlist.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wishlist/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wishlist.add',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wishlist/clear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wishlist.clear',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wishlist/count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wishlist.count',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messages/send' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messages.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messages/unread-count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messages.unread-count',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications/mark-all-read' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.mark-all-read',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications/read/all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.delete-read',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications/api/unread-count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.api.unread-count',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications/api/recent' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.api.recent',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/addresses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'addresses.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'addresses.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/addresses/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'addresses.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/returns' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'returns.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'returns.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/returns/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'returns.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotes/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/users/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/groups' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/groups/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/custom-prices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/custom-prices/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/products/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/products/test' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.test',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categories.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categories.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/attributes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/attributes/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.orders.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/returns' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/messages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.messages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/messages/send' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.messages.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/reports/sales' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.sales',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/reports/inventory' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.inventory',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/reports/customers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.customers',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/quotes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/quotes/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/quotes/export/csv' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/currencies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/currencies/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/exchange-rates' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.exchange-rates.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/exchange-rates/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.exchange-rates.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/exchange-rates/fetch' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.exchange-rates.fetch',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/exchange-rates/api/get-rate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.exchange-rates.get-rate',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/exchange-rates/api/convert' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.exchange-rates.convert',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/integrations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/integrations/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/superadmin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/superadmin/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.analytics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/superadmin/tenants' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/superadmin/tenants/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/superadmin/export/tenants' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.export.tenants',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/superadmin/export/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.export.analytics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/superadmin/export/financial' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.export.financial',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/a(?|pi/v1/(?|products/([^/]++)(*:38)|cart/items/([^/]++)(?|(*:67))|orders/([^/]++)(?|(*:93)|/cancel(*:107)))|d(?|dresses/([^/]++)(?|/(?|edit(*:148)|set\\-default(*:168))|(*:177))|min/(?|users/([^/]++)(?|/(?|edit(*:218)|toggle\\-status(*:240))|(*:249))|groups/([^/]++)(?|(*:276)|/(?|edit(*:292)|toggle\\-status(*:314))|(*:323))|c(?|u(?|stom\\-prices/([^/]++)(?|(*:364)|/(?|edit(*:380)|toggle\\-status(*:402))|(*:411))|rrencies/([^/]++)(?|(*:440)|/(?|edit(*:456)|set\\-default(*:476)|toggle\\-active(*:498))|(*:507)))|ategories/([^/]++)(?|(*:538)|/edit(*:551)|(*:559)))|products/([^/]++)(?|/(?|t(?|est\\-images(*:608)|oggle\\-status(*:629))|edit(*:642)|update\\-stock(*:663)|images/([^/]++)(?|(*:689)|/set\\-cover(*:708)))|(*:718))|attributes/([^/]++)(?|(*:749)|/(?|edit(*:765)|values(?|(*:782)|/([^/]++)(*:799)))|(*:809))|orders/([^/]++)(?|(*:836)|/(?|update\\-status(*:862)|add\\-notes(*:880)))|re(?|turns/(?|([^/]++)(?|(*:915)|/(?|approve(*:934)|reject(*:948)|update\\-status(*:970))|(*:979))|bulk\\-action(*:1000)|export(*:1015))|ports/export/([^/]++)(*:1046))|messages/conversation/([^/]++)(*:1086)|quotes/(?|([^/]++)(?|(*:1116)|/(?|edit(*:1133)|pdf(*:1145)|send(*:1158)|a(?|ccept(*:1176)|pprove(*:1191))|reject(*:1207)|convert(*:1223)|duplicate(*:1241))|(*:1251))|bulk\\-action(*:1273))|integrations/([^/]++)(?|(*:1307)|/(?|edit(*:1324)|t(?|oggle(*:1342)|est(*:1354))|sync(*:1368)|logs(*:1381))|(*:1391)))))|/s(?|torage/(.*)(*:1420)|et\\-locale/([^/]++)(*:1448)|uperadmin/(?|tenants/([^/]++)(?|(*:1489)|/(?|edit(*:1506)|suspend(*:1522)|activate(*:1539)|restore(*:1555))|(*:1565))|export/tenants/([^/]++)(*:1598)))|/products/(?|category/([^/]++)(*:1639)|([^/]++)(*:1656))|/cart/(?|update/([^/]++)(*:1690)|remove/([^/]++)(*:1714))|/orders/([^/]++)(*:1740)|/wishlist/(?|remove/([^/]++)(*:1777)|move\\-to\\-cart/([^/]++)(*:1809))|/messages/mark\\-read/([^/]++)(*:1848)|/notifications/([^/]++)(?|/mark\\-read(*:1894)|(*:1903))|/returns/(?|([^/]++)(?|(*:1936))|order/([^/]++)/items(*:1966))|/quotes/([^/]++)(?|(*:1995)|/(?|pdf(*:2011)|send(*:2024)|accept(*:2039)|reject(*:2054)|convert(*:2070))))/?$}sDu',
    ),
    3 => 
    array (
      38 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::K7jbJfmxp9l4v6nb',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      67 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VUm5L8UxhlQ8mOfC',
          ),
          1 => 
          array (
            0 => 'itemId',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UM2rLnHzZAOhTPz9',
          ),
          1 => 
          array (
            0 => 'itemId',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      93 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bpf3dSelkHKhoaQl',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      107 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lDFUkpCvJ2BeFw8E',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      148 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'addresses.edit',
          ),
          1 => 
          array (
            0 => 'address',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      168 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'addresses.set-default',
          ),
          1 => 
          array (
            0 => 'address',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      177 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'addresses.update',
          ),
          1 => 
          array (
            0 => 'address',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'addresses.destroy',
          ),
          1 => 
          array (
            0 => 'address',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      218 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.edit',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      240 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.toggle-status',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      249 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.update',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users.destroy',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      276 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.show',
          ),
          1 => 
          array (
            0 => 'group',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      292 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.edit',
          ),
          1 => 
          array (
            0 => 'group',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      314 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.toggle-status',
          ),
          1 => 
          array (
            0 => 'group',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      323 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.update',
          ),
          1 => 
          array (
            0 => 'group',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.groups.destroy',
          ),
          1 => 
          array (
            0 => 'group',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      364 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.show',
          ),
          1 => 
          array (
            0 => 'customPrice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      380 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.edit',
          ),
          1 => 
          array (
            0 => 'customPrice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      402 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.toggle-status',
          ),
          1 => 
          array (
            0 => 'customPrice',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      411 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.update',
          ),
          1 => 
          array (
            0 => 'customPrice',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.custom-prices.destroy',
          ),
          1 => 
          array (
            0 => 'customPrice',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      440 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.show',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      456 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.edit',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      476 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.set-default',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      498 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.toggle-active',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      507 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.update',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currencies.destroy',
          ),
          1 => 
          array (
            0 => 'currency',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      538 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categories.show',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      551 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categories.edit',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      559 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categories.update',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categories.destroy',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      608 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.test-images',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      629 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.toggle-status',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      642 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.edit',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      663 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.update-stock',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      689 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.delete-image',
          ),
          1 => 
          array (
            0 => 'product',
            1 => 'image',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      708 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.set-cover',
          ),
          1 => 
          array (
            0 => 'product',
            1 => 'image',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      718 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.update',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.products.destroy',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      749 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.show',
          ),
          1 => 
          array (
            0 => 'attribute',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      765 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.edit',
          ),
          1 => 
          array (
            0 => 'attribute',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.values.add',
          ),
          1 => 
          array (
            0 => 'attribute',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      799 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.values.delete',
          ),
          1 => 
          array (
            0 => 'attribute',
            1 => 'value',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      809 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.update',
          ),
          1 => 
          array (
            0 => 'attribute',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.attributes.destroy',
          ),
          1 => 
          array (
            0 => 'attribute',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      836 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.orders.show',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      862 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.orders.update-status',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      880 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.orders.add-notes',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      915 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.show',
          ),
          1 => 
          array (
            0 => 'return',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      934 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.approve',
          ),
          1 => 
          array (
            0 => 'return',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      948 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.reject',
          ),
          1 => 
          array (
            0 => 'return',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      970 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.update-status',
          ),
          1 => 
          array (
            0 => 'return',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      979 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.destroy',
          ),
          1 => 
          array (
            0 => 'return',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1000 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.bulk-action',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1015 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.returns.export',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1046 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.reports.export',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1086 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.messages.conversation',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1116 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.show',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1133 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.edit',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1145 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.pdf',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1158 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.send',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1176 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.accept',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1191 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.approve',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1207 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.reject',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1223 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.convert',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1241 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.duplicate',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1251 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.update',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.destroy',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1273 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.quotes.bulk-action',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1307 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.show',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1324 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.edit',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1342 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.toggle',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1354 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.test',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1368 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.sync',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1381 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.logs',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1391 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.update',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.integrations.destroy',
          ),
          1 => 
          array (
            0 => 'integration',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1420 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HID9cp4DqSErZTa7',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1448 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'set-locale',
          ),
          1 => 
          array (
            0 => 'locale',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1489 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.show',
          ),
          1 => 
          array (
            0 => 'tenant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1506 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.edit',
          ),
          1 => 
          array (
            0 => 'tenant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1522 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.suspend',
          ),
          1 => 
          array (
            0 => 'tenant',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1539 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.activate',
          ),
          1 => 
          array (
            0 => 'tenant',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1555 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.restore',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1565 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.update',
          ),
          1 => 
          array (
            0 => 'tenant',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.tenants.destroy',
          ),
          1 => 
          array (
            0 => 'tenant',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1598 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'superadmin.export.tenant.details',
          ),
          1 => 
          array (
            0 => 'tenant',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1639 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.category',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1656 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'products.show',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1690 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.update',
          ),
          1 => 
          array (
            0 => 'itemId',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1714 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cart.remove',
          ),
          1 => 
          array (
            0 => 'itemId',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1740 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'orders.show',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1777 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wishlist.remove',
          ),
          1 => 
          array (
            0 => 'itemId',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1809 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wishlist.move-to-cart',
          ),
          1 => 
          array (
            0 => 'itemId',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1848 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messages.mark-read',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1894 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.mark-read',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1903 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1936 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'returns.show',
          ),
          1 => 
          array (
            0 => 'return',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'returns.destroy',
          ),
          1 => 
          array (
            0 => 'return',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1966 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'returns.order.items',
          ),
          1 => 
          array (
            0 => 'order',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1995 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.show',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2011 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.pdf',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2024 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.send',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2039 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.accept',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2054 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.reject',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2070 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes.convert',
          ),
          1 => 
          array (
            0 => 'quote',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XvmotmDlMVMfUdd1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@register',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@register',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::XvmotmDlMVMfUdd1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gptR9NKUwESJojMW' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@login',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::gptR9NKUwESJojMW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LlqMDm7EBQxIsWMz' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::LlqMDm7EBQxIsWMz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FZWP8KCd6Z7U2dvW' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/logout-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@logoutAll',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@logoutAll',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::FZWP8KCd6Z7U2dvW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xDzjNUflvvjbok2Y' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@profile',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@profile',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::xDzjNUflvvjbok2Y',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::spGRx3VaawiaIba9' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@updateProfile',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::spGRx3VaawiaIba9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::smxcYHjspDnmKtQ3' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/change-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@changePassword',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@changePassword',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::smxcYHjspDnmKtQ3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Za5xvxNQexYhAUZw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/products',
        'where' => 
        array (
        ),
        'as' => 'generated::Za5xvxNQexYhAUZw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1LCELXergli8g1N1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@search',
        'namespace' => NULL,
        'prefix' => 'api/v1/products',
        'where' => 
        array (
        ),
        'as' => 'generated::1LCELXergli8g1N1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xK5ECYf4ElHRKgwX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/featured',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@featured',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@featured',
        'namespace' => NULL,
        'prefix' => 'api/v1/products',
        'where' => 
        array (
        ),
        'as' => 'generated::xK5ECYf4ElHRKgwX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FBTq5bwvrPckGaSg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@categories',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@categories',
        'namespace' => NULL,
        'prefix' => 'api/v1/products',
        'where' => 
        array (
        ),
        'as' => 'generated::FBTq5bwvrPckGaSg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::K7jbJfmxp9l4v6nb' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/products',
        'where' => 
        array (
        ),
        'as' => 'generated::K7jbJfmxp9l4v6nb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::48ozKN3yQTcZIr1Z' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/cart',
        'where' => 
        array (
        ),
        'as' => 'generated::48ozKN3yQTcZIr1Z',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::O2UIwcwdaldPDr2y' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/cart/count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@count',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@count',
        'namespace' => NULL,
        'prefix' => 'api/v1/cart',
        'where' => 
        array (
        ),
        'as' => 'generated::O2UIwcwdaldPDr2y',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xzP1dICsOvwqymtY' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/cart/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@add',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@add',
        'namespace' => NULL,
        'prefix' => 'api/v1/cart',
        'where' => 
        array (
        ),
        'as' => 'generated::xzP1dICsOvwqymtY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VUm5L8UxhlQ8mOfC' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/cart/items/{itemId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/cart',
        'where' => 
        array (
        ),
        'as' => 'generated::VUm5L8UxhlQ8mOfC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UM2rLnHzZAOhTPz9' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/cart/items/{itemId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@remove',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@remove',
        'namespace' => NULL,
        'prefix' => 'api/v1/cart',
        'where' => 
        array (
        ),
        'as' => 'generated::UM2rLnHzZAOhTPz9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NYF0kINd6qu1jmyR' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/cart/clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@clear',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@clear',
        'namespace' => NULL,
        'prefix' => 'api/v1/cart',
        'where' => 
        array (
        ),
        'as' => 'generated::NYF0kINd6qu1jmyR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ae6BAwaF7CSb8An4' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/cart/discount',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@applyDiscount',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@applyDiscount',
        'namespace' => NULL,
        'prefix' => 'api/v1/cart',
        'where' => 
        array (
        ),
        'as' => 'generated::ae6BAwaF7CSb8An4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::42uClm5ON5NxOPwD' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\OrderController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\OrderController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/orders',
        'where' => 
        array (
        ),
        'as' => 'generated::42uClm5ON5NxOPwD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OCLPu4AhpyLSz6Q6' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\OrderController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\OrderController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/orders',
        'where' => 
        array (
        ),
        'as' => 'generated::OCLPu4AhpyLSz6Q6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dRjxu8ya6UTS5M4O' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/orders/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\OrderController@statistics',
        'controller' => 'App\\Http\\Controllers\\Api\\OrderController@statistics',
        'namespace' => NULL,
        'prefix' => 'api/v1/orders',
        'where' => 
        array (
        ),
        'as' => 'generated::dRjxu8ya6UTS5M4O',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bpf3dSelkHKhoaQl' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/orders/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\OrderController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\OrderController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/orders',
        'where' => 
        array (
        ),
        'as' => 'generated::bpf3dSelkHKhoaQl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lDFUkpCvJ2BeFw8E' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/orders/{id}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\OrderController@cancel',
        'controller' => 'App\\Http\\Controllers\\Api\\OrderController@cancel',
        'namespace' => NULL,
        'prefix' => 'api/v1/orders',
        'where' => 
        array (
        ),
        'as' => 'generated::lDFUkpCvJ2BeFw8E',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MjBh44DCdCaeP60H' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:77:"function (\\Illuminate\\Http\\Request $request) {
    return $request->user();
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000007660000000000000000";}}',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::MjBh44DCdCaeP60H',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HID9cp4DqSErZTa7' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:312:"function ($path) {
    $file = \\storage_path(\'app/public/\' . $path);

    if (!\\file_exists($file)) {
        \\abort(404);
    }

    $mimeType = \\mime_content_type($file);
    return \\response()->file($file, [
        \'Content-Type\' => $mimeType,
        \'Cache-Control\' => \'public, max-age=31536000\',
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000076f0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::HID9cp4DqSErZTa7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CUe2zDjVHaq5flDM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:47:"function () {
    return \\redirect(\'/login\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000007820000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::CUe2zDjVHaq5flDM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@showLogin',
        'controller' => 'App\\Http\\Controllers\\AuthController@showLogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Ys229BK7dUgM8B6w' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\AuthController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Ys229BK7dUgM8B6w',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@showResetPasswordForm',
        'controller' => 'App\\Http\\Controllers\\AuthController@showResetPasswordForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@sendResetLinkEmail',
        'controller' => 'App\\Http\\Controllers\\AuthController@sendResetLinkEmail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-password' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@changePassword',
        'controller' => 'App\\Http\\Controllers\\AuthController@changePassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'change-password',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'update-profile' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update-profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\AuthController@updateProfile',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'update-profile',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'set-locale' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'set-locale/{locale}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:299:"function ($locale) {
        if (\\in_array($locale, \\config(\'app.supported_locales\'))) {
            \\session([\'locale\' => $locale]);
            if (\\auth()->check()) {
                \\auth()->user()->update([\'preferred_language\' => $locale]);
            }
        }
        return \\back();
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000078d0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'set-locale',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\DashboardController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@profile',
        'controller' => 'App\\Http\\Controllers\\DashboardController@profile',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'profile',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\ProductController@index',
        'as' => 'products.index',
        'namespace' => NULL,
        'prefix' => '/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'products/category/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@category',
        'controller' => 'App\\Http\\Controllers\\ProductController@category',
        'as' => 'products.category',
        'namespace' => NULL,
        'prefix' => '/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'category' => 'slug',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'products/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@search',
        'controller' => 'App\\Http\\Controllers\\ProductController@search',
        'as' => 'products.search',
        'namespace' => NULL,
        'prefix' => '/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\ProductController@show',
        'as' => 'products.show',
        'namespace' => NULL,
        'prefix' => '/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'product' => 'sku',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@index',
        'controller' => 'App\\Http\\Controllers\\CartController@index',
        'as' => 'cart.index',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.add' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@add',
        'controller' => 'App\\Http\\Controllers\\CartController@add',
        'as' => 'cart.add',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'cart/update/{itemId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@update',
        'controller' => 'App\\Http\\Controllers\\CartController@update',
        'as' => 'cart.update',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.remove' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'cart/remove/{itemId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@remove',
        'controller' => 'App\\Http\\Controllers\\CartController@remove',
        'as' => 'cart.remove',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.clear' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@clear',
        'controller' => 'App\\Http\\Controllers\\CartController@clear',
        'as' => 'cart.clear',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.count' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cart/count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@getCount',
        'controller' => 'App\\Http\\Controllers\\CartController@getCount',
        'as' => 'cart.count',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.apply-discount' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/apply-discount',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@applyDiscount',
        'controller' => 'App\\Http\\Controllers\\CartController@applyDiscount',
        'as' => 'cart.apply-discount',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cart.remove-discount' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/remove-discount',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\CartController@removeDiscount',
        'controller' => 'App\\Http\\Controllers\\CartController@removeDiscount',
        'as' => 'cart.remove-discount',
        'namespace' => NULL,
        'prefix' => '/cart',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'orders.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderController@index',
        'controller' => 'App\\Http\\Controllers\\OrderController@index',
        'as' => 'orders.index',
        'namespace' => NULL,
        'prefix' => '/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'orders.checkout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'orders/checkout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderController@checkout',
        'controller' => 'App\\Http\\Controllers\\OrderController@checkout',
        'as' => 'orders.checkout',
        'namespace' => NULL,
        'prefix' => '/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'orders.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'orders/{order}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderController@show',
        'controller' => 'App\\Http\\Controllers\\OrderController@show',
        'as' => 'orders.show',
        'namespace' => NULL,
        'prefix' => '/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'order' => 'order_number',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wishlist.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wishlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\WishlistController@index',
        'controller' => 'App\\Http\\Controllers\\WishlistController@index',
        'as' => 'wishlist.index',
        'namespace' => NULL,
        'prefix' => '/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wishlist.add' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wishlist/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\WishlistController@add',
        'controller' => 'App\\Http\\Controllers\\WishlistController@add',
        'as' => 'wishlist.add',
        'namespace' => NULL,
        'prefix' => '/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wishlist.remove' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'wishlist/remove/{itemId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\WishlistController@remove',
        'controller' => 'App\\Http\\Controllers\\WishlistController@remove',
        'as' => 'wishlist.remove',
        'namespace' => NULL,
        'prefix' => '/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wishlist.move-to-cart' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wishlist/move-to-cart/{itemId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\WishlistController@moveToCart',
        'controller' => 'App\\Http\\Controllers\\WishlistController@moveToCart',
        'as' => 'wishlist.move-to-cart',
        'namespace' => NULL,
        'prefix' => '/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wishlist.clear' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wishlist/clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\WishlistController@clear',
        'controller' => 'App\\Http\\Controllers\\WishlistController@clear',
        'as' => 'wishlist.clear',
        'namespace' => NULL,
        'prefix' => '/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wishlist.count' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wishlist/count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\WishlistController@getCount',
        'controller' => 'App\\Http\\Controllers\\WishlistController@getCount',
        'as' => 'wishlist.count',
        'namespace' => NULL,
        'prefix' => '/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\MessageController@index',
        'controller' => 'App\\Http\\Controllers\\MessageController@index',
        'as' => 'messages.index',
        'namespace' => NULL,
        'prefix' => '/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messages/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\MessageController@send',
        'controller' => 'App\\Http\\Controllers\\MessageController@send',
        'as' => 'messages.send',
        'namespace' => NULL,
        'prefix' => '/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.mark-read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messages/mark-read/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\MessageController@markRead',
        'controller' => 'App\\Http\\Controllers\\MessageController@markRead',
        'as' => 'messages.mark-read',
        'namespace' => NULL,
        'prefix' => '/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.unread-count' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messages/unread-count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\MessageController@unreadCount',
        'controller' => 'App\\Http\\Controllers\\MessageController@unreadCount',
        'as' => 'messages.unread-count',
        'namespace' => NULL,
        'prefix' => '/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@index',
        'controller' => 'App\\Http\\Controllers\\NotificationController@index',
        'as' => 'notifications.index',
        'namespace' => NULL,
        'prefix' => '/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.mark-read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notifications/{id}/mark-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markAsRead',
        'as' => 'notifications.mark-read',
        'namespace' => NULL,
        'prefix' => '/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.mark-all-read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notifications/mark-all-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markAllAsRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markAllAsRead',
        'as' => 'notifications.mark-all-read',
        'namespace' => NULL,
        'prefix' => '/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'notifications/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@destroy',
        'controller' => 'App\\Http\\Controllers\\NotificationController@destroy',
        'as' => 'notifications.destroy',
        'namespace' => NULL,
        'prefix' => '/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.delete-read' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'notifications/read/all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@deleteRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@deleteRead',
        'as' => 'notifications.delete-read',
        'namespace' => NULL,
        'prefix' => '/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.api.unread-count' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notifications/api/unread-count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@unreadCount',
        'controller' => 'App\\Http\\Controllers\\NotificationController@unreadCount',
        'as' => 'notifications.api.unread-count',
        'namespace' => NULL,
        'prefix' => '/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.api.recent' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notifications/api/recent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@recent',
        'controller' => 'App\\Http\\Controllers\\NotificationController@recent',
        'as' => 'notifications.api.recent',
        'namespace' => NULL,
        'prefix' => '/notifications',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'addresses.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'addresses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@index',
        'controller' => 'App\\Http\\Controllers\\AddressController@index',
        'as' => 'addresses.index',
        'namespace' => NULL,
        'prefix' => '/addresses',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'addresses.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'addresses/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@create',
        'controller' => 'App\\Http\\Controllers\\AddressController@create',
        'as' => 'addresses.create',
        'namespace' => NULL,
        'prefix' => '/addresses',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'addresses.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'addresses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@store',
        'controller' => 'App\\Http\\Controllers\\AddressController@store',
        'as' => 'addresses.store',
        'namespace' => NULL,
        'prefix' => '/addresses',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'addresses.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'addresses/{address}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@edit',
        'controller' => 'App\\Http\\Controllers\\AddressController@edit',
        'as' => 'addresses.edit',
        'namespace' => NULL,
        'prefix' => '/addresses',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'addresses.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'addresses/{address}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@update',
        'controller' => 'App\\Http\\Controllers\\AddressController@update',
        'as' => 'addresses.update',
        'namespace' => NULL,
        'prefix' => '/addresses',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'addresses.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'addresses/{address}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@destroy',
        'controller' => 'App\\Http\\Controllers\\AddressController@destroy',
        'as' => 'addresses.destroy',
        'namespace' => NULL,
        'prefix' => '/addresses',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'addresses.set-default' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'addresses/{address}/set-default',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@setDefault',
        'controller' => 'App\\Http\\Controllers\\AddressController@setDefault',
        'as' => 'addresses.set-default',
        'namespace' => NULL,
        'prefix' => '/addresses',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'returns.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'returns',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ReturnController@index',
        'controller' => 'App\\Http\\Controllers\\ReturnController@index',
        'as' => 'returns.index',
        'namespace' => NULL,
        'prefix' => '/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'returns.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'returns/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ReturnController@create',
        'controller' => 'App\\Http\\Controllers\\ReturnController@create',
        'as' => 'returns.create',
        'namespace' => NULL,
        'prefix' => '/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'returns.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'returns',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ReturnController@store',
        'controller' => 'App\\Http\\Controllers\\ReturnController@store',
        'as' => 'returns.store',
        'namespace' => NULL,
        'prefix' => '/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'returns.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'returns/{return}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ReturnController@show',
        'controller' => 'App\\Http\\Controllers\\ReturnController@show',
        'as' => 'returns.show',
        'namespace' => NULL,
        'prefix' => '/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'returns.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'returns/{return}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ReturnController@destroy',
        'controller' => 'App\\Http\\Controllers\\ReturnController@destroy',
        'as' => 'returns.destroy',
        'namespace' => NULL,
        'prefix' => '/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'returns.order.items' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'returns/order/{order}/items',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\ReturnController@getOrderItems',
        'controller' => 'App\\Http\\Controllers\\ReturnController@getOrderItems',
        'as' => 'returns.order.items',
        'namespace' => NULL,
        'prefix' => '/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@index',
        'controller' => 'App\\Http\\Controllers\\QuoteController@index',
        'as' => 'quotes.index',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotes/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@create',
        'controller' => 'App\\Http\\Controllers\\QuoteController@create',
        'as' => 'quotes.create',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@store',
        'controller' => 'App\\Http\\Controllers\\QuoteController@store',
        'as' => 'quotes.store',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotes/{quote}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@show',
        'controller' => 'App\\Http\\Controllers\\QuoteController@show',
        'as' => 'quotes.show',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotes/{quote}/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@downloadPdf',
        'controller' => 'App\\Http\\Controllers\\QuoteController@downloadPdf',
        'as' => 'quotes.pdf',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotes/{quote}/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@send',
        'controller' => 'App\\Http\\Controllers\\QuoteController@send',
        'as' => 'quotes.send',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.accept' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotes/{quote}/accept',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@accept',
        'controller' => 'App\\Http\\Controllers\\QuoteController@accept',
        'as' => 'quotes.accept',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotes/{quote}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@reject',
        'controller' => 'App\\Http\\Controllers\\QuoteController@reject',
        'as' => 'quotes.reject',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes.convert' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotes/{quote}/convert',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:vendeur',
        ),
        'uses' => 'App\\Http\\Controllers\\QuoteController@convertToOrder',
        'controller' => 'App\\Http\\Controllers\\QuoteController@convertToOrder',
        'as' => 'quotes.convert',
        'namespace' => NULL,
        'prefix' => '/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminDashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminDashboardController@index',
        'as' => 'admin.dashboard',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@index',
        'as' => 'admin.users.index',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/users/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@create',
        'as' => 'admin.users.create',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@store',
        'as' => 'admin.users.store',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/users/{user}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@edit',
        'as' => 'admin.users.edit',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@update',
        'as' => 'admin.users.update',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@destroy',
        'as' => 'admin.users.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users.toggle-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/users/{user}/toggle-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@toggleStatus',
        'as' => 'admin.users.toggle-status',
        'namespace' => NULL,
        'prefix' => 'admin/users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@index',
        'as' => 'admin.groups.index',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/groups/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@create',
        'as' => 'admin.groups.create',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@store',
        'as' => 'admin.groups.store',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/groups/{group}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@show',
        'as' => 'admin.groups.show',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/groups/{group}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@edit',
        'as' => 'admin.groups.edit',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/groups/{group}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@update',
        'as' => 'admin.groups.update',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/groups/{group}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@destroy',
        'as' => 'admin.groups.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.groups.toggle-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/groups/{group}/toggle-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomerGroupController@toggleStatus',
        'as' => 'admin.groups.toggle-status',
        'namespace' => NULL,
        'prefix' => 'admin/groups',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/custom-prices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@index',
        'as' => 'admin.custom-prices.index',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/custom-prices/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@create',
        'as' => 'admin.custom-prices.create',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/custom-prices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@store',
        'as' => 'admin.custom-prices.store',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/custom-prices/{customPrice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@show',
        'as' => 'admin.custom-prices.show',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/custom-prices/{customPrice}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@edit',
        'as' => 'admin.custom-prices.edit',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/custom-prices/{customPrice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@update',
        'as' => 'admin.custom-prices.update',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/custom-prices/{customPrice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@destroy',
        'as' => 'admin.custom-prices.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.custom-prices.toggle-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/custom-prices/{customPrice}/toggle-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCustomPriceController@toggleStatus',
        'as' => 'admin.custom-prices.toggle-status',
        'namespace' => NULL,
        'prefix' => 'admin/custom-prices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@index',
        'as' => 'admin.products.index',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@create',
        'as' => 'admin.products.create',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@store',
        'as' => 'admin.products.store',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.test' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products/test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:51:"function() { return \\view(\'admin.products.test\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000007e40000000000000000";}}',
        'as' => 'admin.products.test',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.test-images' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products/{product}/test-images',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:294:"function(\\App\\Models\\Product $product) {
            // Charger explicitement les images sans filtre tenant
            $images = \\App\\Models\\ProductImage::where(\'product_id\', $product->id)->get();
            return \\view(\'admin.products.test-images\', \\compact(\'product\', \'images\'));
        }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000007e60000000000000000";}}',
        'as' => 'admin.products.test-images',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/products/{product}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@edit',
        'as' => 'admin.products.edit',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@update',
        'as' => 'admin.products.update',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@destroy',
        'as' => 'admin.products.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.toggle-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/products/{product}/toggle-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@toggleStatus',
        'as' => 'admin.products.toggle-status',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.update-stock' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/products/{product}/update-stock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@updateStock',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@updateStock',
        'as' => 'admin.products.update-stock',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.delete-image' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/products/{product}/images/{image}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@deleteImage',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@deleteImage',
        'as' => 'admin.products.delete-image',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.products.set-cover' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/products/{product}/images/{image}/set-cover',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminProductController@setCoverImage',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminProductController@setCoverImage',
        'as' => 'admin.products.set-cover',
        'namespace' => NULL,
        'prefix' => 'admin/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.categories.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.categories.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.categories.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categories.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.categories.show',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/categories/{category}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.categories.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categories.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.categories.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/categories/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.categories.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCategoryController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/attributes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.attributes.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/attributes/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.attributes.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/attributes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.attributes.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/attributes/{attribute}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.attributes.show',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/attributes/{attribute}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.attributes.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/attributes/{attribute}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.attributes.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/attributes/{attribute}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'as' => 'admin.attributes.destroy',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.values.add' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/attributes/{attribute}/values',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@addValue',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@addValue',
        'as' => 'admin.attributes.values.add',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.attributes.values.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/attributes/{attribute}/values/{value}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@deleteValue',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAttributeController@deleteValue',
        'as' => 'admin.attributes.values.delete',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.orders.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@index',
        'as' => 'admin.orders.index',
        'namespace' => NULL,
        'prefix' => 'admin/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.orders.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/orders/{order}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@show',
        'as' => 'admin.orders.show',
        'namespace' => NULL,
        'prefix' => 'admin/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'order' => 'order_number',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.orders.update-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/orders/{order}/update-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@updateStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@updateStatus',
        'as' => 'admin.orders.update-status',
        'namespace' => NULL,
        'prefix' => 'admin/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.orders.add-notes' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/orders/{order}/add-notes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@addNotes',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminOrderController@addNotes',
        'as' => 'admin.orders.add-notes',
        'namespace' => NULL,
        'prefix' => 'admin/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/returns',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@index',
        'as' => 'admin.returns.index',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/returns/{return}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@show',
        'as' => 'admin.returns.show',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/returns/{return}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@approve',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@approve',
        'as' => 'admin.returns.approve',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/returns/{return}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@reject',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@reject',
        'as' => 'admin.returns.reject',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.update-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/returns/{return}/update-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@updateStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@updateStatus',
        'as' => 'admin.returns.update-status',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/returns/{return}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@destroy',
        'as' => 'admin.returns.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.bulk-action' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/returns/bulk-action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@bulkAction',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@bulkAction',
        'as' => 'admin.returns.bulk-action',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.returns.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/returns/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@export',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReturnController@export',
        'as' => 'admin.returns.export',
        'namespace' => NULL,
        'prefix' => 'admin/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.messages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\MessageController@adminIndex',
        'controller' => 'App\\Http\\Controllers\\MessageController@adminIndex',
        'as' => 'admin.messages.index',
        'namespace' => NULL,
        'prefix' => 'admin/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.messages.conversation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/messages/conversation/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\MessageController@conversation',
        'controller' => 'App\\Http\\Controllers\\MessageController@conversation',
        'as' => 'admin.messages.conversation',
        'namespace' => NULL,
        'prefix' => 'admin/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.messages.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/messages/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\MessageController@adminSend',
        'controller' => 'App\\Http\\Controllers\\MessageController@adminSend',
        'as' => 'admin.messages.send',
        'namespace' => NULL,
        'prefix' => 'admin/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReportController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReportController@index',
        'as' => 'admin.reports.index',
        'namespace' => NULL,
        'prefix' => 'admin/reports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.sales' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/reports/sales',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReportController@sales',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReportController@sales',
        'as' => 'admin.reports.sales',
        'namespace' => NULL,
        'prefix' => 'admin/reports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.inventory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/reports/inventory',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReportController@inventory',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReportController@inventory',
        'as' => 'admin.reports.inventory',
        'namespace' => NULL,
        'prefix' => 'admin/reports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.customers' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/reports/customers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReportController@customers',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReportController@customers',
        'as' => 'admin.reports.customers',
        'namespace' => NULL,
        'prefix' => 'admin/reports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.reports.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/reports/export/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminReportController@export',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminReportController@export',
        'as' => 'admin.reports.export',
        'namespace' => NULL,
        'prefix' => 'admin/reports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quotes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@index',
        'as' => 'admin.quotes.index',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quotes/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@create',
        'as' => 'admin.quotes.create',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/quotes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@store',
        'as' => 'admin.quotes.store',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quotes/{quote}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@show',
        'as' => 'admin.quotes.show',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quotes/{quote}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@edit',
        'as' => 'admin.quotes.edit',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/quotes/{quote}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@update',
        'as' => 'admin.quotes.update',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/quotes/{quote}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@destroy',
        'as' => 'admin.quotes.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quotes/{quote}/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@downloadPdf',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@downloadPdf',
        'as' => 'admin.quotes.pdf',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/quotes/{quote}/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@send',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@send',
        'as' => 'admin.quotes.send',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.accept' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/quotes/{quote}/accept',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@accept',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@accept',
        'as' => 'admin.quotes.accept',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/quotes/{quote}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@reject',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@reject',
        'as' => 'admin.quotes.reject',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.convert' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/quotes/{quote}/convert',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@convertToOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@convertToOrder',
        'as' => 'admin.quotes.convert',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.duplicate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quotes/{quote}/duplicate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@duplicate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@duplicate',
        'as' => 'admin.quotes.duplicate',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/quotes/{quote}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@approve',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@approve',
        'as' => 'admin.quotes.approve',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/quotes/export/csv',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@export',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@export',
        'as' => 'admin.quotes.export',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.quotes.bulk-action' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/quotes/bulk-action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@bulkAction',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminQuoteController@bulkAction',
        'as' => 'admin.quotes.bulk-action',
        'namespace' => NULL,
        'prefix' => 'admin/quotes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/currencies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@index',
        'as' => 'admin.currencies.index',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/currencies/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@create',
        'as' => 'admin.currencies.create',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/currencies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@store',
        'as' => 'admin.currencies.store',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/currencies/{currency}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@show',
        'as' => 'admin.currencies.show',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/currencies/{currency}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@edit',
        'as' => 'admin.currencies.edit',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/currencies/{currency}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@update',
        'as' => 'admin.currencies.update',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/currencies/{currency}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@destroy',
        'as' => 'admin.currencies.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.set-default' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/currencies/{currency}/set-default',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@setDefault',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@setDefault',
        'as' => 'admin.currencies.set-default',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currencies.toggle-active' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/currencies/{currency}/toggle-active',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@toggleActive',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@toggleActive',
        'as' => 'admin.currencies.toggle-active',
        'namespace' => NULL,
        'prefix' => 'admin/currencies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.exchange-rates.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/exchange-rates',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@rates',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@rates',
        'as' => 'admin.exchange-rates.index',
        'namespace' => NULL,
        'prefix' => 'admin/exchange-rates',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.exchange-rates.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/exchange-rates/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@updateRates',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@updateRates',
        'as' => 'admin.exchange-rates.update',
        'namespace' => NULL,
        'prefix' => 'admin/exchange-rates',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.exchange-rates.fetch' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/exchange-rates/fetch',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@fetchRates',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@fetchRates',
        'as' => 'admin.exchange-rates.fetch',
        'namespace' => NULL,
        'prefix' => 'admin/exchange-rates',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.exchange-rates.get-rate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/exchange-rates/api/get-rate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@getRate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@getRate',
        'as' => 'admin.exchange-rates.get-rate',
        'namespace' => NULL,
        'prefix' => 'admin/exchange-rates',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.exchange-rates.convert' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/exchange-rates/api/convert',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@convert',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminCurrencyController@convert',
        'as' => 'admin.exchange-rates.convert',
        'namespace' => NULL,
        'prefix' => 'admin/exchange-rates',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/integrations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@index',
        'as' => 'admin.integrations.index',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/integrations/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@create',
        'as' => 'admin.integrations.create',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/integrations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@store',
        'as' => 'admin.integrations.store',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/integrations/{integration}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@show',
        'as' => 'admin.integrations.show',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/integrations/{integration}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@edit',
        'as' => 'admin.integrations.edit',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/integrations/{integration}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@update',
        'as' => 'admin.integrations.update',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/integrations/{integration}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@destroy',
        'as' => 'admin.integrations.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/integrations/{integration}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@toggleStatus',
        'as' => 'admin.integrations.toggle',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.test' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/integrations/{integration}/test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@testConnection',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@testConnection',
        'as' => 'admin.integrations.test',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.sync' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/integrations/{integration}/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@sync',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@sync',
        'as' => 'admin.integrations.sync',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.integrations.logs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/integrations/{integration}/logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'check.role:grossiste',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@logs',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminIntegrationController@logs',
        'as' => 'admin.integrations.logs',
        'namespace' => NULL,
        'prefix' => 'admin/integrations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\DashboardController@index',
        'as' => 'superadmin.dashboard',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\DashboardController@analytics',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\DashboardController@analytics',
        'as' => 'superadmin.analytics',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/tenants',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'as' => 'superadmin.tenants.index',
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@index',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@index',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/tenants/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'as' => 'superadmin.tenants.create',
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@create',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@create',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'superadmin/tenants',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'as' => 'superadmin.tenants.store',
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@store',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@store',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/tenants/{tenant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'as' => 'superadmin.tenants.show',
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@show',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@show',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/tenants/{tenant}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'as' => 'superadmin.tenants.edit',
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@edit',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@edit',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'superadmin/tenants/{tenant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'as' => 'superadmin.tenants.update',
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@update',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@update',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'superadmin/tenants/{tenant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'as' => 'superadmin.tenants.destroy',
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@destroy',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@destroy',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.suspend' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'superadmin/tenants/{tenant}/suspend',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@suspend',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@suspend',
        'as' => 'superadmin.tenants.suspend',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.activate' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'superadmin/tenants/{tenant}/activate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@activate',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@activate',
        'as' => 'superadmin.tenants.activate',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.tenants.restore' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'superadmin/tenants/{id}/restore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@restore',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\TenantController@restore',
        'as' => 'superadmin.tenants.restore',
        'namespace' => NULL,
        'prefix' => '/superadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.export.tenants' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/export/tenants',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@tenants',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@tenants',
        'as' => 'superadmin.export.tenants',
        'namespace' => NULL,
        'prefix' => 'superadmin/export',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.export.tenant.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/export/tenants/{tenant}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@tenantDetails',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@tenantDetails',
        'as' => 'superadmin.export.tenant.details',
        'namespace' => NULL,
        'prefix' => 'superadmin/export',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.export.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/export/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@analytics',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@analytics',
        'as' => 'superadmin.export.analytics',
        'namespace' => NULL,
        'prefix' => 'superadmin/export',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'superadmin.export.financial' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'superadmin/export/financial',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'set.locale',
          2 => 'auth',
          3 => 'superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@financialReport',
        'controller' => 'App\\Http\\Controllers\\SuperAdmin\\ExportController@financialReport',
        'as' => 'superadmin.export.financial',
        'namespace' => NULL,
        'prefix' => 'superadmin/export',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
