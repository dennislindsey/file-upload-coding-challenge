<?php

namespace Tests\Feature;

use App\StoredFile;
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function can_create_new_file()
    {
        /** @var Builder $existsQuery */
        $existsQuery = StoredFile::query()->where('filename_orig', 'test file name')->where('type', 'image/png');

        $this->assertFalse((clone $existsQuery)->exists());

        $response = $this->json('POST', route('api.file.store'), [
            'fileName' => 'test file name',
            'type'     => 'image/png',
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'id',
            'filename_orig',
            'filename',
            'type',
            'upload_completed',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
        $response->assertJsonFragment(['filename_orig' => 'test file name', 'type' => 'image/png']);

        $this->assertTrue((clone $existsQuery)->exists());
    }

    /**
     * @test
     */
    function file_name_is_required()
    {
        /** @var Builder $existsQuery */
        $existsQuery = StoredFile::query()->where('filename_orig', 'test file name')->where('type', 'image/png');

        $this->assertFalse((clone $existsQuery)->exists());

        $response = $this->json('POST', route('api.file.store'), [
            'type' => 'image/png',
            // 'fileName' => 'test file name',
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'fileName' => [
                    'The file name field is required.'
                ]
            ]
        ]);

        $this->assertFalse((clone $existsQuery)->exists());
    }

    /**
     * @test
     */
    function file_type_is_required()
    {
        /** @var Builder $existsQuery */
        $existsQuery = StoredFile::query()->where('filename_orig', 'test file name')->where('type', 'image/png');

        $this->assertFalse((clone $existsQuery)->exists());

        $response = $this->json('POST', route('api.file.store'), [
            // 'type' => 'image/png',
            'fileName' => 'test file name',
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'type' => [
                    'The type field is required.'
                ]
            ]
        ]);

        $this->assertFalse((clone $existsQuery)->exists());
    }
}
