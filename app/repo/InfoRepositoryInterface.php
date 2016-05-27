<?php
namespace App\repo;

interface InfoRepositoryInterface {

	public function view($qdn, $view);

	public function links($slug);

	public function updateCauseOfDefect($info, $request);

	public function updateContainmentAction($info, $request);

	public function updateCorrectiveAction($info, $request);

	public function updatePreventiveAction($info, $request);

	public function save($info, $request);

	public function add($request);

	public function AddInfo($request);

	public function AddInvolvePerson($request, $id);

	public function SectionOneUpdate($request, $slug);

	public function UpdateClosureStatus($request, $qdn);

	public function approverUpdate($request, $qdn);

	public function count($type, $qdn);

	public function failureModeCount();

	public function getQdn();
}