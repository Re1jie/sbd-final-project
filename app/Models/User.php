<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['NAMA', 'EMAIL', 'PASSWORD', 'ROLE', 'ALAMAT'])]
#[Hidden(['PASSWORD', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. KASIH TAHU NAMA TABEL YANG BENAR
    protected $table = 'PELANGGAN';

    // 2. KASIH TAHU PRIMARY KEY-NYA ADALAH 'EMAIL', BUKAN 'id'
    protected $primaryKey = 'EMAIL';

    // 3. KARENA EMAIL ITU TEKS (BUKAN ANGKA AUTO-INCREMENT), MATIKAN INCREMENTING
    public $incrementing = false;
    protected $keyType = 'string';

    // 4. MATIKAN TIMESTAMPS (Agar Laravel tidak memaksa insert created_at & updated_at)
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

    public function isAdmin(): bool
    {
        return $this->ROLE === 'ADMIN';
    }

    public function isClient(): bool
    {
        return $this->ROLE === 'PELANGGAN';
    }
}