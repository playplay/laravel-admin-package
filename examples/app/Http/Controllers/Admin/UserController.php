<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LaravelAdminPackage\Html\Show;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(User $user, Guard $auth)
    {
        if ($user->id === $auth->user()->id) {
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
            ->addColumn('actions', function (User $user) use ($htmlHelper) {
                return $htmlHelper->open($user)->indexActions('name');
            })
            ->make(true);
    }

    public function logAs(User $user = null)
    {
        /*if ($user->id) {
            session(['orig_user' => auth()->id()]);
            auth()->login($user);
        } else {
            $id = session('orig_user');
            $orig_user = User::find($id);
            auth()->login($orig_user);
        }

        return redirect()->back();*/

        return 'logAs : ' . $user->name;
    }

}
