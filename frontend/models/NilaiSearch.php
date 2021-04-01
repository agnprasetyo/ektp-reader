<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Nilai;

/**
 * NilaiSearch represents the model behind the search form of `common\models\Nilai`.
 */
class NilaiSearch extends Nilai
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nilai'], 'integer'],
            [['jum_nilai'], 'number'],
            [['ket_nilai'], 'safe'],
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
        $query = Nilai::find();

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
            'id_nilai' => $this->id_nilai,
            'jum_nilai' => $this->jum_nilai,
        ]);

        $query->andFilterWhere(['like', 'ket_nilai', $this->ket_nilai]);

        return $dataProvider;
    }
}
