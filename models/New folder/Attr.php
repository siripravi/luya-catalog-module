<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Attr.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property string $name
 * @property string $after
 * @property integer $position
 * @property tinyint $enabled
 */
class Attr extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_attr';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-attr';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'after' => Yii::t('app', 'After'),
            'position' => Yii::t('app', 'Position'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['position', 'enabled'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['after'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'after' => 'text',
            'position' => 'number',
            'enabled' => 'number',
            'values' => ['selectModel', 'modelClass' => AttrValue::class, 'valueField' => 'id', 'labelField' => 'name'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['name', 'after', 'position', 'enabled']],
            [['create', 'update'], ['name', 'after', 'position', 'enabled']],
            ['delete', false],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGRoups()
    {
		
        return $this->hasMany(Group::class, ['id' => 'group_id'])->viaTable('catalog_attr_group_ref', ['attr_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Set::class, ['attr_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        // TODO: value_id != feature_id
        return $this->hasMany(Article::class, ['id' => 'article_id'])->viaTable('catalog_article_value', ['value_id' => 'id']);
    }


    public function search($params)
    {
        $query = Attr::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
        ]);

     /*   if ($this->all) {
            $dataProvider->pagination = false;
        }*/

        $this->load($params);

        if ($this->group_id) {
            $query->joinWith(['groups']);
        }

       /* if ($this->name) {
            $query->joinWith(['translations']);
        }*/

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'position' => $this->position,
            'enabled' => $this->enabled,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'feature_lang.name', $this->name]);

        return $dataProvider;
    }
}
