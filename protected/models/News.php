<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property integer $id_user
 * @property string $post
 *
 * The followings are the available model relations:
 * @property Users $idUser
 */
class News extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, post', 'required'),
			array('id_user', 'numerical', 'integerOnly'=>true),
			array('post', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, post', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idUser' => array(self::BELONGS_TO, 'Users', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id Автора',
			'post' => 'Новость',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('post',$this->post,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Удаление новсти
     * @return bool
     */
    public function DeleteNews()
    {
        $model = News::model()->findByPk($this->id);
        if($model->id_user == $this->id_user){
            if($model->delete()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    /**
     * метод редактирование новости
     * @return bool
     */
    public function UpdateNews(){
        $model = News::model()->findByPk($this->id);
        if($model->id_user == $this->id_user){
            $model->post = $this->post;
            if($model->save()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

}
