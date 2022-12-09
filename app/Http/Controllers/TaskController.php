<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Interfaces\TaskRepositoryInterface;
use App\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    protected $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateTaskRequest $request
     * @return TaskResource
     */
    public function store(CreateTaskRequest $request): TaskResource
    {
        $data = $request->validated();
        $user = $request->user();
        $data['user_id'] = $user->id;
        $this->repository->create($data);

        return new TaskResource($this->repository->attachUser($user)->load('users'));
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {

        return TaskResource::collection($this->repository->list($request->user()));
    }

    /**
     * @param Task $task
     * @param UpdateTaskRequest $request
     * @return TaskResource
     * @throws AuthorizationException
     */
    public function update(Task $task, UpdateTaskRequest $request): TaskResource
    {
        $this->authorize('update', $task);

        return new TaskResource($this->repository->update($task, $request->validated()));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $task = Task::find($id);
            $this->authorize('delete', $task);
            $this->repository->delete($id);

            return response()->json(['data' => 'Record Is Deleted'], ResponseAlias::HTTP_OK);
        } catch (\Exception $exception) {

            return response()->json(['data' => 'Record Not Found'], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Task $task
     * @param Request $request
     * @return TaskResource
     */
    public function assignToMe(Task $task, Request $request): TaskResource
    {
        return new TaskResource(
            $this->repository->assignToMe($task, $request->user())
                ->load('users')
        );
    }
}
