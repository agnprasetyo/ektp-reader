<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DataKriteria;

/**
 * DataKriteriaSearch represents the model behind the search form of `common\models\DataKriteria`.
 */
class DataKriteriaSearch extends DataKriteria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kriteria', 'nama_kriteria'], 'safe'],
            [['jumlah_kriteria', 'bobot_kriteria'], 'number'],
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
        $query = DataKriteria::find();

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
            'jumlah_kriteria' => $this->jumlah_kriteria,
            'bobot_kriteria' => $this->bobot_kriteria,
        ]);

        $query->andFilterWhere(['like', 'id_kriteria', $this->id_kriteria])
            ->andFilterWhere(['like', 'nama_kriteria', $this->nama_kriteria]);

        return $dataProvider;
    }
}
