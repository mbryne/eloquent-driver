<?php

namespace Statamic\Eloquent;

use Statamic\Contracts\Entries\CollectionRepository as CollectionRepositoryContract;
use Statamic\Contracts\Entries\EntryRepository as EntryRepositoryContract;
use Statamic\Contracts\Globals\GlobalRepository as GlobalRepositoryContract;
use Statamic\Contracts\Structures\CollectionTreeRepository as CollectionTreeRepositoryContract;
use Statamic\Contracts\Structures\NavigationRepository as NavigationRepositoryContract;
use Statamic\Contracts\Structures\NavTreeRepository as NavTreeRepositoryContract;
use Statamic\Contracts\Taxonomies\TaxonomyRepository as TaxonomyRepositoryContract;
use Statamic\Contracts\Taxonomies\TermRepository as TermRepositoryContract;
use Statamic\Eloquent\Collections\CollectionRepository;
use Statamic\Eloquent\Commands\ImportCollections;
use Statamic\Eloquent\Commands\ImportEntries;
use Statamic\Eloquent\Entries\EntryQueryBuilder;
use Statamic\Eloquent\Entries\EntryRepository;
use Statamic\Eloquent\Globals\GlobalRepository;
use Statamic\Eloquent\Structures\CollectionTreeRepository;
use Statamic\Eloquent\Structures\NavigationRepository;
use Statamic\Eloquent\Structures\NavTreeRepository;
use Statamic\Eloquent\Taxonomies\TaxonomyRepository;
use Statamic\Eloquent\Taxonomies\TermQueryBuilder;
use Statamic\Eloquent\Taxonomies\TermRepository;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $config = false;

    public function boot()
    {
        parent::boot();

        $this->loadConfig();
        $this->loadCommands();
        $this->loadMigrations();
    }

    public function register()
    {
        $this->registerEntries();
        $this->registerCollections();
        $this->registerTaxonomies();
        $this->registerGlobals();
        $this->registerStructures();
    }


    protected function loadConfig(): void
    {
        $this->mergeConfigFrom($config = __DIR__ . '/../config/eloquent-driver.php', 'statamic-eloquent-driver');

        if ($this->app->runningInConsole()) {
            $this->publishes([$config => config_path('statamic-eloquent-driver.php')]);
        }
    }

    private function loadMigrations()
    {
        if (config('statamic-eloquent-driver.migrations')) {
            $this->loadMigrationsFrom([__DIR__ . '/../database/migrations']);
        }
    }

    protected function loadCommands(): void
    {
        $this->commands([
            ImportEntries::class,
            ImportCollections::class
        ]);
    }

    protected function registerEntries()
    {
        if (config('statamic-eloquent-driver.entries.enabled', true)) {

            Statamic::repository(EntryRepositoryContract::class, EntryRepository::class);

            $this->app->bind(EntryQueryBuilder::class, function ($app) {
                return new EntryQueryBuilder(
                    $app['statamic.eloquent.entries.model']::query()
                );
            });

            $this->app->bind('statamic.eloquent.entries.model', function () {
                return config('statamic-eloquent-driver.entries.model');
            });

        }
    }

    protected function registerCollections()
    {
        if (config('statamic-eloquent-driver.collections.enabled', true)) {

            Statamic::repository(CollectionRepositoryContract::class, CollectionRepository::class);

            $this->app->bind('statamic.eloquent.collections.model', function () {
                return config('statamic-eloquent-driver.collections.model');
            });

        }

        if (config('statamic-eloquent-driver.trees.enabled', true)) {

            Statamic::repository(CollectionTreeRepositoryContract::class, CollectionTreeRepository::class);

            $this->app->bind('statamic.eloquent.trees.model', function () {
                return config('statamic-eloquent-driver.trees.model');
            });

        }
    }

    public function registerTaxonomies()
    {
        if (config('statamic-eloquent-driver.taxonomies.enabled', true)) {

            Statamic::repository(TaxonomyRepositoryContract::class, TaxonomyRepository::class);

            $this->app->bind('statamic.eloquent.taxonomies.model', function () {
                return config('statamic-eloquent-driver.taxonomies.model');
            });

        }

        if (config('statamic-eloquent-driver.terms.enabled', true)) {

            Statamic::repository(TermRepositoryContract::class, TermRepository::class);

            $this->app->bind(TermQueryBuilder::class, function ($app) {
                return new TermQueryBuilder(
                    $app['statamic.eloquent.terms.model']::query()
                );
            });

            $this->app->bind('statamic.eloquent.terms.model', function () {
                return config('statamic-eloquent-driver.terms.model');
            });

        }
    }

    private function registerGlobals()
    {

        if (config('statamic-eloquent-driver.global-sets.enabled', true)) {

            Statamic::repository(GlobalRepositoryContract::class, GlobalRepository::class);

            $this->app->bind('statamic.eloquent.global-sets.model', function () {
                return config('statamic-eloquent-driver.global-sets.model');
            });

        }

        if (config('statamic-eloquent-driver.variables.enabled', true)) {

            $this->app->bind('statamic.eloquent.variables.model', function () {
                return config('statamic-eloquent-driver.variables.model');
            });

        }

    }

    private function registerStructures()
    {

        if (config('statamic-eloquent-driver.navigations.enabled', true)) {

            Statamic::repository(NavigationRepositoryContract::class, NavigationRepository::class);

            $this->app->bind('statamic.eloquent.navigations.model', function () {
                return config('statamic-eloquent-driver.navigations.model');
            });

        }

        if (config('statamic-eloquent-driver.nav-trees.enabled', true)) {

            Statamic::repository(NavTreeRepositoryContract::class, NavTreeRepository::class);

            $this->app->bind('statamic.eloquent.trees.model', function () {
                return config('statamic-eloquent-driver.trees.model');
            });

        }

    }
}
