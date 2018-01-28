<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Candidate as Candidate;

class CandidateController extends Controller {

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
			]);;
	}
}
