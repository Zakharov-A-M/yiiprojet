<?php

class m170428_084305_create_AuthItemChild_table extends CDbMigration
{
	public function up()
	{
        $transaction=$this->getDbConnection()->beginTransaction();
        try
        {
            $this->createTable('AuthItemChild', array(
                'parent' => 'string NOT NULL',
                'child' => 'string NOT NULL',

            ));
            $this->createIndex(
                'idx-post-parent_auth',
                'AuthItemChild',
                'parent'
            );
            $this->addForeignKey(
                'fk-post-user_id_auth',
                'AuthItemChild',
                'parent',
                'AuthItem',
                'name',
                'CASCADE',
                'CASCADE'
            );

            $this->addPrimaryKey(
                'parent_pk',
                'AuthItemChild',
                'parent');


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
		echo "m170428_084305_create_AuthItemChild_table does not support migration down.\n";
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