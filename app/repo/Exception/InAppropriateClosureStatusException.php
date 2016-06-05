<?php


namespace App\repo\Exception;


class InAppropriateClosureStatusException implements ExceptionInterface
{
    public function exception()
    {
        dd("InAppropriateClosureStatusException: QDN signatories is not yet complete and the status is already Q.a. Verification" . __LINE__);
    }
}