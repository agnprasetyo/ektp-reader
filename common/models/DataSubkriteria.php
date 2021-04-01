<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data_subkriteria".
 *
 * @property string $id
 * @property string $id_kriteria
 * @property string $nama_subkriteria
 * @property float $jumlah_subkriteria
 * @property float $bobot_subkriteria
 *
 * @property AnalisaSubkriteria[] $analisaSubkriterias
 * @property AnalisaSubkriteria[] $analisaSubkriterias0
 * @property DataKriteria $kriteria
 * @property NilaiAwal[] $nilaiAwals
 */
class DataSubkriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_subkriteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kriteria', 'nama_subkriteria', 'jumlah_subkriteria', 'bobot_subkriteria'], 'required'],
            [['jumlah_subkriteria', 'bobot_subkriteria'], 'number'],
            [['id_kriteria'], 'string', 'max' => 2],
            [['nama_subkriteria'], 'string', 'max' => 45],
            [['id', 'id_kriteria'], 'unique', 'targetAttribute' => ['id', 'id_kriteria']],
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
            'id_kriteria' => 'Id Kriteria',
            'nama_subkriteria' => 'Nama Subkriteria',
            'jumlah_subkriteria' => 'Jumlah Subkriteria',
            'bobot_subkriteria' => 'Bobot Subkriteria',
        ];
    }

    /**
     * Gets query for [[AnalisaSubkriterias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaSubkriterias()
    {
        return $this->hasMany(AnalisaSubkriteria::className(), ['subkriteria_pertama' => 'id']);
    }

    /**
     * Gets query for [[AnalisaSubkriterias0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaSubkriterias0()
    {
        return $this->hasMany(AnalisaSubkriteria::className(), ['subkriteria_pertama' => 'id']);
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

    /**
     * Gets query for [[NilaiAwals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNilaiAwals()
    {
        return $this->hasMany(NilaiAwal::className(), ['id_subkriteria' => 'id']);
    }
}
