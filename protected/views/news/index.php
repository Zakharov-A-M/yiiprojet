<?php
/* @var $this NewsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'News',
);

$this->menu=array(
	array('label'=>'Create News', 'url'=>array('create')),
	array('label'=>'Manage News', 'url'=>array('admin')),
);
?>

<h1>News</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'id',
        'id_user',
        'post',
        array(
            'class'=>'CButtonColumn',
        ),
    ),

)); ?>