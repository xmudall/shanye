<?php
class Contact extends ApplicationModel
{
    static $dao;

    public static function getDao() {
        if ( !isset(self::$dao) ) {
            self::$dao = new Contact();
        }
        return self::$dao;
    }
}
