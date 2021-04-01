<?php

namespace common\models\import;
use common\models\DataMahasiswa;

use Yii;

class ImportMahasiswa extends \yii\base\Model
{
  public $filecsv;

  public $filename;

  public function rules()
  {
    return [
      [
        "filecsv", "file", "extensions" => "csv"
      ]
    ];
  }

  public function attributeLabels()
  {
      return [
          'filecsv' => 'Select Document',
      ];
  }

  public function load($data, $formName = null)
  {
    $this->filecsv = \yii\web\UploadedFile::getInstance($this, "filecsv");
    $this->filename = '@frontend/runtime/uploads/' . $this->filecsv->name . '.' . $this->filecsv->extension;
    $this->filecsv->saveAs($this->filename);

    return true;
  }

  public function save()
  {
      $reader = new \DataReader\CSV\Reader(Yii::getAlias($this->filename));

      $attr = $reader->getAttributes();
      $listData = $reader->getData();

      // $attr = array_values($attr);
      // print_r($attr);
      // echo '<pre>';
      // print_r($listData);
      // echo '</pre>';
      // exit;

      foreach($listData as $data) {

          $searchdata = DataMahasiswa::findOne(['nik' => $data['nik']]);

          if ($searchdata == null) {
            $model = new DataMahasiswa;

            $model->nik = $data['nik'];
            $model->nama = $data['nama'];
            $model->alamat = null;
            $model->si = 0;
            $model->ri = 0;
            $model->qi = 0;
            $model->qii = 0;
            $model->qiii = 0;

            $model->save();
          } else {
            $searchdata->updateAttributes([
              'nik' => $data['nik'],
              'nama' => $data['nama'],
              'alamat' => null,
              'si' => 0,
              'ri' => 0,
              'qi' => 0,
              'qii' => 0,
              'qiii' => 0
            ]);
          }

      }

      // if($model->save()) {
      //   echo '<pre>';
      //   print_r($model->attributes);
      //   echo '</pre>';
      // } else {
      //   echo '<pre>';
      //   print_r($model->errors);
      //   echo '</pre>';
      // }
      // exit;
      return true;
  }
}
