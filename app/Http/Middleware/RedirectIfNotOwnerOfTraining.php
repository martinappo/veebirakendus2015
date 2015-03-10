<?php namespace App\Http\Middleware;

use App\Training;
use Closure;

class RedirectIfNotOwnerOfTraining {

	/**
	 * Handle an incoming request.
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
