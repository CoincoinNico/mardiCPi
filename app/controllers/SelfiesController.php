<?php

class SelfiesController extends BaseController {

	public function index()
	{
		// je récupère tous les selfies et les stocke dans la variable $selfies
		$selfies = Selfie::all();
		// je charge la vue views/selfies/index, $selfies sera accessible dans la vue
		return View::make('selfies.index')->with('selfies', $selfies);
	}

	public function show($id)
	{
		// je récupère le selfie qu'on veut montrer grâce à son id
		$selfie = Selfie::find($id);
		// je retourne la vue associée, je pourrai appeler la variable $selfie
		return View::make('selfies.show')->with('selfie', $selfie);
	}

	public function edit($id)
	{
		// je récupère le selfie qu'on veut montrer grâce à son id
		$selfie = Selfie::find($id);
		// je retourne la vue associée, je pourrai appeler la variable $selfie
		return View::make('selfies.edit')->with('selfie', $selfie);
	}

	public function update($id)
	{
		$rules = array(
			'title' => array('required','min:5')
		);
		$validator = Validator::make(Input::all(), $rules);

    if ($validator->fails())
    {
    	//si ce n'est pas le cas, on indique où sont les erreurs
      return Redirect::to('selfies/'. $id .'edit')->withErrors($validator)->withInput();
    }
    else 
    {
    	$selfie = Selfie::find($id);
      $selfie->title = Input::get('title');
      $selfie->save();
  		Session::flash('message', 'Selfie updaté');
  		return Redirect::to('selfies');
  	}
	}

	public function create() {
		return View::make('selfies.create');
	}

	public function store()
	{
		//on impose des contraintes aux données du formulaire
		$rules = array(
			'title' => array('required','min:5')
		);
		$validator = Validator::make(Input::all(), $rules);

    if ($validator->fails())
    {
    	//si ce n'est pas le cas, on indique où sont les erreurs
      return Redirect::to('selfies/new')->withErrors($validator)->withInput();
    }
    else 
    {
    	$data = array(
    		'title' => Input::get('title'),
    		'user_id' => Auth::user()-> id
    	);
    	Selfie::create($data);
    	Session::flash('message', 'Selfie ajouté');
    	return Redirect::to('selfies');
    }
	}

	public function delete($id)
	{
		// je récupère le selfie qu'on veut montrer grâce à son id
		$selfie = Selfie::find($id);
		// je le supprime
		$selfie->delete();
		Session::flash('message', 'Selfie supprimé');
    return Redirect::to('selfies');
	}

}