<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data_kriteria".
 *
 * @property string $id_kriteria
 * @property string $nama_kriteria
 * @property float $jumlah_kriteria
 * @property float $bobot_kriteria
 *
 * @property AnalisaAlternatif[] $analisaAlternatifs
 * @property AnalisaKriteria[] $analisaKriterias
 * @property AnalisaKriteria[] $analisaKriterias0
 * @property DataKriteria[] $kriteriaKeduas
 * @property DataKriteria[] $kriteriaPertamas
 * @property JumAltKri[] $jumAltKris
 * @property DataAlternatif[] $alternatifs
 */
class DataKriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_kriteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kriteria', 'nama_kriteria', 'jumlah_kriteria', 'bobot_kriteria', 'status'], 'required'],
            [['jumlah_kriteria', 'bobot_kriteria', 'status'], 'number'],
            [['id_kriteria'], 'string', 'max' => 2],
            [['nama_kriteria'], 'string', 'max' => 45],
            [['id_kriteria'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kriteria' => 'Id Kriteria',
            'nama_kriteria' => 'Nama Kriteria',
            'jumlah_kriteria' => 'Jumlah Kriteria',
            'bobot_kriteria' => 'Bobot Kriteria',
            'status' => 'Status',
        ];
    }

    public static function getNewId() {
        $lastModel = self::find()
                    ->select(['id_kriteria'])
                    ->orderBy(['id_kriteria' => SORT_DESC])
                    ->one();

        if($lastModel != null) {
            $lastId = explode('C', $lastModel->id_kriteria);

            return 'C' . ($lastId[1] + 1);
        } else {
            return 'C1';
        }
    }

    /**
     * Gets query for [[AnalisaAlternatifs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaAlternatifs()
    {
        return $this->hasMany(AnalisaAlternatif::className(), ['id_kriteria' => 'id_kriteria']);
    }

    /**
     * Gets query for [[AnalisaKriterias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaKriterias()
    {
        return $this->hasMany(AnalisaKriteria::className(), ['kriteria_pertama' => 'id_kriteria']);
    }

    /**
     * Gets query for [[AnalisaKriterias0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalisaKriterias0()
    {
        return $this->hasMany(AnalisaKriteria::className(), ['kriteria_kedua' => 'id_kriteria']);
    }

    /**
     * Gets query for [[KriteriaKeduas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKriteriaKeduas()
    {
        return $this->hasMany(DataKriteria::className(), ['id_kriteria' => 'kriteria_kedua'])->viaTable('analisa_kriteria', ['kriteria_pertama' => 'id_kriteria']);
    }

    /**
     * Gets query for [[KriteriaPertamas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKriteriaPertamas()
    {
        return $this->hasMany(DataKriteria::className(), ['id_kriteria' => 'kriteria_pertama'])->viaTable('analisa_kriteria', ['kriteria_kedua' => 'id_kriteria']);
    }

    /**
     * Gets query for [[JumAltKris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJumAltKris()
    {
        return $this->hasMany(JumAltKri::className(), ['id_kriteria' => 'id_kriteria']);
    }

    /**
     * Gets query for [[Alternatifs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlternatifs()
    {
        return $this->hasMany(DataAlternatif::className(), ['id' => 'id_alternatif'])->viaTable('jum_alt_kri', ['id_kriteria' => 'id_kriteria']);
    }
}
