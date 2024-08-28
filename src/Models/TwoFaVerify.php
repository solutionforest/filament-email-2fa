<?php

namespace Solutionforest\FilamentEmail2fa\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class TwoFaVerify extends Model
{
    use HasTimestamps;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getTable()
    {
        return config('filament-email-2fa.verify_table');
    }

    public function user()
    {
        return $this->morphTo();
    }
}
