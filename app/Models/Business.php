<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Business extends Model
{
    use HasFactory;
    

    protected static function boot()
    {
            parent::boot();

            static::creating(function ($model) {
                $model->{$model->getKeyName()} = (string) Str::uuid();$model->{$model->getKeyName()} = Str::uuid();
            });
    }
    
    protected $casts = [
        'id' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business_category()
    {
        return $this->belongsTo(Business_category::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
