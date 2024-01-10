<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Type;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $request->validate([
            'title' => ['required', 'max:255', 'string',Rule::unique('projects')],
            'image' => ['required', 'url'],
            'description' => ['nullable'],
            'type_id' => ['nullable','exists:types,id']
        ]);
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $project = Project::create($data);
        return redirect()->route('projects.show',$project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.edit',compact('project','types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //ricordarsi di definire $fillable nel Model
        $request->validate([
            'title' => ['required', 'max:255', 'string',Rule::unique('projects')->ignore($project->id)],
            'image' => ['required', 'url'],
            'description' => ['nullable'],
            'type_id' => ['nullable','exists:types,id']
        ]);

        $data = $request->all(); 

        $data['slug'] = Str::slug($data['title'], '-');

        $project->update($data);

        return redirect()->route('projects.show',$project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
