<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ProductGallery extends Model
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
        'product_id',
        'photo',
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

    public function product(){
        return $this->belongsTo('App\Product','product_id');
    }
}
