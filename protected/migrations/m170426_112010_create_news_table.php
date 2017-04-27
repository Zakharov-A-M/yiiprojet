<?php

class m170426_112010_create_news_table extends CDbMigration
{
	public function up()
	{
        $transaction=$this->getDbConnection()->beginTransaction();

        try
        {
            $this->createTable('news', array(
                'id' => 'pk',
                'id_user' => 'integer NOT NULL',
                'post' => 'string NOT NULL',
            ));
            $this->createIndex(
                'idx-post-id_user',
                'news',
                'id_user'
            );
            $this->addForeignKey(
                'fk-post-id_user',
                'news',
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
        $this->dropTable('news');
		echo "m170426_112010_create_news_table does not support migration down.\n";
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