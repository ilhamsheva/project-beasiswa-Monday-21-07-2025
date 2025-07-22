<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * title="Dokumen",
 * description="Model Dokumen yang diunggah",
 * @OA\Xml(
 * name="Dokumen"
 * )
 * )
 */
class Dokumen extends Model
{
    use HasFactory;
    protected $table = 'dokumens';

    protected $fillable = [
        'pendaftaran_id',
        'ktm',
        'krs',
        'khs',
    ];

    /**
     * @OA\Property(
     * title="ID",
     * description="ID Dokumen",
     * format="int64",
     * example=1
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     * title="Pendaftaran ID",
     * description="ID Pendaftaran yang terkait dengan dokumen ini",
     * format="int64",
     * example=1
     * )
     *
     * @var int
     */
    public $pendaftaran_id; //

    /**
     * @OA\Property(
     * title="KTM Path",
     * description="Jalur penyimpanan file KTM",
     * nullable=true,
     * example="dokumen/ktm_user1.pdf"
     * )
     *
     * @var string
     */
    public $ktm; //

    /**
     * @OA\Property(
     * title="KRS Path",
     * description="Jalur penyimpanan file KRS",
     * nullable=true,
     * example="dokumen/krs_user1.pdf"
     * )
     *
     * @var string
     */
    public $krs; //

    /**
     * @OA\Property(
     * title="KHS Path",
     * description="Jalur penyimpanan file KHS",
     * nullable=true,
     * example="dokumen/khs_user1.pdf"
     * )
     *
     * @var string
     */
    public $khs; //

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

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class);
    }
}
