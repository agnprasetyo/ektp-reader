<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analisa_alternatif".
 *
 * @property int $id
 * @property string $id_alternatif
 * @property string $id_kriteria
 * @property string $nilai
 * @property float $bobot_alternatif
 *
 * @property DataMahasiswa $mahasiswa
 * @property DataKriteria $kriteria
 */
class AnalisaAlternatif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analisa_alternatif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alternatif', 'id_kriteria', 'nilai', 'bobot_alternatif'], 'required'],
            [['bobot_alternatif'], 'number'],
            [['id_alternatif'], 'string', 'max' => 4],
            [['id_kriteria'], 'string', 'max' => 2],
            [['id_alternatif'], 'exist', 'skipOnError' => true, 'targetClass' => DataMahasiswa::className(), 'targetAttribute' => ['id_alternatif' => 'id']],
            [['id_kriteria'], 'exist', 'skipOnError' => true, 'targetClass' => DataKriteria::className(), 'targetAttribute' => ['id_kriteria' => 'id_kriteria']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_alternatif' => 'Id Alternatif',
            'id_kriteria' => 'Id Kriteria',
            'nilai' => 'Nilai',
            'bobot_alternatif' => 'Bobot Alternatif',
        ];
    }

    /**
     * Gets query for [[Mahasiswa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMahasiswa()
    {
        return $this->hasOne(DataMahasiswa::className(), ['id' => 'id_alternatif']);
    }

    /**
     * Gets query for [[Kriteria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKriteria()
    {
        return $this->hasOne(DataKriteria::className(), ['id_kriteria' => 'id_kriteria']);
    }
}
