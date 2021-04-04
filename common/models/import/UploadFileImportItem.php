<?php

namespace common\models\import;

use Yii;
use yii\base\Model;

/**
 * 
 * UploadFileImportItem is the model behind the form.
 */
class UploadFileImportItem extends Model
{
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /**
             * mimeTypes
             * 
             * @see https://en.wikipedia.org/wiki/Media_type#List_of_app_media_types
             */
            [
                ['file'], 'file',
                'skipOnEmpty' => false,
                'extensions' => 'xlsx',
            ],
        ];
    }

    /**
     * 
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Pastikan telah menggunakan file template yang sesuai.',
        ];
    }
}
