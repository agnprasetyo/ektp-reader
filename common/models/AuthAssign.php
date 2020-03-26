<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_assign".
 *
 * @property int $id
 * @property int $id_user
 * @property string $assign
 *
 * @property AuthActive $authActive
 * @property User $user
 * @property AuthRef $assign0
 */
class AuthAssign extends \yii\db\ActiveRecord
{
    const ADMINISTRATOR = 'administrator';
    const PENJUAL      = 'penjual';
    const PEMBELI      = 'pembeli';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'assign'], 'required'],
            [['id_user'], 'integer'],
            [['assign'], 'string', 'max' => 32],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['assign'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRef::className(), 'targetAttribute' => ['assign' => 'assign']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'assign' => 'Assign',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthActive()
    {
        return $this->hasOne(AuthActive::className(), ['id_assign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssign0()
    {
        return $this->hasOne(AuthRef::className(), ['assign' => 'assign']);
    }
}
