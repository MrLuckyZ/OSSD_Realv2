<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Collection;
use App\Models\User;
use App\Models\Method;
use App\Models\Request_Header;
use App\Models\Parameter;
use App\Models\Response;
use App\Models\Response_Body;

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
    public function import_file(Request $request, $workspaceId, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'json') {
                $jsonContent = file_get_contents($file);
                $data = json_decode($jsonContent, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['message' => 'Invalid JSON format'], 400);
                }
            } else {
                return response()->json(['message' => 'Invalid file type. Please upload a JSON file.'], 400);
            }
        } else {
            return response()->json(['message' => 'No file uploaded. Please upload a file.'], 400);
        }
    
        if ($request->session()->has('collection_tabs')) {
            $collection_tabs = $request->session()->get('collection_tabs');
            if ($request->session()->has('collection_tabs')) {
                $collection_tabs = $request->session()->get('collection_tabs');
                if (!is_null($collection_tabs)) {
                    foreach ($collection_tabs as $collection) {
                        if ($collection->id == $id) {
                            if (!is_null($data)) {
                                $json_request_header = $data['request-header'];
                                $json_response = $data['data'];
                                $json_status = $data['status'];

                                if(!is_null($json_request_header)){
                                    $method = new Method;
                                    $method->type = $json_request_header['method'];
                                    $method->route = $json_request_header['route'];
                                    foreach($json_request_header as $key=>$value){
                                        if($key != 'method' && $key != 'route'){
                                            $request_header = new Request_Header;
                                            $request_header->key = $key;
                                            if($value['required'] == true){
                                                $request_header->require = true;
                                                $request_header_list[] = $request_header;

                                            }                                          
                                        }

                                    }     
                                }
                                $method->request_header = $request_header_list;
                                
                                if(!is_null($json_response)){
                                    foreach($json_response as $key => $value){
                                        $response_body = new Response_body;
                                        $response_body->key = $key;
                                        $response_list[] = $response_body;
                                    }
                                    $response = new Response;
                                    $response->response_body = $response_list;
                                }
                                $method->response = $response;
                                $collection->method = $method;

                            } else {
                                return response()->json(['message' => 'Data is null'], 400);
                            }
                        }
                    }
                }
            }
            
        }
        $request->session()->put('collection_tabs', $collection_tabs);
        return redirect()->back();
    }
    public function comments(Request $request ,$id){
        
    }
    
}
