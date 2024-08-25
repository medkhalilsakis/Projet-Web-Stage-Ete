<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
        'code_hb',
        'num_chambre'
    ];

    /**
     * Get the URL of the image.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return asset('storage/uploads/images/' . $this->path);
    }
}
