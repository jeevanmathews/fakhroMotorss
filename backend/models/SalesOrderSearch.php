<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SalesOrder;

/**
 * SalesOrderSearch represents the model behind the search form of `backend\models\SalesOrder`.
 */
class SalesOrderSearch extends SalesOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'qtn_id', 'so_created_by', 'customer_id', 'status'], 'integer'],
            [['so_number', 'so_date', 'so_expected_date', 'subtotal', 'total_tax', 'grand_total'], 'safe'],
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
        $query = SalesOrder::find();

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
            'qtn_id' => $this->qtn_id,
            'so_date' => $this->so_date,
            'so_created_by' => $this->so_created_by,
            'customer_id' => $this->customer_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'so_number', $this->so_number])
            ->andFilterWhere(['like', 'so_expected_date', $this->so_expected_date])
            ->andFilterWhere(['like', 'subtotal', $this->subtotal])
            ->andFilterWhere(['like', 'total_tax', $this->total_tax])
            ->andFilterWhere(['like', 'grand_total', $this->grand_total]);

        return $dataProvider;
    }
}
