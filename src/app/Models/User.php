<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


/**
 * @OA\Schema(
 * title="User",
 * description="User model",
 * @OA\Xml(
 * name="User"
 * )
 * )
 */

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'avatar_url',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @OA\Property(
     * title="ID",
     * description="ID Pengguna",
     * format="int64",
     * example=1
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     * title="Avatar URL",
     * description="URL Avatar pengguna",
     * nullable=true,
     * example="http://example.com/avatar/1.jpg"
     * )
     *
     * @var string
     */
    public $avatar_url; //

    /**
     * @OA\Property(
     * title="Nama",
     * description="Nama lengkap pengguna",
     * example="Ilham Sheva"
     * )
     *
     * @var string
     */
    public $name; //

    /**
     * @OA\Property(
     * title="Email",
     * description="Alamat email pengguna",
     * format="email",
     * example="ilham.sheva@esaunggul.ac.id"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     * title="Password",
     * description="Kata sandi pengguna (hashed)",
     * format="password",
     * example="$2y$10$eImiTMZG4TQ2Lkz5j1a5uO"
     * )
     *
     * @var string
     */
    public $password; //

    /**
     * @OA\Property(
     * title="Email Verified At",
     * description="Timestamp verifikasi email",
     * format="date-time",
     * type="string",
     * nullable=true,
     * example="2025-07-22T04:00:00Z"
     * )
     *
     * @var \DateTime
     */
    public $email_verified_at; //

    /**
     * @OA\Property(
     * title="Waktu Dibuat",
     * description="Timestamp pembuatan data",
     * format="date-time",
     * type="string",
     * example="2025-07-22T04:00:00Z"
     * )
     *
     * @var \DateTime
     */
    public $created_at;

    /**
     * @OA\Property(
     * title="Waktu Diperbarui",
     * description="Timestamp terakhir data diperbarui",
     * format="date-time",
     * type="string",
     * example="2025-07-22T04:00:00Z"
     * )
     *
     * @var \DateTime
     */
    public $updated_at;

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            return asset('storage/' . $this->avatar_url);
        } else {
            $hash = md5(strtolower(trim($this->email)));

            return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function data_pesertas()
    {
        return $this->hasOne(DataPeserta::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
