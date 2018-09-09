<?php

namespace Tests\Feature;

use App\StoredFile;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function can_upload_file_chunk_to_previously_created_file()
    {
        /** @var StoredFile $storedFile */
        $storedFile = factory(StoredFile::class)->create([
            'upload_completed' => false,
            'created_at'       => now()->subMinute(),
            'updated_at'       => now()->subMinute(),
        ]);

        /** @var TestResponse $response */
        $response = $this->json('PATCH', route('api.file.update', $storedFile->getKey()), [
            'chunk' => base64_encode('test'),
        ]);

        $response->assertOk();

        /** @var StoredFile $updatedFile */
        $updatedFile = $storedFile->fresh();

        $this->assertNotEquals($updatedFile->updated_at, $storedFile->updated_at);

        $response->assertJson($updatedFile->toArray());
        $this->assertFalse($updatedFile->upload_completed);
    }

    /**
     * @test
     */
    function chunk_is_a_required_field()
    {
        /** @var StoredFile $storedFile */
        $storedFile = factory(StoredFile::class)->create([
            'upload_completed' => false,
            'created_at'       => now()->subMinute(),
            'updated_at'       => now()->subMinute(),
        ]);

        /** @var TestResponse $response */
        $response = $this->json('PATCH', route('api.file.update', $storedFile->getKey()), [
            // 'chunk' => base64_encode('test'),
        ]);

        $response->assertStatus(422);

        /** @var StoredFile $updatedFile */
        $updatedFile = $storedFile->fresh();

        $this->assertEquals($updatedFile->updated_at, $storedFile->updated_at);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'chunk' => [
                    'The chunk field is required.'
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    function can_complete_upload()
    {
        /** @var StoredFile $storedFile */
        $storedFile = factory(StoredFile::class)->create([
            'upload_completed' => false,
            'created_at'       => now()->subMinute(),
            'updated_at'       => now()->subMinute(),
        ]);

        /** @var TestResponse $response */
        $response = $this->json('PATCH', route('api.file.update', $storedFile->getKey()), [
            'chunk'     => base64_encode('test'),
            'endOfFile' => true,
        ]);

        $response->assertOk();

        /** @var StoredFile $updatedFile */
        $updatedFile = $storedFile->fresh();

        $this->assertNotEquals($updatedFile->updated_at, $storedFile->updated_at);

        $response->assertJson($updatedFile->toArray());
        $this->assertTrue($updatedFile->upload_completed);
    }
}
