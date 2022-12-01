<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupMemberRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class GroupMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Group  $group
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function index(Group $group): Response
    {
        $this->authorize('view', $group);

        return Inertia::render('Groups/Members', [
            'members' => $group->members()->get(),
            'group' => GroupResource::make($group),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateGroupMemberRequest  $request
     * @param  Group  $group
     * @return RedirectResponse
     */
    public function store(CreateGroupMemberRequest $request, Group $group)
    {
        $user = User::whereEmail($request->email)->first();

        $role = $request->get('role');

        if ($user) {
            $group->addMember($user, $role);
        }

        return Redirect::route('groups.members', $group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  GroupMember  $groupMember
     * @param  Group  $group
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(GroupMember $groupMember, Group $group): RedirectResponse
    {
        $this->authorize('delete', $group);

        // Dont allow the last admin to be removed
        if ($groupMember->role === GroupMember::ROLE_ADMIN && $group->admins()->count() === 1) {
            return Redirect::back()->with('error', 'You cannot remove the last admin from a group.');
        }

        $groupMember->delete();

        return Redirect::route('groups.members.index', $group);
    }
}
