<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DataSubkriteria;

/**
 * DataSubkriteriaSearch represents the model behind the search form of `common\models\DataSubkriteria`.
 */
class DataSubkriteriaSearch extends DataSubkriteria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_kriteria', 'nama_subkriteria'], 'safe'],
            [['jumlah_subkriteria', 'bobot_subkriteria'], 'number'],
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
        $query = DataSubkriteria::find();

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
            'jumlah_subkriteria' => $this->jumlah_subkriteria,
            'bobot_subkriteria' => $this->bobot_subkriteria,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'id_kriteria', $this->id_kriteria])
            ->andFilterWhere(['like', 'nama_subkriteria', $this->nama_subkriteria]);

        return $dataProvider;
    }
}
