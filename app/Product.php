<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Product extends Model
{

    /**
     * Disable auto increment.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'unit_id',
        'category_id',
        'weight',
        'thumbnail',
    ];



    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Set UUID on boot.
        self::creating(function ($model) {
            $model->id = (string) Str::uuid();

        });
    }

    public function unit(){
        return $this->belongsTo('App\Unti', 'unit_id');
    }

    public function category(){
        return $this->belongsTo('App\Category', 'category_id');
    }
}
