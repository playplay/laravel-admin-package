<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\Store;
use LaravelAdminPackage\Html\Show;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->all());
        alert()->success('<strong>' . $user->name . '</strong> a été créé avec succés.', 'C\'est tout bon !')
            ->html()->confirmButton()->autoclose(7000);

        return new JsonResponse(['success' => true], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update(array_filter($request->all()));

        alert()->success('<strong>' . $user->name . '</strong> a été modifié avec succés.', 'C\'est tout bon !')
            ->html()->confirmButton()->autoclose(7000);

        return redirect()->back();
    }

    public function destroy(User $user, Guard $auth)
    {
        if ($user->id === $auth->id()) {
            return response()->json([
                'title'   => 'Désolé',
                'message' => 'Vous ne pouvez pas vous supprimer vous même !',
                'type'    => 'error',
            ], 400);
        }
        $user->delete();

        return new JsonResponse(['success' => true]);
    }

    public function datatables(Datatables $datatables, Show $htmlHelper)
    {
        return $datatables->eloquent(User::query())
            ->editColumn('is_admin', function (User $user) use ($htmlHelper) {
                return $htmlHelper->open($user)->booleanAttribute('is_admin');
            })
            ->addColumn('actions', function (User $user) use ($htmlHelper) {
                return $htmlHelper->open($user)->indexActions('name');
            })
            ->make(true);
    }

    public function logAs(User $user = null, Store $session, Guard $auth)
    {
        if ($user->exists) {
            $this->authorize('log-as');

            if ($user->id === $auth->id()) {
                alert()->error('Vous ne pouvez pas vous connectez en tant que... vous !', 'Et non !')
                    ->html()->confirmButton()->autoclose(7000);

                return redirect()->back();
            }

            $session->put('orig_user', $auth->user());
            auth()->login($user);
        } elseif ($session->has('orig_user')) {
            auth()->login($session->pull('orig_user'));
        } else {
            throw new \InvalidArgumentException('No origin user in session.');
        }

        return redirect()->back();
    }
}
