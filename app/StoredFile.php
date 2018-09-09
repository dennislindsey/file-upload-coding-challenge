<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoredFile extends Model
{
    use SoftDeletes;

    protected $table = "stored_file";
    public $timestamps = true;
    public $casts = [
        'upload_completed' => 'boolean',
    ];
    protected $fillable = ['filename_orig', 'filename', 'type', 'upload_completed'];
    protected $appends = ['url'];
    protected $attributes = ['upload_completed' => false, 'deleted_at' => null];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (StoredFile $storedFile) {
            $storedFile->deleteFile();
        });
    }

    public function getFilePath(): string
    {
        return 'uploads/' . $this->filename;
    }

    public function getFileURL(): string
    {
        return \Storage::url($this->getFilePath());
    }

    public function appendToFile(string $data): bool
    {
        return \Storage::append($this->getFilePath(), $data, '');
    }

    public function getUrlAttribute(): string
    {
        return $this->getFileURL();
    }

    public function deleteFile(): bool
    {
        return \Storage::delete($this->getFilePath());
    }
}
