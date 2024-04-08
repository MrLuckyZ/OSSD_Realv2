<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Collection;
use App\Models\User;
use Session;


class WorkspaceController extends Controller
{
    public function index($id)
    {
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = Workspace::find($id);

        if (!$data['selectedWorkspace']) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }
        session(['selected_workspace_id' => $id]);

        return view('workspace', $data);
    }

    public function setting($id)
    {
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = Workspace::find($id);
        return view('setting_work', $data);
    }
    public function create()
    {
        $data['workspaces'] = Workspace::orderBy('id', 'desc')->paginate(5);
        return view('create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'workspace-input-name' => 'required',
            'access' => 'required'
        ]);
        $user = auth()->user();

        $workspace = new Workspace;
        $workspace->name = $request->input('workspace-input-name');
        $workspace->access = $request->input('access');

        if ($user) {
            $workspace->user_create = $user->id;
        }

        $workspace->save();
        return redirect()->route('home.index')->with('success', 'Workspace has been created succesfully');
    }

    public function collections(Request $request)
    {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;

        return view('collection', $data);
    }

    public function history(Request $request)
    {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;

        return view('history', $data);
    }

    public function trash(Request $request)
    {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;

        $collection = $selectedWorkspace->collections();
        $data['collections'] = $collection;

        Session::flush();
        return view('trash', $data);
    }

    public function deleteFromCollectionTabs(Request $request, $id)
    {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $workspace = Workspace::find($selectedWorkspaceId);
        if ($request->session()->has('collection_tabs')) {
            $collection_tabs = $request->session()->get('collection_tabs');

            foreach ($collection_tabs as $index => $collection) {
                if ($collection->id == $id) {
                    unset($collection_tabs[$index]);
                    $request->session()->put('collection_tabs', $collection_tabs);
                    break;
                }
            }
            if (count($collection_tabs) > 0) {
                $collectionId = reset($collection_tabs)->id;
                return redirect()->route('workspace.editCollection', ['workspace' => $workspace->id, 'collection' => $collectionId]);
            } else {
                return redirect()->route('workspace.collections', ['workspace' => $workspace->id]);
            }
        }
    }

    public function editCollection(Request $request, $workSpaceid, $id)
    {
        $workspace = Workspace::find($workSpaceid);

        if ($request->session()->has('collection_tabs')) {
            $collection_tabs = $request->session()->get('collection_tabs');
        } else {
            $collection_tabs = [];
        }

        if ($id == "-1") {
            $collection = new Collection;
            $collection->name = 'New Collection';
            $collection->user_create = auth()->user()->user_id;
            $collection->id = -1;
        } else {
            $collection = Collection::find($id);
        }

        if (!in_array($id, array_column($collection_tabs, 'id'))) {
            $collection_tabs[] = $collection;
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $workspace;
        $data['selectedCollection'] = $collection;
        $methods = $collection->methods;
        $data['methods'] = $methods;
        $request->session()->put('collection_tabs', $collection_tabs);

        return view('collection_template', $data);
    }

    public function saveToWorkspace(Request $request, $collectionId)
    {
        $collection = Workspace::find($workSpaceid);

    }

    public function delete_workspace(Request $request, $id)
    {
        $selectedWorkspace = Workspace::find($id);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }

        if ($selectedWorkspace->collections() != null) {
            foreach ($selectedWorkspace->collections as $collection) {
                $collection->methods()->delete();
                $collection->delete();
            }
            $selectedWorkspace->delete();
            return redirect()->back();
        }
    }
}
