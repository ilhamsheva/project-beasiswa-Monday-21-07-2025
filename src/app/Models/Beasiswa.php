<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * title="Beasiswa",
 * description="Beasiswa model",
 * @OA\Xml(
 * name="Beasiswa"
 * )
 * )
 */
class Beasiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_beasiswa',
        'deskripsi',
        'periode_buka',
        'periode_tutup',
        'status',
    ];
    protected $casts = [
        'periode_buka' => 'date',
        'periode_tutup' => 'date',
    ];

    /**
     * @OA\Property(
     * title="ID",
     * description="ID Beasiswa",
     * format="int64",
     * example=1
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     * title="Nama Beasiswa",
     * description="Nama program beasiswa",
     * example="Beasiswa Prestasi Akademik 2025"
     * )
     *
     * @var string
     */
    public $nama_beasiswa; //

    /**
     * @OA\Property(
     * title="Deskripsi",
     * description="Deskripsi lengkap beasiswa",
     * example="Diberikan kepada mahasiswa aktif dengan Indeks Prestasi Kumulatif (IPK) di atas 3.50."
     * )
     *
     * @var string
     */
    public $deskripsi; //

    /**
     * @OA\Property(
     * title="Periode Buka",
     * description="Tanggal mulai pendaftaran beasiswa",
     * format="date",
     * type="string",
     * example="2025-07-01"
     * )
     *
     * @var string
     */
    public $periode_buka; //

    /**
     * @OA\Property(
     * title="Periode Tutup",
     * description="Tanggal berakhir pendaftaran beasiswa",
     * format="date",
     * type="string",
     * example="2025-08-31"
     * )
     *
     * @var string
     */
    public $periode_tutup; //

    /**
     * @OA\Property(
     * title="Status Beasiswa",
     * description="Status ketersediaan beasiswa (misal: aktif, nonaktif, dibuka, ditutup)",
     * type="string",
     * example="aktif",
     * nullable=true
     * )
     *
     * @var string
     */
    public $status; //

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

    public function pendaftarans(){
        return $this->hasMany(Pendaftaran::class);
    }
}
