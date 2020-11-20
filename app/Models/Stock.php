<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        if ($this->retailer->name === 'Best Buy ') {
            $results = Http::get('http://foo.test')->json();

            dd($results);
        }
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    } 
}
