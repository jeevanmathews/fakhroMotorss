<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Spareparts;

/**
 * SparepartsSearch represents the model behind the search form of `backend\models\Spareparts`.
 */
class SparepartsSearch extends Spareparts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'spare_type_id', 'item_type_id', 'status'], 'integer'],
            [['name', 'code', 'description', 'created_date'], 'safe'],
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
        $query = Spareparts::find();

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
            'spare_type_id' => $this->spare_type_id,
            'item_type_id' => $this->item_type_id,
            'created_date' => $this->created_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
