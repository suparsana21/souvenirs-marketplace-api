<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Merchant extends Model
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
        'email',
        'password',
        'address',
        'phone',
        'contact_person',
        'contact_person_phone',
        'photo',
        'description',
        'status',
        'api_token',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token'
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