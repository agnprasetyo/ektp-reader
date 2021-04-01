<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hasil_analisa".
 *
 * @property int $id
 * @property int|null $id_alternatif
 * @property float|null $Si
 * @property float|null $Ri
 * @property float|null $Qi
 * @property float|null $Qii
 * @property float|null $Qiii
 *
 * @property DataMahasiswa $alternatif
 */
class HasilAnalisa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hasil_analisa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alternatif'], 'integer'],
            [['Si', 'Ri', 'Qi', 'Qii', 'Qiii'], 'number'],
            [['id_alternatif'], 'exist', 'skipOnError' => true, 'targetClass' => DataMahasiswa::className(), 'targetAttribute' => ['id_alternatif' => 'id']],
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
            'Si' => 'Si',
            'Ri' => 'Ri',
            'Qi' => 'Qi',
            'Qii' => 'Qii',
            'Qiii' => 'Qiii',
        ];
    }

    /**
     * Gets query for [[Alternatif]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlternatif()
    {
        return $this->hasOne(DataMahasiswa::className(), ['id' => 'id_alternatif']);
    }
}
