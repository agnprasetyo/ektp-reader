<?php

namespace common\models\import;
use common\models\KonversiNilai;
use yii\web\UploadedFile;
use DataReader\CSV\Reader;

use Yii;

class KonversiNilaiImport extends \yii\base\Model
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

      foreach($listData as $data) {

        $model = new KonversiNilai;
        $model->nama_kriteria = $data['kriteria'];
        $model->nilai_awal = $data['status'];
        $model->nilai_konversi = $data['skor'];
        $model->save();

      }
      return true;
  }
}
