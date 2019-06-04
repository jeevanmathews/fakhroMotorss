<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Branches;

/**
 * BranchesSearch represents the model behind the search form of `backend\models\Branches`.
 */
class BranchesSearch extends Branches
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'country_id', 'status'], 'integer'],
            [['name', 'code', 'mailing_name', 'address', 'state', 'zipcode', 'phone', 'email', 'fax', 'website', 'cr_number', 'cr_expiry', 'vat_number', 'vat_expiry', 'branchtype_id', 'created_at'], 'safe'],
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
        $query = Branches::find();

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
            'company_id' => $this->company_id,
            'country_id' => $this->country_id,
            'cr_expiry' => $this->cr_expiry,
            'vat_expiry' => $this->vat_expiry,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'mailing_name', $this->mailing_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'cr_number', $this->cr_number])
            ->andFilterWhere(['like', 'vat_number', $this->vat_number])
            ->andFilterWhere(['like', 'branchtype_id', $this->branchtype_id]);

        return $dataProvider;
    }
}
