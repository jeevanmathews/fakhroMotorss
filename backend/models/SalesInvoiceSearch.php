<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SalesInvoice;

/**
 * SalesInvoiceSearch represents the model behind the search form of `backend\models\SalesInvoice`.
 */
class SalesInvoiceSearch extends SalesInvoice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'do_id', 'inv_created_by', 'customer_id', 'status'], 'integer'],
            [['inv_number', 'inv_created_date', 'inv_date'], 'safe'],
            [['subtotal', 'discount', 'total_tax', 'grand_total'], 'number'],
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
        $query = SalesInvoice::find();

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
            'do_id' => $this->do_id,
            'inv_created_date' => $this->inv_created_date,
            'inv_created_by' => $this->inv_created_by,
            'customer_id' => $this->customer_id,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'total_tax' => $this->total_tax,
            'grand_total' => $this->grand_total,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'inv_number', $this->inv_number])
            ->andFilterWhere(['like', 'inv_date', $this->inv_date]);

        return $dataProvider;
    }
}
