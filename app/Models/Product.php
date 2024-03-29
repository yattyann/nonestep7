<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'company_id', 'price', 'stock', 'comment', 'img_path'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
