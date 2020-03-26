<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_ref".
 *
 * @property string $assign
 *
 * @property AuthAssign[] $authAssigns
 */
class AuthRef extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_ref';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assign'], 'required'],
            [['assign'], 'string', 'max' => 32],
            [['assign'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'assign' => 'Assign',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssigns()
    {
        return $this->hasMany(AuthAssign::className(), ['assign' => 'assign']);
    }
}
