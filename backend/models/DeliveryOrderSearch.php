<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DeliveryOrder;

/**
 * DeliveryOrderSearch represents the model behind the search form of `backend\models\DeliveryOrder`.
 */
class DeliveryOrderSearch extends DeliveryOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'so_id', 'do_created_by', 'customer_id', 'status'], 'integer'],
            [['do_number', 'do_created_date', 'do_date', 'subtotal', 'total_tax', 'grand_total'], 'safe'],
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
        $query = DeliveryOrder::find();

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
            'so_id' => $this->so_id,
            'do_created_date' => $this->do_created_date,
            'do_created_by' => $this->do_created_by,
            'customer_id' => $this->customer_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'do_number', $this->do_number])
            ->andFilterWhere(['like', 'do_date', $this->do_date])
            ->andFilterWhere(['like', 'subtotal', $this->subtotal])
            ->andFilterWhere(['like', 'total_tax', $this->total_tax])
            ->andFilterWhere(['like', 'grand_total', $this->grand_total]);

        return $dataProvider;
    }
}
