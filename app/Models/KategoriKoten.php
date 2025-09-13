<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKoten extends Model
{
    protected $table = 'kategori_kotens';

    protected $guarded = ['id'];

    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    protected function getRouteName()
    {
        return 'slug';
    }

    /**
     * Get the kontens for the kategori.
     */
    public function kontens()
    {
        return $this->hasMany(Konten::class, 'kategori_koten_id');
    }
}
