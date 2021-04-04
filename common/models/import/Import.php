<?php

namespace common\models\import;
use common\models\AnalisaAlternatif;
use common\models\DataKriteria;
use common\models\KonversiNilai;

use Yii;

class Import extends \yii\base\Model
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
      $listidkriteria = [];
      $konversi = [];

      foreach($attr as $key => $value) {
        $datakriteria = DataKriteria::find()
                      ->where(['nama_kriteria' => trim($value) ])
                      ->one();

        if ($datakriteria != null) {
          echo $value . '<br>';
          $listidkriteria[$value] = $datakriteria->id_kriteria;
        } else {
          unset($attr[$key]);
        }
      }

      $attr = array_values($attr);
      foreach($listData as $data) {
        for($i = 0; $i < count($attr); $i++) {
          $nama_kriteria = $attr[$i];
          $nilai_kriteria = $data[$nama_kriteria];


          // print_r($nama_kriteria);exit;

          if( !isset( $konversi[$nama_kriteria][$nilai_kriteria] ) ) {
            $datakonversi = KonversiNilai::find()
                          ->where([
                            'nama_kriteria' => $nama_kriteria,
                            'nilai_awal' => $data[$nama_kriteria],
                          ])
                          ->asArray()
                          ->one();

            if(!empty($datakonversi)) {
              $konversi[$nama_kriteria][$nilai_kriteria] = $datakonversi['nilai_konversi'];
            }
          }

          $searchdata = AnalisaAlternatif::findOne([
            'id_alternatif' => $data['id_mahasiswa'],
            'id_kriteria' => $listidkriteria[$nama_kriteria]
          ]);

          if ($searchdata == null) {
            $model = new AnalisaAlternatif;

            $model->id_alternatif = $data['id_mahasiswa'];
            $model->id_kriteria = $listidkriteria[$nama_kriteria];
            if(isset($konversi[$nama_kriteria][$nilai_kriteria])) {
              $model->nilai = $konversi[$nama_kriteria][$nilai_kriteria];
            } else {
              $model->nilai = null;
            }
            $model->bobot = 0;
            $model->normalisasi = 0;
            $model->save();
          } else {
            $searchdata->updateAttributes([
              'nilai' => $konversi[$nama_kriteria][$nilai_kriteria],
              'bobot' => 0,
              'normalisasi' => 0
            ]);
          }



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
