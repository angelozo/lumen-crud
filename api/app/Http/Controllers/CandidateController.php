<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Candidate as Candidate;

class CandidateController extends  Controller {

	public function index(Request $request) {
		$candidates = Candidate::all();

		return response()
			->json($candidates)
			->withHeaders([
				'Content-Type' => 'application/json'
			]);;
	}

	public function load(Request $request, $id) {
		$candidate = Candidate::find($id);

		return response()
			->json($candidate)
			->withHeaders([
				'Content-Type' => 'application/json'
			]);;
	}

	public function create(Request $request) {
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:candidates'
		]);

		$candidate = Candidate::create([
			'name' => $request->input('name'),
			'email' => $request->input('email')
		]);

		return response(null, 201)
			->withHeaders([
				'Content-Type' => 'application/json',
				'Location' => route('candidate.find', ['id' => $candidate->id])
			]);
	}

	public function delete(Request $request, $id) {
		$candidate = Candidate::find($id);

		if(!$candidate) {
			return response(null, 404);
		}

		$candidate->delete();

		return response(null, 200)
			->withHeaders([
				'Content-Type' => 'application/json'
			]);
	}

	public function update(Request $request, $id) {
		$this->validate($request, [
			'name' => 'max:255'
		]);

		$candidate = Candidate::find($id);

		if(!$candidate) {
			return response(null, 404);
		}

		if($candidate->email != $request->input('email')) {
			$this->validate($request, [
				'email' => 'email|unique:candidates'
			]);
		}

		$candidate->name = $request->input('name');
		$candidate->email = $request->input('email');
		$candidate->save();

		return response(null, 200);
	}
}
