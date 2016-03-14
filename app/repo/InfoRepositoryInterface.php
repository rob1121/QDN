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

	/** to update 4 action data table */
	public function updateCauseOfDefect($info, $request);
	public function updateContainmentAction($info, $request);
	public function updateCorrectiveAction($info, $request);
	public function updatePreventiveAction($info, $request);
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
	 * insert on info table
	 * @param [type] $request [description]
	 */
	public function AddInfo($request);

	/**
	 * [AddInvolvePerson description]
	 * @param [type] $request [description]
	 * @param [type] $id      [description]
	 */
	public function AddInvolvePerson($request, $id);

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

	/**
	 * update function for approver
	 * @param  [type] $request [description]
	 * @param  [type] $qdn     [description]
	 * @return [type]          [description]
	 */
	public function approverUpdate($request, $qdn);

	/**
	 * get count of defined category
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function count($type, $qdn);

	/**
	 * collection of count method
	 * @return [type] [description]
	 */
	public function failureModeCount();

	/**
	 * get qdn via method
	 * @return [type] [description]
	 */
	public function getQdn();
}