<?php

class ApiController extends BaseController
{
    protected $items;
    protected $tableSchema;
    public static $schema = array();

    public function __construct(ApiTableSchema $tableSchema = Null)
    {
        $this->tableSchema = $tableSchema ?: new ApiTableSchema($this->items);
        $this->tableSchema->setController(get_class($this));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Request::ajax()) {
            return $this->items->search(Request::all());
        }

        return View::make('api/index')
            ->with('schema', $this->tableSchema)
            ->with('items', $this->items->search(Request::all()));
    }

    /**
     * Show the form for creating a new resource.
     * (open the edit form with no existing item; the view will take care of the rest)
     *
     * @return Response
     */
    public function create()
    {
        return View::make('api/edit')
            ->with('schema', $this->tableSchema);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validation = Validator::make(Input::all(), $this->tableSchema->getRules());

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->errors());
        }

        $created = $this->items->create(Input::all());
        if (!$created) {
            return Redirect::back()->withInput()->withErrors( $this->items->errors() );
        }

        return $this->redirectToIndex('New record saved');
    }


    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $found = $this->items->findOrFail($id);
        return View::make('api/show')
            ->with('schema', $this->tableSchema)
            ->with('item', $found);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $found = $this->items->findOrFail($id);
        return View::make('api/edit')
            ->with('schema', $this->tableSchema)
            ->with('item', $found);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $found = $this->items->findOrFail($id);
        $validation = Validator::make(Input::all(), $this->tableSchema->getRules($id));

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->errors());
        }

        $found->fill(Input::all());
        if (! $found->save()) {
            return Redirect::back()->withInput()->withErrors($found->errors());
        }
        return $this->redirectToIndex('New data saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $found = $this->items->findOrFail($id);
        $found->delete();
        return $this->redirectToIndex('The selected record has been deleted');
    }

    private function redirectToIndex($message)
    {
        return Redirect::action($this->tableSchema->getController() . '@index')->with('message', $message);
    }


    /**
     * Returns links to api index routes (from the routes table).
     * This is currently used in the Tables menu
     */
    public static function getApiLinks()
    {
        $routes = self::getApiRouteArray();
        asort($routes);
        $result = '';

        foreach($routes as $name => $uri) {
            $result .= '<li><a href="' . $uri . '"">' . $name . '</a></li>';
        }
        return $result;
    }

    protected static function getApiRouteArray()
    {
        $result = array();
        $routes = Route::getRoutes();
        foreach($routes as $name => $route) {
            if(substr($name, -6)=='.index') {
                $display = getDisplayName(substr($name, 0, -6));
                $result[$display] = $route->getPath();
            }
        }
        return $result;
    }

}

