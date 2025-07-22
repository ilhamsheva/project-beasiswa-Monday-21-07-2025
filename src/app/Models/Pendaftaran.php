<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * title="Pendaftaran",
 * description="Model Pendaftaran Beasiswa",
 * @OA\Xml(
 * name="Pendaftaran"
 * )
 * )
 */
class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';
    protected $fillable = [
        'user_id',
        'beasiswa_id',
        'tanggal_daftar',
        'status_verifikasi',
        'catatan_verifikasi',
    ];

    /**
     * @OA\Property(
     * title="ID",
     * description="ID Pendaftaran",
     * format="int64",
     * example=1
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     * title="User ID",
     * description="ID Pengguna (Peserta) yang mengajukan",
     * format="int64",
     * example=1
     * )
     *
     * @var int
     */
    public $user_id;

    /**
     * @OA\Property(
     * title="Beasiswa ID",
     * description="ID Beasiswa yang dilamar",
     * format="int64",
     * example=1
     * )
     *
     * @var int
     */
    public $beasiswa_id;

    /**
     * @OA\Property(
     * title="Tanggal Daftar",
     * description="Tanggal pendaftaran diajukan",
     * format="date",
     * type="string",
     * example="2025-07-22"
     * )
     *
     * @var string
     */
    public $tanggal_daftar;

    /**
     * @OA\Property(
     * title="Status Verifikasi",
     * description="Status verifikasi pendaftaran beasiswa",
     * enum={"diproses", "disetujui", "ditolak"},
     * example="diproses"
     * )
     *
     * @var string
     */
    public $status_verifikasi;

    /**
     * @OA\Property(
     * title="Catatan Verifikasi",
     * description="Catatan dari Staf Akademik (opsional) saat verifikasi",
     * nullable=true,
     * example="Dokumen KHS perlu diperbarui."
     * )
     *
     * @var string
     */
    public $catatan_verifikasi;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}
