<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurchaseReturn;

/**
 * PurchaseReturnSearch represents the model behind the search form of `backend\models\PurchaseReturn`.
 */
class PurchaseReturnSearch extends PurchaseReturn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'grn_id', 'inv_id', 'prefix_id', 'prtn_created_by', 'supplier_id', 'status'], 'integer'],
            [['prtn_number', 'prtn_created_date', 'prtn_date', 'discount_type', 'process_status'], 'safe'],
            [['subtotal', 'discount', 'discount_percent', 'vat_percent', 'total_tax', 'grand_total'], 'number'],
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
        $query = PurchaseReturn::find();

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
            'grn_id' => $this->grn_id,
            'inv_id' => $this->inv_id,
            'prefix_id' => $this->prefix_id,
            'prtn_created_date' => $this->prtn_created_date,
            'prtn_created_by' => $this->prtn_created_by,
            'supplier_id' => $this->supplier_id,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'discount_percent' => $this->discount_percent,
            'vat_percent' => $this->vat_percent,
            'total_tax' => $this->total_tax,
            'grand_total' => $this->grand_total,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'prtn_number', $this->prtn_number])
            ->andFilterWhere(['like', 'prtn_date', $this->prtn_date])
            ->andFilterWhere(['like', 'discount_type', $this->discount_type])
            ->andFilterWhere(['like', 'process_status', $this->process_status]);

        return $dataProvider;
    }
}
