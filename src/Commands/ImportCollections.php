<?php

namespace Statamic\Eloquent\Commands;

use Illuminate\Console\Command;
use Statamic\Console\RunsInPlease;
use Statamic\Contracts\Entries\CollectionRepository as CollectionRepositoryContract;
use Statamic\Contracts\Entries\EntryRepository as EntryRepositoryContract;
use Statamic\Eloquent\Collections\Collection;
use Statamic\Eloquent\Collections\CollectionModel;
use Statamic\Eloquent\Entries\UuidEntryModel;
use Statamic\Facades\Collection as CollectionFacade;
use Statamic\Stache\Repositories\CollectionRepository;
use Statamic\Stache\Repositories\EntryRepository;
use Statamic\Statamic;

class ImportCollections extends Command
{
    use RunsInPlease;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statamic:eloquent:import-collections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports file based collections into the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->useDefaultRepositories();

        $this->importCollections();

        return 0;
    }

    private function useDefaultRepositories()
    {
        Statamic::repository(EntryRepositoryContract::class, EntryRepository::class);
        Statamic::repository(CollectionRepositoryContract::class, CollectionRepository::class);
    }

    private function importCollections()
    {
        $collections = CollectionFacade::all();
        $bar = $this->output->createProgressBar($collections->count());

        $collections->each(function ($collection) use ($bar) {
            $this->toModel($collection)->save();
            $bar->advance();
        });

        $bar->finish();
        $this->line('');
        $this->info('Entries imported');
    }

    private function toModel($collection)
    {
        return new CollectionModel([
            'title' => $collection->title(),
            'handle' => $collection->handle(),
            'routes' => $collection->routes(),
            'dated' => $collection->dated(),
            'past_date_behavior' => $collection->pastDateBehavior(),
            'future_date_behavior' => $collection->futureDateBehavior(),
            'default_publish_state' => $collection->defaultPublishState(),
            'ampable' => $collection->ampable(),
            'sites' => $collection->sites(),
            'template' => $collection->template(),
            'layout' => $collection->layout(),
            'sort_dir' => $collection->sortDirection(),
            'sort_field' => $collection->sortField(),
            'mount' => $collection->mount(),
            'taxonomies' => $collection->taxonomies(),
//            'revisions' => $collection->revisions,
            'inject' => $collection->cascade(),
            'structure' => $collection->hasStructure() ? $collection->structureContents() : null,
        ]);
    }
}
