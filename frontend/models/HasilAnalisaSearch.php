<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HasilAnalisa;

/**
 * HasilAnalisaSearch represents the model behind the search form of `common\models\HasilAnalisa`.
 */
class HasilAnalisaSearch extends HasilAnalisa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['id_alternatif'], 'integer'],
            [['Si', 'Ri', 'Qi', 'Qii', 'Qiii'], 'number'],
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
        $query = HasilAnalisa::find();

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
            'id_alternatif' => $this->id_alternatif,
            'Si' => $this->Si,
            'Ri' => $this->Ri,
            'Qi' => $this->Qi,
            'Qii' => $this->Qii,
            'Qiii' => $this->Qiii,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id]);

        return $dataProvider;
    }
}
