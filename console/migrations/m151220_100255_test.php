<?php

use yii\db\Schema;
use yii\db\Migration;

class m151220_100255_test extends Migration
{
    private $create_procedure = <<< SQL
        CREATE OR REPLACE FUNCTION add_to_log() RETURNS TRIGGER AS $$
        DECLARE
            mstr varchar(30);
            astr varchar(100);
            retstr varchar(254);
        BEGIN
            IF    TG_OP = 'INSERT' THEN
                astr = NEW.name;
                mstr := 'Add new user ';
                retstr := mstr || astr;
                INSERT INTO school_log(action,created_at) values (retstr,NOW());
                RETURN NEW;
            ELSIF TG_OP = 'UPDATE' THEN
                astr = NEW.name;
                mstr := 'Update user ';
                retstr := mstr || astr;
                INSERT INTO school_log(action,created_at) values (retstr,NOW());
                RETURN NEW;
            ELSIF TG_OP = 'DELETE' THEN
                astr = OLD.name;
                mstr := 'Remove user ';
                retstr := mstr || astr;
                INSERT INTO school_log(action,created_at) values (retstr,NOW());
                RETURN OLD;
            END IF;
        END;
        $$ LANGUAGE plpgsql;
SQL;

    private $delete_procedure = <<< SQL
      DROP FUNCTION IF EXISTS add_to_log() CASCADE;
SQL;

    private $create_trigger = <<< SQL
        CREATE TRIGGER t_user
        AFTER INSERT OR UPDATE OR DELETE ON school_user FOR EACH ROW EXECUTE PROCEDURE add_to_log ();
SQL;

    private $drop_trigger = <<< SQL
      DROP TRIGGER IF EXISTS t_user ON school_user CASCADE;
SQL;

    public function safeUp()
    {
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'action' => $this->text(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->execute($this->create_procedure);
        $this->execute($this->create_trigger);

    }

    public function safeDown()
    {
        $this->dropTable('{{%log}}');
        $this->execute($this->drop_trigger);
        $this->execute($this->delete_procedure);
    }
}
