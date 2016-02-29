<?php
namespace App\repo;

interface InfoRepositoryInterface {
	/**
	 * view controller
	 * @param  [type] $qdn  [description]
	 * @param  [type] $view [description]
	 * @return [type]       [description]
	 */
	public function view($qdn, $view);

	/**
	 * get link for save as draft and save and proceed
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function links($slug);

	/**
	 * get department of each
	 * @param  [type] $qdn [description]
	 * @return [type]      [description]
	 */
	public function department($slug);

	/**
	 * update qdn database
	 * @param  [type] $slug    [description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function save($info, $request);

	/**
	 * insert new qdn to the database
	 * @param [type] $request [description]
	 */
	public function add($request);

	/**
	 * method to update data in section one
	 * @param [type] $request [description]
	 * @param [type] $slug    [description]
	 */
	public function SectionOneUpdate($request, $slug);

	/**
	 * update status of qdn
	 * @param [type] $request [description]
	 * @param [type] $qdn     [description]
	 */
	public function UpdateClosureStatus($request, $qdn);
}