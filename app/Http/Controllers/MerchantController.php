<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Merchant;
use Illuminate\Support\Facades\Validator;


class MerchantController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Merchant::select('merchant.*');

        if(isset($request->keyword)) {
            //Group search by keyword
            $data = $data->where(function($query) use($request) {
                $search = $request->keyword;
                $query->where('merchant.name','like',$search);
                $query->orWhere('merchant.name','like',$search);
                $query->orWhere('name','like',$search);
                $query->orWhere('email','like',$search);
                $query->orWhere('address','like',$search);
                $query->orWhere('phone','like',$search);
                $query->orWhere('contact_person','like',$search);
                $query->orWhere('contact_person_phone','like',$search);
                $query->orWhere('description','like',$search);
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
        
    }

    /**
     * Validate Json Body 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateForm(Request $request)
    {
        //Validate Form
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'required|string',
            'contact_person' => 'nullable|string',
            'contact_person_phone' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean', 
        ]);

        if($validate->fails()) {
            return $this->errorObjResponse($validate->errors());
        }

        return $this->successMsgResponse("Success");


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
            'email' => $request->email,
            'password' => app('hash')->make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'contact_person' => $request->contact_person,
            'contact_person_phone' => $request->contact_person_phone,
            'description' => $request->description,
            'status' => $request->status ?: 0
       ];

        //Trying save db

        try {
    
            $data = Merchant::create($data);

                
        } catch(\Exception $e) {

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
        $data = Merchant::find($id);

        if(!$data) { 
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
        $data = Merchant::find($id);

        if(!$data) { 
            return $this->errorNotFound();
        }

        $merchant = new Merchant();

        //Trying save db

        try {
            $fillable = $merchant->getFillable();
            $data->update($request->only($fillable));

                
        } catch(\Exception $e) {

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
        $data = Merchant::find($id);
        $data->delete();
        return $this->successMsgResponse("Success");
    }
}