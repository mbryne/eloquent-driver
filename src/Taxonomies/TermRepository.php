<?php

namespace Statamic\Eloquent\Taxonomies;

use Illuminate\Database\Eloquent\Builder;
use Statamic\Contracts\Taxonomies\Term as TermContract;
use Statamic\Stache\Repositories\TermRepository as StacheRepository;

class TermRepository extends StacheRepository
{
    public function query()
    {
        $this->ensureAssociations();

        return app(TermQueryBuilder::class);
    }

    public function find($id): ?Term
    {
        [$handle, $slug] = explode('::', $id);

        $term = $this->query()
            ->where('taxonomy', $handle)
            ->where('slug', $slug);
        $term = $term->first();

        return $term;
    }

    public function save($entry)
    {
        $model = $entry->toModel();

        $model->save();

        $entry->model($model->fresh());
    }

    public function delete($entry)
    {
        $entry->model()->delete();
    }

    public static function bindings(): array
    {
        return [
            TermContract::class => Term::class,
        ];
    }
}