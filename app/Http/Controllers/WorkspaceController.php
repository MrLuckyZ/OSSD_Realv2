<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Collection;
use App\Models\User;
use Session;


class WorkspaceController extends Controller
{
    public function index($id){
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = Workspace::find($id);

        if (!$data['selectedWorkspace']) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }
        session(['selected_workspace_id' => $id]);

        return view('workspace', $data);
    }



    public function create() {
        $data['workspaces'] = Workspace::orderBy('id','desc')->paginate(5);
        return view('create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'workspace-input-name' => 'required',
            'access' => 'required'
        ]);
        $user = auth()->user() ;

        $workspace = new Workspace;
        $workspace->name = $request->input('workspace-input-name');
        $workspace->access = $request->input('access');

        if($user) {
            $workspace->user_create = $user->id;
        }

        $workspace->save();
        return redirect()->route('home.index')->with('success','Workspace has been created succesfully');
    }

    public function collections(Request $request) {
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

    public function history(Request $request) {
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

    public function trash(Request $request) {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;
        Session::flush();
        return view('trash', $data);
    }



    public function addToCollectionTabs(Request $request, $id) {
        $collection = Collection::find($id);
        if ($request->session()->has('collection_tabs')) {
            $collection_tabs = $request->session()->get('collection_tabs');

            if (!in_array($id, array_column($collection_tabs, 'id'))) {
                $collection_tabs[] = $collection;
            }  
        } else {
            $collection_tabs = [];
            $collection_tabs[] = $collection;
        }      
    
        $request->session()->put('collection_tabs', $collection_tabs);

        return redirect()->back();
    }

    public function addNewTabs(Request $request) {
        $collection = new Collection;
        $collection->name = 'New Collection';
        $collection->user_create = auth()->user()->user_id;
        $collection->id = -1;
        if ($request->session()->has('collection_tabs')) {
            $collection_tabs = $request->session()->get('collection_tabs');

            if (!in_array(-1, array_column($collection_tabs, 'id'))) {
                $collection_tabs[] = $collection;
            }  
        } else {
            $collection_tabs = [];
            $collection_tabs[] = $collection;
        }      
    
        $request->session()->put('collection_tabs', $collection_tabs);

        return redirect()->back();
    }

    public function deleteFromCollectionTabs(Request $request,$id) {
        if ($request->session()->has('collection_tabs')) {
            $collection_tabs = $request->session()->get('collection_tabs');
            foreach ($collection_tabs as $index => $collection) {
                if ($collection->id == $id) {
                    unset($collection_tabs[$index]);
                    break;
                }
            }
            $request->session()->put('collection_tabs', $collection_tabs);
        }
        return redirect()->back();
    }

    public function viewCollection(Request $request,$workSpaceid,$id) {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }
        if($id == -1){
            $collection = new Collection;
            $collection->id = -1;
            $collection->name = 'New Collection';
        } 
        else {
            $collection = Collection::find($id);
        }
        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;
        $data['selectedCollection'] = $collection;

        return view('collection_template', $data);
    }

    public function delete_collection(Request $request,$id){
        $selectedCollection = Collection::find($id);
        
        if (!$id) {
            return redirect()->route('home.index')->with('error', 'Collection not found');
        }
        if($selectedCollection->methods() != null){
            $selectedCollection->methods()->delete();
            $selectedCollection->delete();
            return redirect()->back();
        }

    }
}
