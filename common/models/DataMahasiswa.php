<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data_alternatif".
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
 *
 * @property AnalisaAlternatif[] $analisaAlternatifs
 * @property AnalisaAlternatif[] $analisaAlternatifs0
 * @property JumAltKri[] $jumAltKris
 * @property DataKriteria[] $kriterias
 * @property NilaiAwal[] $nilaiAwals
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
            [['id', 'nik'], 'required'],
            [['id', 'nik'], 'integer'],
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
            'nim' => 'Nim',
            'jenjang' => 'Jenjang',
            'jurusan' => 'Jurusan',
            'fakultas' => 'Fakultas',
            'status_mhs' => 'Status Mhs',
        ];
    }

    // public static function getNewId() {
    //     $lastModel = self::find()
    //                 ->select(['id'])
    //                 ->orderBy(['id' => SORT_DESC])
    //                 ->one();
    //
    //     if($lastModel != null) {
    //         $lastId = explode('A', $lastModel->id);
    //
    //         return 'A' . ($lastId[1] + 1);
    //     } else {
    //         return 'A1';
    //     }
    // }

    /**
     * Gets query for [[AnalisaAlternatifs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaAlternatifs()
    {
        return $this->hasMany(AnalisaAlternatif::className(), ['alternatif_pertama' => 'id']);
    }

    /**
     * Gets query for [[AnalisaAlternatifs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaAlternatifs0()
    {
        return $this->hasMany(AnalisaAlternatif::className(), ['alternatif_kedua' => 'id']);
    }

    /**
     * Gets query for [[JumAltKris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJumAltKris()
    {
        return $this->hasMany(JumAltKri::className(), ['id_alternatif' => 'id']);
    }

    /**
     * Gets query for [[Kriterias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKriterias()
    {
        return $this->hasMany(DataKriteria::className(), ['id_kriteria' => 'id_kriteria'])->viaTable('jum_alt_kri', ['id_alternatif' => 'id']);
    }

    /**
     * Gets query for [[NilaiAwals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNilaiAwals()
    {
        return $this->hasMany(NilaiAwal::className(), ['id_alternatif' => 'id']);
    }
}
