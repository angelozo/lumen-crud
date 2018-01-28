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

	public function load(Request $Request, $id) {
		$candidate = Candidate::find($id);

		return response()
			->json($candidate)
			->withHeaders([
				'Content-Type' => 'application/json'
			]);;
	}
}
