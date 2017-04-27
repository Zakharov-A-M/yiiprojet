<?php
/* @var $this CarsController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'Cars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cars', 'url'=>array('index')),
	array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h1>Create Cars</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>