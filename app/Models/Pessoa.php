<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pessoa extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['nome'];

    /**
     * @return HasMany
     */
    public function contatos(): HasMany
    {
        return $this->hasMany(Contato::class);
    }
}
