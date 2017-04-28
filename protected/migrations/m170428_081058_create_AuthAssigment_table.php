<?php

class m170428_081058_create_AuthAssigment_table extends CDbMigration
{
	public function up()
	{
        $transaction=$this->getDbConnection()->beginTransaction();
        try
        {
            $this->createTable('AuthAssigment', array(
                'itemname' => 'string NOT NULL',
                'user_id' => 'int NOT NULL',
                'bizrule' => 'string NOT NULL',
                'data' => 'string NOT NULL',
            ));
            $this->createIndex(
                'idx-post-user_id_auth',
                'AuthAssigment',
                'user_id'
            );
            $this->addForeignKey(
                'fk-post-user_id_auth',
                'AuthAssigment',
                'user_id',
                'users',
                'id',
                'CASCADE',
                'CASCADE'
            );

            $this->addPrimaryKey(
                'item_pk',
                'AuthAssigment',
                'itemname');


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
		echo "m170428_081058_create_AuthAssigment_table does not support migration down.\n";
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