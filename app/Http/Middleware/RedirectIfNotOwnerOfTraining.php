<?php namespace App\Http\Middleware;

use App\Training;
use Closure;

class RedirectIfNotOwnerOfTraining {

	/**
	 * Handle an incoming request.
	 * If user is not the owner of the training then
	 * he/she will be redirected.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$trainingId = $request->segment(2);
		$training = Training::findOrFail($trainingId);

		if ( (! $training->isTheOwner( $request->user() )) && (! $request->user()->isAdmin()) ) {
			session()->flash('flash_message', 'Sina ei ole selle treeningu omanik!');
			return redirect('trainings');
		}

		return $next($request);
	}

}
