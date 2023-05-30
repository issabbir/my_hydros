<?php
/**
 * Created by PhpStorm.
 * User: MOU
 * Date: 28-Jun-20
 * Time: 8:45 PM
 */
namespace App\Helpers;
use Hashids\Hashids;


class EncryptionHelper{

    //private static $KEY = 'TestEncryption';
    public static function encrypt($id){

       // $hashids = new Hashids('TestEncryption');

        //$encId = $hashids->encode($id);


        return $id;

    }

    public static function decrypt($encId){

        //$hashids = new Hashids('TestEncryption');

        //$id = $hashids->decode($encId);

        return $encId;

    }

}