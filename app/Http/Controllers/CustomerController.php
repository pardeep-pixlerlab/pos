<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware(['role_or_permission:admin']); // Replace 'admin' with the appropriate role name
    // }
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response(
                Customer::all()
            );
        }
        
        $roles = Role::all();
        $customers = Customer::latest()->paginate(10);
       
        return view('customers.index', compact('customers', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::latest()->get();
        return view('customers.create',['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        $avatar_path = '';

        if ($request->hasFile('avatar')) {
            $avatar_path = $request->file('avatar')->store('customers', 'public');
        }

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'avatar' => $avatar_path,
            'user_id' => $request->user()->id,
        ]);

        $customer->roles()->attach($request->roles); 
       
        $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
       ]);
       $user->assignRole($request->roles);
       
        if (!$customer) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while creating customer.');
        }
        return redirect()->route('customers.index')->with('success', 'Success, your customer have been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $roles = Role::latest()->get();
        return view('customers.edit', compact('customer', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
  
    public function update(Request $request, Customer $customer)
    {
        // Update customer data
        $customer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
    
        // Update avatar if a new one is uploaded
        if ($request->hasFile('avatar')) {
            if ($customer->avatar && Storage::disk('public')->exists($customer->avatar)) {
                Storage::disk('public')->delete($customer->avatar);
            }
            $avatar_path = $request->file('avatar')->store('customers', 'public');
            $customer->update(['avatar' => $avatar_path]);
        }

        // Update associated user data
        $user = $customer->user;
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
    
        // Update user roles
        $user->syncRoles($request->roles);
        // Redirect with appropriate messages
        return redirect()->route('customers.index')
            ->with('success', 'Success, your customer has been updated.');
    }


    public function destroy(Customer $customer)
    {
        if ($customer->avatar) {
            Storage::delete($customer->avatar);
        }

        $customer->delete();

       return response()->json([
           'success' => true
       ]);
    }
}
