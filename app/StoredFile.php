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
    protected $fillable = ['filename', 'upload_completed'];
    protected $appends = ['url'];

    public function getFilePath(): string
    {
        return 'uploads/' . $this->getKey() . '-' . $this->filename;
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
}
