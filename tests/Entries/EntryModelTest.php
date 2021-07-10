<?php

namespace Tests\Entries;

use Illuminate\Database\Eloquent\Model;
use Statamic\Eloquent\Entries\EntryModel;
use Tests\TestCase;

class EntryModelTest extends TestCase
{
    /** @test */
    public function it_saves_record_to_the_database()
    {
        $model = EntryModel::create([
            'slug' => 'the-slug',
            'data' => [
                'foo' => 'bar'
            ]
        ]);

        $this->assertDatabaseHas('entries'. [
            'slug' => 'the-slug'
        ]);

        $this->assertEquals('the-slug', $model->slug);
        $this->assertEquals('bar', $model->foo);
        $this->assertEquals(['foo' => 'bar'], $model->data);

    }

    /** @test */
    public function it_gets_attributes_from_json_column()
    {
        $model = new EntryModel([
            'slug' => 'the-slug',
            'data' => [
                'foo' => 'bar'
            ]
        ]);

        $this->assertEquals('the-slug', $model->slug);
        $this->assertEquals('bar', $model->foo);
        $this->assertEquals(['foo' => 'bar'], $model->data);

    }

}
