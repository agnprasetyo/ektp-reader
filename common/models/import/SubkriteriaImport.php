<?php

namespace common\models\import;
use common\models\DataSubkriteria;
use common\models\DataKriteria;
use yii\web\UploadedFile;
use DataReader\CSV\Reader;

use Yii;

class SubkriteriaImport extends \yii\base\Model
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
    $this->filecsv = UploadedFile::getInstance($this, "filecsv");
    $this->filename = '@frontend/runtime/uploads/' . $this->filecsv->name . '.' . $this->filecsv->extension;
    $this->filecsv->saveAs($this->filename);

    return true;
  }

  public function save()
  {
      $reader = new Reader(Yii::getAlias($this->filename));

      $attr = $reader->getAttributes();
      $listData = $reader->getData();
      $listidkriteria = [];


      for ($a = 0; $a < count($listData); $a++) {
        $datakriteria = DataKriteria::find()
                      ->where(['nama_kriteria' => $listData[$a]['kriteria']])
                      ->asArray()
                      ->one();

        $listidkriteria[$listData[$a]['kriteria']] = $datakriteria['id_kriteria'];
      }

      foreach($listData as $data) {

        $model = new DataSubkriteria;
        $model->id_kriteria = $listidkriteria[$data['kriteria']];
        $model->nama_subkriteria = $data['status'];
        $model->skor = $data['skor'];
        $model->jumlah_subkriteria = 0;
        $model->bobot_subkriteria = $data['bobot'];



        $model->save();

      }
      return true;
  }
}
