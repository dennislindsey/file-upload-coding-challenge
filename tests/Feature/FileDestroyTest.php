<?php

namespace Tests\Feature;

use App\StoredFile;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileDestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function can_delete_a_file()
    {
        /** @var StoredFile $storedFile */
        $storedFile = factory(StoredFile::class)->create();

        $this->assertTrue($storedFile->exists);
        $this->assertFalse($storedFile->trashed());
        $this->assertTrue(file_exists(storage_path('app/'. $storedFile->getFilePath())));

        /** @var TestResponse $response */
        $response = $this->json('DELETE', route('api.file.destroy', $storedFile->getKey()));

        $response->assertOk();

        $response->assertJson(['deleted' => true]);

        $this->assertTrue($storedFile->exists);
        $this->assertTrue($storedFile->refresh()->trashed());
    }
}
