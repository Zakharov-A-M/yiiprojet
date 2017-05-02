<?php

class UsersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
	    $status = new Status();
        if($status->StatusDate()) {
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if (!Yii::app()->roles->checkAccess('Create')) {
            return $this->redirect(array('site/roles'));
        }
		$model = new Users;
        $status = new Status();
        if($status->StatusDate()) {
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
                $model->password = $model->HashPassword($model->password);
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
            }
            $this->render('create', array(
                'model' => $model,
            ));
        }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        if (!Yii::app()->roles->checkAccess('Update')) {
            return $this->redirect(array('site/roles'));
        }
        $status = new Status();
        if($status->StatusDate()) {
            $model = $this->loadModel($id);
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
                Yii::app()->session->add("username", $model->username);
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
            }
            $this->render('update', array(
                'model' => $model,
            ));
        }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if (!Yii::app()->roles->checkAccess('Delete')) {
            return $this->redirect(array('site/roles'));
        }
        $status = new Status();
        if($status->StatusDate()) {
            if (Yii::app()->session->get("id") == $id) {
                unset(Yii::app()->session["id"]);
                $this->loadModel($id)->delete();
                return $this->redirect(Yii::$app->urlManager->createUrl('site/login'));
            }
            $this->loadModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $dataProvider = new CActiveDataProvider('Users');
            $this->render('index', array(
                'dataProvider' => $dataProvider,
            ));
	}


    public function actionOnline()
    {

        $model = Users::model()->findAll();
        $this->render('online', array(
            'model' => $model,
        ));
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    protected function beforeAction($action)
    {
        $status = new Status();
        if($status->StatusDate()) {
            return parent::beforeAction($action);
        }
    }



}
