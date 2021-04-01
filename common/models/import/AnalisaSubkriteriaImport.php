<?php

namespace common\models\import;
use common\models\AnalisaSubkriteria;
use common\models\DataKriteria;
use common\models\DataSubkriteria;
use common\models\KonversiNilaiAwal;
use yii\web\UploadedFile;
use DataReader\CSV\Reader;

use Yii;

class AnalisaSubkriteriaImport extends \yii\base\Model
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
      $listidsubkriteriasatu = [];
      $listidsubkriteriadua = [];
      // echo '<pre>';
      // print_r($listData);
      // echo '</pre>';exit;

      for ($a = 0; $a < count($listData); $a++) {
        $datakriteria = DataKriteria::find()
                      ->where(['nama_kriteria' => $listData[$a]['kriteria']])
                      ->asArray()
                      ->one();

        $datasubkriteria = DataSubkriteria::find()
                         ->where(['nama_subkriteria' => $listData[$a]['subkriteria_pertama']])
                         ->asArray()
                         ->one();

        $listidkriteria[$listData[$a]['kriteria']] = $datakriteria['id_kriteria'];
        $listidsubkriteriasatu[$listData[$a]['subkriteria_pertama']] = $datasubkriteria['id'];
        $listidsubkriteriadua[$listData[$a]['subkriteria_kedua']] = $datasubkriteria['id'];
      }

      foreach($listData as $data) {

          $model = new AnalisaSubkriteria;

          $model->subkriteria_pertama = $listidsubkriteriasatu[$data['subkriteria_pertama']];
          $model->nilai_analisa_subkriteria = $data['nilai_analisa'];
          $model->hasil_analisa_subkriteria = 0;
          $model->subkriteria_kedua = $listidsubkriteriadua[$data['subkriteria_kedua']];
          $model->id_kriteria = $listidkriteria[$data['kriteria']];
          $model->save();

          // if($model->save()) {
          //   echo '<pre>';
          //   print_r($model->attributes);
          //   echo '</pre>';
          // } else {
          //   echo '<pre>';
          //   print_r($model->errors);
          //   echo '</pre>';
          // }
      }
      return true;
  }
}
