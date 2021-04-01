<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tools".
 *
 * @property int $id
 * @property int $id_user
 * @property string $url
 * @property int $port
 * @property string $serial
 * @property string $tempat
 *
 * @property User $user
 */
class Tools extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tools';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'port', 'serial', 'tempat'], 'required'],
            [['id_user', 'port'], 'integer'],
            [['serial', 'tempat', 'url'], 'string', 'max' => 255],
            [['id_user'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Username',
            'url' => 'Url',
            'port' => 'Port',
            'serial' => 'Serial',
            'tempat' => 'Tempat',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
