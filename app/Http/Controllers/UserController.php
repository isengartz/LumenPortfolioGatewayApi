<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;


class UserController extends Controller
{
    use ApiResponser;


    public $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService=$userService;
    }

    /**
     * Return all users
     * @return mixed
     */
    public function index()
    {
        $users = User::all();

        return $this->validResponse($users);
    }

    /**
     * Generates a token. Usable for API Users
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateToken(){
        return $this->successResponse($this->userService->generateToken());
    }

    /**
     * Perform a login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        return $this->successResponse($this->userService->login($request->all()));
    }

    /**
     * Create one new user
     * @param Request $request
     * @return \App\Traits\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $user = User::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one user
     * @param $user
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function show($user)
    {
        if (Gate::denies('update-post', $user)) {
            throw new UnauthorizedException();
        }
        $user = User::findOrFail($user);
//        $this->authorize('update', $user);
        return $this->validResponse($user);
    }

    /**
     * Update User
     * @param Request $request
     * @param $user
     * @return \App\Traits\Illuminate\Http\JsonResponse|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:users,email,' . $user,
            'password' => 'min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);

        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->validResponse($user);
    }

    /**
     * Delete user
     * @param $user
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function destroy($user)
    {
        $user = User::findOrFail($user);

        $user->delete();

        return $this->validResponse($user);
    }

    /**
     * Identify existing user
     * @param Request $request
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return $this->validResponse($request->user());
    }
}
