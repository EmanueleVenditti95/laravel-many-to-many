<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Type;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        $technologies = Technology::all();
        return view('admin.projects.create',compact('types','technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $request->validate([
            'title' => ['required', 'max:255', 'string',Rule::unique('projects')],
            'image' => ['nullable', 'file','max:2048'],
            'description' => ['nullable'],
            'type_id' => ['nullable','exists:types,id'],
            'technology_id' => ['nullable','exists:types,id'],
        ]);
        
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        
        if($request->hasFile('image')) {
            $path = Storage::put('uploads',$request->image);
            $data['image'] = $path;            
        }

        $project = Project::create($data);

        if ($request->has('technologies')){
            $project->technologies()->attach($data['technologies']);
        }

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
        $technologies = Technology::all();
        return view('admin.projects.edit',compact('project','types','technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        //ricordarsi di definire $fillable nel Model
        $request->validate([
            'title' => ['required', 'max:255', 'string',Rule::unique('projects')->ignore($project->id)],
            'image' => ['nullable', 'file','max:2048'],
            'description' => ['nullable'],
            'type_id' => ['nullable','exists:types,id'],
            'technology_id' => ['nullable','exists:types,id'],
        ]);

        $data = $request->all(); 

        if($request->hasFile('image')) {
            $path = Storage::put('uploads',$request->image);
            $data['image'] = $path;

            if ($project->image) {
                Storage::delete($project->image);
            }            
        } 

        $data['slug'] = Str::slug($data['title'], '-');

        $project->update($data);

        if ($request->has('technologies')){
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->detach();
        }

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
