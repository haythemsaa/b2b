<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'is_required',
        'is_filterable',
        'sort_order'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
    ];

    // Types d'attributs possibles
    const TYPE_TEXT = 'text';
    const TYPE_SELECT = 'select';
    const TYPE_MULTISELECT = 'multiselect';
    const TYPE_NUMBER = 'number';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_COLOR = 'color';

    public static function types()
    {
        return [
            self::TYPE_TEXT => 'Texte',
            self::TYPE_SELECT => 'Liste déroulante',
            self::TYPE_MULTISELECT => 'Sélection multiple',
            self::TYPE_NUMBER => 'Nombre',
            self::TYPE_BOOLEAN => 'Oui/Non',
            self::TYPE_COLOR => 'Couleur',
        ];
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class)->orderBy('sort_order');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values')
            ->withPivot('attribute_value_id');
    }
}
