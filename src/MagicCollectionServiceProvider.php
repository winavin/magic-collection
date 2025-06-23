<?php

namespace Winavin\MagicCollection;

use Illuminate\Support\ServiceProvider;
use Winavin\MagicCollection\Commands\MakeCollectionCommand;

class MagicCollectionServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() : void
    {
        // Publishing is only necessary when using the CLI.
        if( $this->app->runningInConsole() ) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->mergeConfigFrom( __DIR__ . '/../config/magic-collection.php', 'magic-collection' );
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole() : void
    {
        // Publishing the configuration file.
        $this->publishes( [
                              __DIR__ . '/../config/magic-collection.php' => config_path( 'magic-collection.php' ),
                          ], 'magic-collection.config' );

        // Registering package commands.
        $this->commands( [
                             MakeCollectionCommand::class,
                         ] );
    }
}
