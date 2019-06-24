<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Category extends Model
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
}
