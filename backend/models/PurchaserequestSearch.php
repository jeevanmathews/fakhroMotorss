<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Purchaserequest;

/**
 * PurchaserequestSearch represents the model behind the search form of `backend\models\Purchaserequest`.
 */
class PurchaserequestSearch extends Purchaserequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'requested_by', 'supplier_id', 'status'], 'integer'],
            [['pr_number', 'request_date', 'expected_date'], 'safe'],
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
        $query = Purchaserequest::find();

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
            'supplier_id' => $this->supplier_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'pr_number', $this->pr_number])
            ->andFilterWhere(['like', 'request_date', $this->request_date])
            ->andFilterWhere(['like', 'expected_date', $this->expected_date]);

        return $dataProvider;
    }
}
