<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
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

	public function index() {

		try {
			return DB::table( 'users' )->get();
		} catch ( \Exception $e ) {
			return $e->getMessage();
		}

	}

	public function create( Request $request ) {

		try {

			$this->validate( $request, [
				'full_name' => 'required',
				'username'  => 'required|min:4',
				'email'     => 'required|email',
				'password'  => 'required|min:6'
			] );

//			return $request->all();

		} catch ( ValidationException $e ) {

			return response()->json( [
				'success' => false,
				'message' => $e->getMessage()
			], 422 );
		}


		try {
			$insertedUserId = DB::table( 'users' )->insertGetId(
				[
					'full_name'  => trim( $request->full_name ),
					'username'   => strtolower( trim( $request->username ) ),
					'email'      => strtolower( trim( $request->email ) ),
					'password'   => app( 'hash' )->make( $request->password ),
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				]
			);

			return response()->json( [ User::findOrFail( $insertedUserId ) ], 201 );

		} catch ( \PDOException $e ) {

			return response()->json( [
				'success' => false,
				'message' => $e->getMessage()
			], 400 );
		}
	}
}
