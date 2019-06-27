<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Quotation;

/**
 * QuotationSearch represents the model behind the search form of `backend\models\Quotation`.
 */
class QuotationSearch extends Quotation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'requested_by', 'customer_id', 'status'], 'integer'],
            [['qtn_number', 'request_date', 'expected_date', 'subtotal', 'total_tax', 'grand_total'], 'safe'],
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
        $query = Quotation::find();

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
            'requested_by' => $this->requested_by,
            'customer_id' => $this->customer_id,
            'request_date' => $this->request_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'qtn_number', $this->qtn_number])
            ->andFilterWhere(['like', 'expected_date', $this->expected_date])
            ->andFilterWhere(['like', 'subtotal', $this->subtotal])
            ->andFilterWhere(['like', 'total_tax', $this->total_tax])
            ->andFilterWhere(['like', 'grand_total', $this->grand_total]);

        return $dataProvider;
    }
}
