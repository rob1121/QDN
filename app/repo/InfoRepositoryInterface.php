<?php
namespace App\repo;

interface InfoRepositoryInterface {
	public function view($qdn, $view);

	public function links($slug);

	public function department($slug);

	public function save($info, $request);

	public function add($request);

}