<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        if($request->search){

            $users = $this->userService->modelFilter($request->search,5);
        }else{
            $users = $this->userService->all(5);

        }
        return view('dashboard.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email'=>'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'roles'=>'required|array',
            'roles.*'=>'required|integer',
        ]);

        $user = $this->userService->store($data);
        $this->userService->attach($user,'roles',$data['roles']);

        return back()->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->get($id);
        return view('dashboard.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userService->get($id);
        return view('dashboard.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:50',
            'email'=>'nullable|string|unique:users,email,'.$id,
            'roles'=>'nullable|array',
            'roles.*'=>'nullable|integer',
        ]);

        $user = $this->userService->update($data,$id);
        
        $this->userService->sync($user,'roles',$data['roles']);
        
        return back()->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->delete($id);
        return back()->with('success','User deleted successfully');
    
    }
}
