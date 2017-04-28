<?php

class m170428_080958_create_AuthItem_table extends CDbMigration
{
	public function up()
	{
        $transaction=$this->getDbConnection()->beginTransaction();
        try
        {
            $this->createTable('AuthItem', array(
                'name' => 'string NOT NULL',
                'type' => 'string NOT NULL',
                'description' => 'string NOT NULL',
                'bizrule' => 'string',
                'data' => 'string NOT NULL',
            ));
            $transaction->commit();
        }
        catch(Exception $e)
        {
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollback();
            return false;
        }

	}

	public function down()
	{
		echo "m170428_080958_create_AuthItem_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}