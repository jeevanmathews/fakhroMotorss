<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\JobcardVehicle;

/**
 * JobcardVehicleSearch represents the model behind the search form of `backend\models\JobcardVehicle`.
 */
class JobcardVehicleSearch extends JobcardVehicle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'amc_type', 'extended_warranty_type', 'make_id', 'model_id', 'ew_expiry_kms'], 'integer'],
            [['reg_num', 'chasis_num', 'color', 'tr_number', 'amc_expiry_date', 'ew_expiry_date', 'service_schedule'], 'safe'],
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
        $query = JobcardVehicle::find();

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
            'amc_type' => $this->amc_type,
            'extended_warranty_type' => $this->extended_warranty_type,
            'ew_expiry_kms' => $this->ew_expiry_kms,
            'make_id' => $this->make_id,
            'model_id' => $this->model_id
        ]);

        $query->andFilterWhere(['like', 'reg_num', $this->reg_num])
            ->andFilterWhere(['like', 'chasis_num', $this->chasis_num])           
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'tr_number', $this->tr_number])
            ->andFilterWhere(['like', 'amc_expiry_date', $this->amc_expiry_date])
            ->andFilterWhere(['like', 'ew_expiry_date', $this->ew_expiry_date])
            ->andFilterWhere(['like', 'service_schedule', $this->service_schedule]);

        return $dataProvider;
    }
}
