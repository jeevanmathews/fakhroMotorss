<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Purchaseorder;

/**
 * PurchaseorderSearch represents the model behind the search form of `backend\models\Purchaseorder`.
 */
class PurchaseorderSearch extends Purchaseorder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pr_id', 'po_created_by', 'status'], 'integer'],
            [['po_number', 'po_date', 'po_expected_date', 'subtotal', 'total_tax', 'grand_total','process_status'], 'safe'],
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
        $query = Purchaseorder::find();

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
            'pr_id' => $this->pr_id,
            'po_date' => $this->po_date,
            'po_created_by' => $this->po_created_by,
            'status' => $this->status,
            'process_status' => $this->process_status,
        ]);

        $query->andFilterWhere(['like', 'po_number', $this->po_number])
            ->andFilterWhere(['like', 'po_expected_date', $this->po_expected_date])
            ->andFilterWhere(['like', 'subtotal', $this->subtotal])
            ->andFilterWhere(['like', 'total_tax', $this->total_tax])
            ->andFilterWhere(['like', 'grand_total', $this->grand_total]);

        return $dataProvider;
    }
}
