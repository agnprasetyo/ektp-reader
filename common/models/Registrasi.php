<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "registrasi".
 *
 * @property int $id
 * @property int $nik
 * @property string $nama
 * @property string $alamat
 * @property string $jenis_kelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $agama
 * @property string $status
 * @property string $pekerjaan
 * @property string $berlaku_hingga
 * @property string $nim
 * @property string $jenjang
 * @property string $jurusan
 * @property string $fakultas
 * @property string $status_mhs

 */
class Registrasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registrasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nik'], 'required'],
            [['nik'], 'integer'],
            [['nama', 'alamat', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'status', 'pekerjaan', 'berlaku_hingga', 'nim', 'jenjang', 'jurusan', 'fakultas', 'status_mhs'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nik' => 'Nik',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'agama' => 'Agama',
            'status' => 'Status',
            'pekerjaan' => 'Pekerjaan',
            'berlaku_hingga' => 'Berlaku Hingga',
            'nim' => 'NIM',
            'jenjang' => 'Jenjang',
            'jurusan' => 'Jurusan',
            'fakultas' => 'Fakultas',
            'status_mhs' => 'Status Mahasiswa',
        ];
    }
}
