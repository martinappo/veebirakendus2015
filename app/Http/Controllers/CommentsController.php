<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use App\Training;
use Request;
use Auth;

class CommentsController extends Controller {

	/**
	 * Create a new trainings controller
	 */
	public function __construct()
	{
		$this->middleware('admin', ['only' => array('destroy') ]);
		$this->middleware('auth', ['only' => array('store') ]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$comment = new Comment();
		$comment->training_id = Request::input('trainingId');
		$comment->content = Request::input('content');

		Auth::user()->comments()->save($comment);

		$comments = Training::findOrFail(Request::input('trainingId'))->comments()->get();

		return view('partials.comments', compact('comments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$comment = Comment::findOrFail($id);
		$comment->delete();
		return response()->json('success', 200);
	}

}
