<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_active".
 *
 * @property int $id_assign
 *
 * @property AuthAssign $assign
 */
class AuthActive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_active';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_assign'], 'required'],
            [['id_assign'], 'integer'],
            [['id_assign'], 'unique'],
            [['id_assign'], 'exist', 'skipOnError' => true, 'targetClass' => AuthAssign::className(), 'targetAttribute' => ['id_assign' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_assign' => 'Id Assign',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssign()
    {
        return $this->hasOne(AuthAssign::className(), ['id' => 'id_assign']);
    }
}
