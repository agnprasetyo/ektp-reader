<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nilai".
 *
 * @property int $id_nilai
 * @property float $jum_nilai
 * @property string $ket_nilai
 */
class Nilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jum_nilai', 'ket_nilai'], 'required'],
            [['jum_nilai'], 'number'],
            [['ket_nilai'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_nilai' => 'Id Nilai',
            'jum_nilai' => 'Skala Nilai Perbandingan',
            'ket_nilai' => 'Keterangan',
        ];
    }
}
