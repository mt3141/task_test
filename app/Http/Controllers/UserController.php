<?php

namespace App\Http\Controllers;

use App\Constants\PermissionsConstant;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $repositoryInterface;

    public function __construct(UserRepositoryInterface $repositoryInterface)
    {
        $this->repositoryInterface = $repositoryInterface;
    }

    /**
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function listMembers(): AnonymousResourceCollection
    {
        $this->authorize('listMembers', Auth::user());

        return UserResource::collection($this->repositoryInterface->list(PermissionsConstant::MEMBER));
    }

    /**
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function listAdmins(): AnonymousResourceCollection
    {
        $this->authorize('listAdmins', Auth::user());

        return UserResource::collection($this->repositoryInterface->list(PermissionsConstant::ADMIN));
    }

}
