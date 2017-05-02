<?php

/**
 * This is the model class for table "status".
 *
 * The followings are the available columns in table 'status':
 * @property integer $id
 * @property integer $id_user
 * @property string $date
 * The followings are the available model relations:
 * @property Users $idUser
 */
class Status extends CActiveRecord
{
    public $date;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, date', 'required'),
			array('id_user', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, date', 'safe', 'on'=>'search'),
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
			'id_user' => 'Id User',
			'date' => 'Date',
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
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Status the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Сохранение в бд времени посещения пользователя
     * @return bool
     */
	public  function  StatusDate(){
        $user = new CDbCriteria;
        $user->condition='id_user=:id_user';
        $user->params=array(':id_user'=>(int)(Yii::app()->session->get("id")));
        $model = Status::model()->find($user);
        if($model == null){
            $model = new Status();
            $model->id_user =  (int)(Yii::app()->session->get("id"));
            $model->date = $this->getDate();
        }else{
            $model->date = $this->getDate();
        }
        if($model->save()){
            return true;
        }
        return false;
    }

    /**
     * Получение текущей даты
     * @return string
     */
    public function getDate()
    {
        $date = new DateTime();
        $current =  $date->modify('+1 hour');
        return  $current->format('Y-m-d H:i:s');
       // return $date;
    }

    public static function Comparison($date){
        $date = new DateTime($date);
        $date1 = new DateTime();
        $date1 =  $date1->modify('+1 hour');
        $date1 =  $date1->modify('-15 minutes');
        if($date < $date1){
            return 'offline';
        }
        else return 'online';
    }

}
