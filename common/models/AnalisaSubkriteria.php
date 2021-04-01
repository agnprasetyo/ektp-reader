<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analisa_subkriteria".
 *
 * @property string $subkriteria_pertama
 * @property float $nilai_analisa_subkriteria
 * @property float $hasil_analisa_subkriteria
 * @property string $subkriteria_kedua
 *
 * @property DataSubkriteria $subkriteriaPertama
 * @property DataSubkriteria $subkriteriaPertama0
 */
class AnalisaSubkriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analisa_subkriteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subkriteria_pertama', 'nilai_analisa_subkriteria', 'hasil_analisa_subkriteria', 'subkriteria_kedua'], 'required'],
            [['nilai_analisa_subkriteria', 'hasil_analisa_subkriteria'], 'number'],
            [['subkriteria_pertama', 'subkriteria_kedua'], 'string', 'max' => 11],
            // [['subkriteria_pertama', 'subkriteria_kedua'], 'unique', 'targetAttribute' => ['subkriteria_pertama', 'subkriteria_kedua']],
            [['subkriteria_pertama'], 'exist', 'skipOnError' => true, 'targetClass' => DataSubkriteria::className(), 'targetAttribute' => ['subkriteria_pertama' => 'id']],
            [['subkriteria_pertama'], 'exist', 'skipOnError' => true, 'targetClass' => DataSubkriteria::className(), 'targetAttribute' => ['subkriteria_pertama' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'subkriteria_pertama' => 'Subkriteria Pertama',
            'nilai_analisa_subkriteria' => 'Nilai Analisa Subkriteria',
            'hasil_analisa_subkriteria' => 'Hasil Analisa Subkriteria',
            'subkriteria_kedua' => 'Subkriteria Kedua',
        ];
    }

    /**
     * Gets query for [[SubkriteriaPertama]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubkriteriaPertama()
    {
        return $this->hasOne(DataSubkriteria::className(), ['id' => 'subkriteria_pertama']);
    }

    /**
     * Gets query for [[SubkriteriaPertama0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubkriteriaPertama0()
    {
        return $this->hasOne(DataSubkriteria::className(), ['id' => 'subkriteria_pertama']);
    }
    /**
     * Gets query for [[Kriteria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKriteria()
    {
        return $this->hasOne(DataSubkriteria::className(), ['id_kriteria' => 'id_kriteria']);
    }
}
