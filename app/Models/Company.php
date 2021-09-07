<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $name
 * @property string $email
 * @property string $phone
 * @method static findOrFail(int $id)
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }
}
