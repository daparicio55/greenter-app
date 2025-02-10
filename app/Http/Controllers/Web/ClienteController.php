<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
{
    //
    public function index()
    {
        $clientes = User::whereHas('roles',function($query){
            $query->where('name','!=','administrador');
        })->get();
        
        return view('dashboard.clientes.index',compact('clientes'));
    }

    public function create()
    {
        return view('dashboard.clientes.create');
    }
    public function edit($id){
        $cliente = User::findOrFail($id);
        return view('dashboard.clientes.edit',compact('cliente'));
    }
    
    public function update(Request $request,$id){
        return $request->all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:users,email',

            'razon_social' => 'required|string',
            'ruc' => [
                'required',
                'string',
                'regex:/^(10|20)\d{9}$/'
            ],
            'direccion' => 'required|string',
            'logo' => 'nullable|image',
            'sol_user' => 'required|string',
            'sol_pass' => 'required|string|confirmed',
            'cert' => 'required|file|mimes:pem,txt',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'production' => 'nullable|boolean',
        ]);
        try {
            $cliente = User::create($request->only('name', 'email', 'password'));
            $cliente->assignRole('cliente');
            if ($request->hasFile('logo')) {
                $data['logo_path'] = $request->file('logo')->store('logos');
            }

            $data['cert_path'] = $request->file('cert')->store('certs');
            $data['user_id'] = $cliente->id;

            Company::create($data);
        } catch (\Throwable $th) {
            return Redirect::route('dashboard.clientes.create')->with('error', 'Error al crear el cliente');
        }

        return Redirect::route('dashboard.clientes.index');
    }
    public function destroy($id)
    {
        $cliente = User::findOrFail($id);
        $cliente->delete();
        return Redirect::route('dashboard.clientes.index');
    }
}
