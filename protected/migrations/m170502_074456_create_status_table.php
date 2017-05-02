<?php

class m170502_074456_create_status_table extends CDbMigration
{
	public function up()
	{
        $transaction=$this->getDbConnection()->beginTransaction();
        try
        {
            $this->createTable('status', array(
                'id' => 'pk',
                'id_user' => 'integer NOT NULL',
                'date' => 'datetime NOT NULL',
            ));
            $this->createIndex(
                'idx-post-id_status',
                'status',
                'id_user'
            );
            $this->addForeignKey(
                'fk-post-id_status',
                'status',
                'id_user',
                'users',
                'id',
                'CASCADE'
            );
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
		echo "m170502_074456_create_status_table does not support migration down.\n";
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