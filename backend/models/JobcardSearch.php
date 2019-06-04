<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Jobcard;

/**
 * JobcardSearch represents the model behind the search form of `backend\models\Jobcard`.
 */
class JobcardSearch extends Jobcard
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_manager', 'service_advisor', 'customer_id'], 'integer'],
            [['id', 'created_date', 'promised_date', 'receipt_num'], 'safe'],
            [['advance_paid', 'labour_cost', 'material_cost', 'tax', 'total_charge'], 'number'],
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
        $query = Jobcard::find();

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
            'created_date' => $this->created_date,
            'advance_paid' => $this->advance_paid,
            'service_manager' => $this->service_manager,
            'service_advisor' => $this->service_advisor,
            'labour_cost' => $this->labour_cost,
            'material_cost' => $this->material_cost,
            'tax' => $this->tax,
            'total_charge' => $this->total_charge,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'promised_date', $this->promised_date])
            ->andFilterWhere(['like', 'receipt_num', $this->receipt_num]);

        return $dataProvider;
    }
}
