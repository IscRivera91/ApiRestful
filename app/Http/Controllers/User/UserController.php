<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $fields['name'] = $validated['name'];
        $fields['email'] = $validated['email'];
        $fields['password'] = bcrypt($validated['password']);
        $fields['verified'] = User::USER_IS_NOT_VERIFIED;
        $fields['verification_token'] = User::generateVerificationToken();
        $fields['admin'] = User::IS_NOT_ADMIN;
        /**
         * @param User \Illuminate\Database\Eloquent\Model
         */
        $user = User::create($fields);
        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return response()->json(['data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::IS_ADMIN . ', ' . User::IS_NOT_ADMIN
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if (isset($validated['email']) && $user->email != $validated['email']) {
            $user->verified = User::USER_IS_NOT_VERIFIED;
            $user->verification_token = User::generateVerificationToken();
            $user->email = $validated['email'];
        }

        if (isset($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        if (isset($validated['admin'])) {
            if (!$user->isVerified()){
                return  response()->json(['error'=> 'Only the Verified Users can be admins', 'code' => 409],409);
            }
            $user->admin = $validated['admin'];
        }

        if (!$user->isDirty()) {
            return  response()->json(['error'=> 'At least one field must be modified', 'code' => 422],422);
        }

        $user->save();
        return response()->json(['data' => $user], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['data' => $user], 200);
    }
}
