<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Unit;
use Illuminate\Support\Facades\Validator;


class UnitController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Unit::select('unit.*');

        if (isset($request->keyword)) {
            //Group search by keyword
            $data = $data->where(function($query) use($request){
                $search = $request->keyword;
                $query->where('unit.name','like',$search);
                $query->orWhere('unit.name','like',$search);
            });
        }

        //Apply laravel pagination
        $data = $data->paginate(15);

        //Return Data
        return $this->successObjResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Validae Json Body
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response
     */
    public function validateForm(Request $request){
        //Validate Form
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
        ]);

        if ($validate->fails()) {
            return $this->errorObjResponse($validate->errors());
        }

        return $this->successMsgResponse("Succes");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
        ];

        //Trying save db

        try {
            $data = Unit::create($data);
        } catch (\Exception $e) {
            return $this->errorExceptionResponse($e);
        }
        return $this->successObjResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Unit::find($id);

        if (!$data) {
            return $this->errorNotFound();
        }

        return $this->successObjResponse($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Unit::find($id);

        if (!$data) {
            return $this->errorNotFound();
        }

        $unit = new Unit();

        try {
            $fillable = $unit->getFillable();
            $data->update($request->only($fillable));
        } catch (\Exception $e) {
            return $this->errorExceptionResponse($e);
        }

        return $this->successObjResponse($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Unit::find($id);
        $data->delete();
        return $this->successMsgResponse("Success");
    }
}
