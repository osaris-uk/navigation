<?php

namespace OsarisUk\Navigation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'icon',
        'parent_id',
        'order_by',
        'route',
        'target',
        'realm',
        'permission',
        'disabled',
    ];

    public static function customNames()
    {
        return [
            'table_name' => 'Navigation',
            'id' => 'ID',
            'title' => 'Title',
            'icon' => 'Icon',
            'parent_id' => 'Parent',
            'order_by' => 'Order',
            'route' => 'Route',
            'target' => 'Target',
            'realm' => 'Realm',
            'permission' => 'Permission',
            'disabled' => 'Disabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At'
        ];
    }

    public function parent()
    {
        return $this->hasOne(Navigation::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Navigation::class, 'parent_id', 'id')->where('disabled', false)->orderBy('order_by', 'asc');
    }  

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 4, 'children')))->where([['parent_id', '=', null], ['disabled', false]])->orderBy('order_by', 'asc')->get();
    }
}
