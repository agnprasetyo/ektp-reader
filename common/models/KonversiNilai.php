<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "konversi_nilai".
 *
 * @property int $id
 * @property string $nama_kriteria
 * @property string $nilai_awal
 * @property float $nilai_konversi
 */
class KonversiNilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konversi_nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_kriteria', 'nilai_awal', 'nilai_konversi'], 'required'],
            [['nilai_konversi'], 'number'],
            [['nama_kriteria', 'nilai_awal'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kriteria' => 'Nama Kriteria',
            'nilai_awal' => 'Nilai Awal',
            'nilai_konversi' => 'Nilai Konversi',
        ];
    }
}
