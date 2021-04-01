<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analisa_kriteria".
 *
 * @property string $kriteria_pertama
 * @property float $nilai_analisa_kriteria
 * @property float $hasil_analisa_kriteria
 * @property string $kriteria_kedua
 *
 * @property DataKriteria $kriteriaPertama
 * @property DataKriteria $kriteriaKedua
 */
class AnalisaKriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analisa_kriteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kriteria_pertama', 'nilai_analisa_kriteria', 'hasil_analisa_kriteria', 'kriteria_kedua'], 'required'],
            [['nilai_analisa_kriteria', 'hasil_analisa_kriteria'], 'number'],
            [['kriteria_pertama', 'kriteria_kedua'], 'string', 'max' => 2],
            [['kriteria_pertama', 'kriteria_kedua'], 'unique', 'targetAttribute' => ['kriteria_pertama', 'kriteria_kedua']],
            [['kriteria_pertama'], 'exist', 'skipOnError' => true, 'targetClass' => DataKriteria::className(), 'targetAttribute' => ['kriteria_pertama' => 'id_kriteria']],
            [['kriteria_kedua'], 'exist', 'skipOnError' => true, 'targetClass' => DataKriteria::className(), 'targetAttribute' => ['kriteria_kedua' => 'id_kriteria']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kriteria_pertama' => 'Kriteria Pertama',
            'nilai_analisa_kriteria' => 'Nilai Analisa Kriteria',
            'hasil_analisa_kriteria' => 'Hasil Analisa Kriteria',
            'kriteria_kedua' => 'Kriteria Kedua',
        ];
    }

    /**
     * Gets query for [[KriteriaPertama]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKriteriaPertama()
    {
        return $this->hasOne(DataKriteria::className(), ['id_kriteria' => 'kriteria_pertama']);
    }

    /**
     * Gets query for [[KriteriaKedua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKriteriaKedua()
    {
        return $this->hasOne(DataKriteria::className(), ['id_kriteria' => 'kriteria_kedua']);
    }
}
