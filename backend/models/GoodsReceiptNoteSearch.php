<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GoodsReceiptNote;

/**
 * GoodsReceiptNoteSearch represents the model behind the search form of `backend\models\GoodsReceiptNote`.
 */
class GoodsReceiptNoteSearch extends GoodsReceiptNote
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'po_id', 'grn_created_by', 'supplier_id', 'status'], 'integer'],
            [['grn_number', 'grn_created_date', 'grn_date', 'subtotal', 'total_tax', 'grand_total'], 'safe'],
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
        $query = GoodsReceiptNote::find();

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
            'po_id' => $this->po_id,
            'grn_created_date' => $this->grn_created_date,
            'grn_created_by' => $this->grn_created_by,
            'supplier_id' => $this->supplier_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'grn_number', $this->grn_number])
            ->andFilterWhere(['like', 'grn_date', $this->grn_date])
            ->andFilterWhere(['like', 'subtotal', $this->subtotal])
            ->andFilterWhere(['like', 'total_tax', $this->total_tax])
            ->andFilterWhere(['like', 'grand_total', $this->grand_total]);

        return $dataProvider;
    }
}
