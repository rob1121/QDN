<?php namespace App\repo\Exception;


class DataRelationNotFound implements ExceptionInterface {
    public function exception()
    {
        dd("DataRelationNotFound: No related data found in parent table Info at line " . __LINE__. " of " . __FILE__);
    }
}