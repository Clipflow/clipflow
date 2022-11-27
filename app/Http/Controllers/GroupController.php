<?php

namespace App\Http\Controllers;

use App\Http\Requests\Groups\CreateGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Group::class, 'group');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        $groups = Group::all();

        // filter groups shown based on url query
        if ($request->has('member')) {
            $groups = Group::whereHas('members', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })->get();
        }



        return Inertia::render('Groups/Index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Groups/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateGroupRequest  $request
     * @return RedirectResponse
     */
    public function store(CreateGroupRequest $request): RedirectResponse
    {
        $group = Group::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'creator_id' => $request->user()->id,
        ]);

        // Add the creator as an admin
        $group->addMember($request->user(), GroupMember::ROLE_ADMIN);
        $group->forceFill(['creator_id' => $request->user()->id])->save();

        // If a group image was uploaded, send it to be processed accordingly
        if ($request->file('image_url')) {
            $group->processImage($request->file('image_url'));
        }

        return Redirect::route('groups.show', $group);
    }

    /**
     * Display the specified resource.
     *
     * @param  Group  $group
     * @return Response
     */
    public function show(Group $group): Response
    {
        return Inertia::render('Groups/Show', [
            'group' => [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'created_at' => $group->created_at->format('d/m/Y'),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Group  $group
     * @return Response
     */
    public function edit(Group $group): Response
    {
        return Inertia::render('Groups/Edit', [
            'group' => GroupResource::make($group),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateGroupRequest  $request
     * @param  Group  $group
     * @return RedirectResponse
     */
    public function update(UpdateGroupRequest $request, Group $group): RedirectResponse
    {
        $group->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Check if a new image was uploaded
        if ($request->file('image_url')) {
            // If the group already has an image, delete it
            if ($group->hasImage()) {
                $group->removeImage();
            }

            // Process the new image
            $group->processImage($request->file('image_url'));
        }

        return Redirect::route('groups.edit', $group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  Group  $group
     * @return RedirectResponse
     */
    public function destroy(Request $request, Group $group): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::in([$group->name])],
        ]);

        $group->forceDelete();

        return Redirect::route('groups.index');
    }
}
