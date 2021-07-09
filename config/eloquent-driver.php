<?php

return [

    'migrations' => true,

    'entries' => [
        'model'     => \Statamic\Eloquent\Entries\EntryModel::class,
        'string_id' => false,
        'enabled'   => true
    ],

    'collections' => [
        'model'   => \Statamic\Eloquent\Collections\CollectionModel::class,
        'enabled' => true
    ],

    'trees' => [
        'model'   => \Statamic\Eloquent\Structures\TreeModel::class,
        'enabled' => true,
    ],

    'taxonomies' => [
        'model'   => \Statamic\Eloquent\Taxonomies\TaxonomyModel::class,
        'enabled' => true,
    ],

    'terms' => [
        'model'   => \Statamic\Eloquent\Taxonomies\TermModel::class,
        'enabled' => true,
    ],

    'global-sets' => [
        'model'   => \Statamic\Eloquent\Globals\GlobalSetModel::class,
        'enabled' => true,
    ],

    'variables' => [
        'model'   => \Statamic\Eloquent\Globals\VariablesModel::class,
        'enabled' => true,
    ],

    'navigations' => [
        'model'   => \Statamic\Eloquent\Structures\NavModel::class,
        'enabled' => true,
    ],

    'nav-trees' => [
        'model'   => \Statamic\Eloquent\Structures\NavTreeModel::class,
        'enabled' => true,
    ],

];
