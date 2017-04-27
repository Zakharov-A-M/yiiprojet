<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Users</h1>

<?php/* $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
'dataProvider'=>$dataProvider,
    'columns'=>array(
        'id',
        'username',
        'password',
        array(
            'class'=>'CButtonColumn',
        ),
    ),

)); ?>
