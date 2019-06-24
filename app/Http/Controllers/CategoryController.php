<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
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
        $data = Category::select('category.*');

        if(isset($equest->keyword)){

            $data = $data->where(function($query) use($request) {
                $query->orWhere('name','like',$search);
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
     * Validate Json Body
     * 
     * @param \illuminate\Http\Request $request
     * @return \illuminate\Http\Response 
     */
    public function validationForm(Rwquest $request){
        //Validare Form
        $validate = Validator::make($request->all(),[
            'name' => 'required|string'
        ]);
        if($validate->fails()){
            return $this->errorObjResponse($validate->errors());
        }

        return $this->successMsgResponse("Seccess");
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
            'name' => $request->name
        ];

        //Trying save db

        try{
            $data = Category::create($data);
        }
        catch(\Exception $e){
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
    public function show(Request $request, $id)
    {
       $data = Category::find($id);

       if(!$data){
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
        $data = Category::find($id);

        if(!$data){
            return $this->errorNotFound();
        }

        $category = new Category();

        //Trying save db
        try{
            $fillable = $category->getFillable();
            $data->update($request->only($fillable));
        }
        catch(\Exception $e){
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
    public function destroy(Request $request, $id)
    {
        $data = CAtegory::find($id);
        $data->delete();
        return $this->successMsgResponse("Success");
    }
}