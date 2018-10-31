<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	public function create( Request $request ) {

		try {

			$this->validate( $request, [
				'full_name' => 'required',
				'username'  => 'required|min:6',
				'email'     => 'required|email',
				'password'  => 'required|min:6'
			] );

		} catch ( ValidationException $e ) {

			return response()->json( [
				'success' => false,
				'message' => $e->getMessage()
			], 422 );
		}


		try {
			DB::table( 'users' )->insert(
				[
					'full_name' => $request->full_name,
					'username' => $request->username,
					'email' => $request->email,
					'password' => $request->password
				]
			);
		} catch ( \PDOException $e ) {

			return response()->json( [
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}
}
