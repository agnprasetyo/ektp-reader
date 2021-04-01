<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\KonversiNilai;

/**
 * KonversiNilaiSearch represents the model behind the search form of `common\models\KonversiNilai`.
 */
class KonversiNilaiSearch extends KonversiNilai
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama_kriteria', 'nilai_awal'], 'safe'],
            [['nilai_konversi'], 'number'],
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
        $query = KonversiNilai::find();

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
            'id' => $this->id,
            'nilai_konversi' => $this->nilai_konversi,
        ]);

        $query->andFilterWhere(['like', 'nama_kriteria', $this->nama_kriteria])
            ->andFilterWhere(['like', 'nilai_awal', $this->nilai_awal]);

        return $dataProvider;
    }
}
