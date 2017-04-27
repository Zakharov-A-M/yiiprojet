<?php
/* @var $this SiteController */
/* @var $model Users */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - registration';
$this->breadcrumbs=array(
    'Login',
);
?>

<h1>Registration</h1>
<?php echo  Yii::app()->session['id']; ?>
<p>Please create account in my!</p>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
        <p class="hint">
            Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
        </p>
    </div>



    <div class="row buttons">
        <?php echo CHtml::submitButton('Registration'); ?>
    </div>

    <?php $this->endWidget(); ?>


</div><!-- form -->