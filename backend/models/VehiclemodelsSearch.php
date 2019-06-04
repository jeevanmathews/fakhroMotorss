<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Vehiclemodels;

/**
 * VehiclemodelsSearch represents the model behind the search form of `backend\models\Vehiclemodels`.
 */
class VehiclemodelsSearch extends Vehiclemodels
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'manufacturer_id', 'status'], 'integer'],
            [['name', 'created_date', 'type_id'], 'safe'],
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
        $query = Vehiclemodels::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);//print_r($params);exit;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'manufacturer_id' => $this->manufacturer_id,
            'type_id' => $this->type_id,
            'created_date' => $this->created_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
