<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            \Illuminate\Auth\Listeners\SendEmailVerificationNotification::class,
        ],
        \App\Events\NovaSerie::class => [
            //\App\Listeners\EnviarEmailNovaSerieCadastrada::class,
            \App\Listeners\LogNovaSerieCadastrada::class,
        ]/*,
        \App\Events\SerieApagada::class => [
            \App\Listeners\ExcluirCapaSerie::class,
        ]*/
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
