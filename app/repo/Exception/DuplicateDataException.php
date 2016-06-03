<?php namespace App\repo\Exception;


use Laracasts\Flash\Flash;

class DuplicateDataException implements ExceptionInterface {
    public function exception()
    {
        Flash::warning('Oh Snap!! This QDN is already registered. In doubt? ask QA to assist you!');
    }
}