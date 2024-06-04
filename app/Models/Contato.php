<?php

namespace App\Models;

use App\ContatoTipoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contato extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['pessoa_id', 'tipo', 'informacao'];

    /**
     * @return BelongsTo
     */
    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    /**
     * @return array
     */
    public function casts(): array
    {
        return [
            'tipo' => ContatoTipoEnum::class
        ];
    }
}
