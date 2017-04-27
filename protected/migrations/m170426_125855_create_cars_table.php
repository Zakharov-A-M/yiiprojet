<?php

class m170426_125855_create_cars_table extends CDbMigration
{
	public function up()
	{
        $transaction=$this->getDbConnection()->beginTransaction();

        try
        {
            $this->createTable('cars', array(
                'id' => 'pk',
                'id_user' => 'integer NOT NULL',
                'brand' => 'string NOT NULL',
                'number' => 'string NOT NULL',
                'cost' => 'double NOT NULL',
            ));
            $this->createIndex(
                'idx-post-id_user',
                'cars',
                'id_user'
            );
            $this->addForeignKey(
                'fk-post-id_user',
                'cars',
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
        $this->dropTable('cars');
		echo "m170426_125855_create_cars_table does not support migration down.\n";
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