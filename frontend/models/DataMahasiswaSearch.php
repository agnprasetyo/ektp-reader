<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DataMahasiswa;

/**
 * DataMahasiswaSearch represents the model behind the search form of `common\models\DataMahasiswa`.
 */
class DataMahasiswaSearch extends DataMahasiswa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nama', 'alamat', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'status', 'pekerjaan', 'berlaku_hingga', 'nim', 'jenjang', 'jurusan', 'fakultas', 'status_mhs'], 'safe'],
            [['nik'], 'integer'],
            [['qi'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DataMahasiswa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'nik' => $this->nik,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'jenis_kelamin', $this->jenis_kelamin])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'tanggal_lahir', $this->tanggal_lahir])
            ->andFilterWhere(['like', 'agama', $this->agama])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
            ->andFilterWhere(['like', 'berlaku_hingga', $this->berlaku_hingga])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'jenjang', $this->jenjang])
            ->andFilterWhere(['like', 'jurusan', $this->jurusan])
            ->andFilterWhere(['like', 'fakultas', $this->fakultas])
            ->andFilterWhere(['like', 'status_mhs', $this->status_mhs])
            ->andFilterWhere(['like', 'qi', $this->qi]);

        return $dataProvider;
    }
}
