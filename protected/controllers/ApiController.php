<?php


class ApiController extends Controller
{


    public function filters()
    {
        return array();
    }

    /**
     * метод для авторизации, получение токена пользователя
     * @return string $result :success
     * @return bool
     */
    public function actionSing()
    {
        /*$model = News::model()->findAll();
        echo json_encode($model);*/
        $model = new Users();
        $model->username = Yii::app()->request->getPost('username');
        $model->password = Yii::app()->request->getPost('password');
        $result = $model->getToken();
        if($result != null){
            echo 'auth_key = '. $result;
            return true;
        }
        echo "Don't login in my api!";
        return false;
    }

    /**
     * view all news
     */
    public function actionView()
    {
        $model = new Users();
        $model->auth_key = Yii::app()->request->getPost('auth_key');
        if($model->getRule()){
            $model = News::model()->findAll();
            echo CJSON::encode($model);
        }else  echo "Новостей нету";

    }


    /**
     * Create new news
     */
    public function actionCreate()
    {
        $model = new Users();
        $model->auth_key = Yii::app()->request->getPost('auth_key');
        if($model->getRule()){
            $news = new News();
            $news->id_user = (int)$model->getUser();
            $news->post = Yii::app()->request->getPost('post');
            if($news->save()){
                echo 'News save in BD!';
            }else{
                echo 'Dont save news';
            }
        }else  echo "Новостей нету";
    }

    /**
     * Delete news
     */
    public function actionDelete()
    {
        $model = new Users();
        $model->auth_key = Yii::app()->request->getPost('auth_key');
        if($model->getRule()){
            $news = new News();
            $news->id_user = (int)$model->getUser();
            $news->id = (int)Yii::app()->request->getPost('id_post');
            if($news->DeleteNews()){
                echo "News DELETE!";
            }else{
                echo "This news has been in BD!";
            }
        }else  echo "Новостей нету";
    }


    /**
     * Update news
     */
    public function actionUpdate()
    {
        $model = new Users();
        $model->auth_key = Yii::app()->request->getPost('auth_key');
        if($model->getRule()){
            $news = new News();
            $news->id_user = (int)$model->getUser();
            $news->id = (int)Yii::app()->request->getPost('id_post');
            $news->post = Yii::app()->request->getPost('post');
            if($news->UpdateNews()){
                echo "News Update!";
            }else{
                echo "This news has been in BD!";
            }
        }else  echo "Новостей нету";
    }




}