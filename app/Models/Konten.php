<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;

    protected $table = 'kontens';

    protected $guarded = ['id'];

    protected $fillable = [
        'kategori_koten_id',
        'title',
        'body',
        'slug',
        'image',
        'author',
        'status',
    ];

    protected function getRouteName()
    {
        return 'slug';
    }

    /**
     * Get the category that owns the konten.
     */
    public function kategoriKoten()
    {
        return $this->belongsTo(KategoriKoten::class, 'kategori_koten_id');
    }
}
