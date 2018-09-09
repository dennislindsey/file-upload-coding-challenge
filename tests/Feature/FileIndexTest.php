<?php

namespace Tests\Feature;

use App\StoredFile;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function can_retrieve_files_from_api()
    {
        /** @var StoredFile $file */
        $file = factory(StoredFile::class)->create();

        /** @var TestResponse $response */
        $response = $this->get(route('api.file.index'));
        $response->assertOk();

        $response->assertJsonStructure([
            '*' => [
                'id',
                'filename',
                'type',
                'upload_completed',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
        ]);
        $response->assertJsonFragment($file->toArray());
    }

    /**
     * @test
     */
    function can_search_file_names()
    {
        /** @var StoredFile $searchHit */
        $searchHit = factory(StoredFile::class)->create(['filename' => 'search hit']);

        /** @var StoredFile $searchMiss */
        $searchMiss = factory(StoredFile::class)->create(['filename' => 'search miss']);

        /** @var TestResponse $response */
        $response = $this->get(route('api.file.index', [
            'search' => 'hit',
        ]));
        $response->assertOk();

        $response->assertJsonFragment($searchHit->toArray());
        $response->assertJsonMissing(['id' => $searchMiss->getKey()]);
        $response->assertJsonMissing(['filename' => $searchMiss->filename]);
    }

    /**
     * @test
     */
    function can_search_file_types()
    {
        /** @var StoredFile $searchHit */
        $searchHit = factory(StoredFile::class)->create(['type' => 'image/png']);

        /** @var StoredFile $searchMiss */
        $searchMiss = factory(StoredFile::class)->create(['type' => 'image/jpeg']);

        /** @var TestResponse $response */
        $response = $this->get(route('api.file.index', [
            'type' => 'png',
        ]));
        $response->assertOk();

        $response->assertJsonFragment($searchHit->toArray());
        $response->assertJsonMissing(['id' => $searchMiss->getKey()]);
        $response->assertJsonMissing(['filename' => $searchMiss->filename]);
    }

    /**
     * @test
     */
    function can_search_both_file_type_and_name()
    {
        /** @var StoredFile $searchHit */
        $searchHit = factory(StoredFile::class)->create(['filename' => 'search hit', 'type' => 'image/png']);

        /** @var StoredFile $searchMiss */
        $searchMiss = factory(StoredFile::class)->create(['filename' => 'search miss', 'type' => 'image/jpeg']);

        /** @var TestResponse $response */
        $response = $this->get(route('api.file.index', [
            'search' => 'hit',
            'type'   => 'png',
        ]));
        $response->assertOk();

        $response->assertJsonFragment($searchHit->toArray());
        $response->assertJsonMissing(['id' => $searchMiss->getKey()]);
        $response->assertJsonMissing(['filename' => $searchMiss->filename]);
    }
}
