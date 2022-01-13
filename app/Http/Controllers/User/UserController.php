<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
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
        $user = User::query()->create($fields);
        return $this->showOne($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

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
        return $this->showOne($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
        return $this->showOne($user);
    }
}
