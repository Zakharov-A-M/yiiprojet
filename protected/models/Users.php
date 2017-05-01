<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 *
 * The followings are the available model relations:
 * @property News[] $news
 */
class Users extends CActiveRecord
{

    public $username;
    public $password;
    public $auth_key;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}




	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username, password','required'),
            array('password', 'authenticates', 'on' => 'authenticate'),
            array('password', 'dublicate', 'on' => 'dublicate'),
			array('username, password, auth_key', 'length', 'max'=>255),
			array('id, username, password', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Валидация проверки логина и пароля в бд при авторизации
     * @param $attribute string - атрибут поля
     * @param $params string - параметр ошибки
     */
        public function authenticates($attribute,$params){
            if(!$this->hasErrors()) {
                if(!$this->login())
                    $this->addError('password','Incorrect username or password.');
            }
        }

    /**
     * Валидация проверки логина и пароля в бд при регистрации
     * @param $attribute string - атрибут поля
     * @param $params string - параметр ошибки
     */
         public function dublicate($attribute,$params){
             if (!$this->hasErrors()) {
                 if (!$this->Dublicate_user())
                     $this->addError('password', 'User exists in the database.');
             }
         }

    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'news' => array(self::HAS_MANY, 'News', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * метод для получения пользователя с бд
     * @return bool
     */
	public  function login(){
        $user = new CDbCriteria;
        //$user->select = 'password';
        $user->condition = 'username=:username';
        $user->params = array(':username'=>$this->username);
        $posts = Users::model()->find($user);
        //$posts = Users::model()->findByPk(21);
        if($posts->password == $this->HashPassword($this->password)){
            Yii::app()->session->add("id", $posts->id);
            Yii::app()->session->add("username", $posts->username);
            return true;
        }
        return false;
    }

    /**
     * метод добавление пользователя в бд
     * @return bool  - успешное сохрание (true)
     */
    public  function Dublicate_user(){
        $user = new CDbCriteria;
        $user->select='username';
        $user->condition='username=:username';
        $user->params=array(':username'=>$this->username);
        $posts = Users::model()->find($user);
        if($posts == null){
            $model = new Users();
            $model->username = $this->username;
            $model->password = $this->HashPassword($this->password);
            $model->auth_key = $this->generateAuthKey();
            if($model->save()) {
                $user = new CDbCriteria;
              //  $user->select='username';
                $user->condition='username=:username';
                $user->params=array(':username'=>$this->username);
                $posts = Users::model()->find($user);
                Yii::app()->session->add("id", $posts->id);
                Yii::app()->session->add("username", $posts->username);
                $auth=Yii::app()->authManager;
                $auth->assign('user', strval(Yii::app()->session->get("id")));
                return true;
            }
        }
        return false;
    }

    /**
     * Хеширование пароля
     * @param $password string
     * @return string
     */
    public function HashPassword($password){
	     return  hash('sha256',$password);
    }

    /**
     * @param $role string имя операции
     * @return bool
     */
    public function checkAccess($role)
    {
        $user = new CDbCriteria;
        $user->condition='userid=:userid';
        $user->params=array(':userid'=>strval(Yii::app()->session->get("id")));
        $model = AuthAssigment::model()->find($user);
        $action = AuthItemChild::model()->findByAttributes(array('parent' => $model->itemname, 'child' => $role));
        if($action != null && $model != null){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Генерирует token пользователя
     * @return string
     */
    private function generateAuthKey(){
        return  md5(uniqid(rand(),1));
    }

    /**
     * Получение token пользователя при авторизации в api
     * @return string auth_key
     * @return null
     */
    public  function getToken(){
        $user = new CDbCriteria;
        $user->condition = 'username=:username';
        $user->params = array(':username'=>$this->username);
        $posts = Users::model()->find($user);
        if($posts->password == $this->HashPassword($this->password)){
            return $posts->auth_key;
        }
        return null;
    }

    /**
     * мотод определяет если ли пользователь с таким то token
     * @return bool
     */
    public function getRule(){
        $auth_key  = new CDbCriteria;
        $auth_key ->condition = 'auth_key=:auth_key';
        $auth_key ->params = array(':auth_key'=>$this->auth_key);
        $count = Users::model()->count($auth_key);
        if($count > 0){
            return true;
        }
        return false;
    }


    public function getUser(){
        $auth_key  = new CDbCriteria;
        $auth_key ->condition = 'auth_key=:auth_key';
        $auth_key ->params = array(':auth_key'=>$this->auth_key);
        $model = Users::model()->find($auth_key);
        return $model->id;
    }



}
