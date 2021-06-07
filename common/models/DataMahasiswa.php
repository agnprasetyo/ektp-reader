<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data_mahasiswa".
 *
 * @property int $id
 * @property string $nik
 * @property string|null $nama
 * @property string|null $alamat
 * @property string|null $jenis_kelamin
 * @property string|null $tempat_lahir
 * @property string|null $tanggal_lahir
 * @property string|null $agama
 * @property string|null $status
 * @property string|null $pekerjaan
 * @property string|null $berlaku_hingga
 * @property string|null $nim
 * @property string|null $jenjang
 * @property string|null $jurusan
 * @property string|null $fakultas
 * @property string|null $status_mhs
 *
 * @property AnalisaAlternatif[] $analisaAlternatifs
 * @property HasilAnalisa[] $hasilAnalisas
 */
class DataMahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'nik'], 'required'],
            [['id',], 'integer'],
            [['qi'], 'number'],
            [['nik'], 'string', 'max' => 16],
            [['nama', 'alamat', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'status', 'pekerjaan', 'berlaku_hingga', 'nim', 'jenjang', 'jurusan', 'fakultas', 'status_mhs'], 'string', 'max' => 255],
            [['id'], 'unique'],
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
            'status_mhs' => 'Status Mhs',
            'qi' => 'Hasil Akhir',
        ];
    }

    /**
     * Gets query for [[AnalisaAlternatifs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaAlternatifs()
    {
        return $this->hasMany(AnalisaAlternatif::className(), ['id_alternatif' => 'id']);
    }

    /**
     * Gets query for [[HasilAnalisas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHasilAnalisas()
    {
        return $this->hasMany(HasilAnalisa::className(), ['id_alternatif' => 'id']);
    }
}
