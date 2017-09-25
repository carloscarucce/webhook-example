<?php

namespace App\Provider;

use App\Http\Controller;
use Corviz\DI\Provider;
use Corviz\Routing\Route;

class RoutingProvider extends Provider
{
    /**
     * Include application routes here.
     * Example:.
     *
     * //Single route.
     * Route::get('/', [
     *     'controller' => Controller\Home::class,
     *     'action'     => 'index',
     *     'alias'      => 'home.index', //Optional
     *     'middleware' => ['middleware1', 'middleware2'] //Optional
     * ]);
     *
     * //Groups.
     * Route::group('contact', function(){
     *     Route::get('form', [/* ... *\/]);
     *     Route::post('form-submit', [/* ... *\/])
     * });
     */
    public function register()
    {
        Route::get('/', [
            'controller' => Controller\Home::class,
            'action'     => 'index',
            'alias'      => 'home.index',
        ]);

        Route::group('payments', function(){

            Route::get('list', [
                'controller' => Controller\Payments::class,
                'action'     => 'paymentsList',
            ]);

        });

        Route::group('checkout', function(){

            Route::post('accept-payment', [
                'controller' => Controller\Checkout::class,
                'action'     => 'acceptPayment',
            ]);

            Route::get('cart', [
                'controller' => Controller\Checkout::class,
                'action'     => 'cart',
            ]);

            Route::post('send', [
                'controller' => Controller\Checkout::class,
                'action'     => 'send',
            ]);

            Route::get('sent', [
                'controller' => Controller\Checkout::class,
                'action'     => 'sent',
            ]);

        });
    }
}
