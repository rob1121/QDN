<?php namespace App\repo\Event;


interface EventInterface
{
 /**
  * @param $qdn
  * @return mixed
     */
 public function fire($qdn);
}