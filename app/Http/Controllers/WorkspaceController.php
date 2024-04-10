<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Collection;
use App\Models\User;
use App\Models\Method;
use App\Models\Request_Header;
use App\Models\Request_Parameter;
use App\Models\Response;
use App\Models\Response_Body;
use App\Models\Request_Body;
use Illuminate\Support\Facades\Auth;

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
                                $json_request_body = $data['request-body'];
                                $json_response = $data['data'];
                                $json_status = $data['status'];
                                $method = new Method;

                                if(!is_null($json_request_header)){
                                    $method->type = $json_request_header['method'];
                                    $method->route = $json_request_header['route'];
                                    $route = $json_request_header['route'];
                                    foreach($json_request_header as $key=>$value){
                                        if($key != 'method' && $key != 'route'){
                                            $request_header = new Request_Header;
                                            $request_header->key = $key;
                                            if($value['required'] == true){
                                                $request_header->require = true;
                                            }             
                                            $request_header_list[] = $request_header;                             
                                        }

                                    }     
                                }
                                $method->request_header = $request_header_list; 

                                $params = [];
                                if (strpos($route, '?') !== false) {
                                    $queryString = explode('?', $route)[1];
                                    $parameters = explode('&', $queryString);
                                    foreach ($parameters as $parameter) {
                                        $request_parameter = new Request_Parameter;
                                        $request_parameter->key = $parameter;
                                        $request_parameter->type = 'Q';
                                        $params[] = $request_parameter;
                                    }
                                }
                                $method->parameter = $params;

                                
                                if(!is_null($json_request_body)){
                                    foreach($json_request_body as $key=>$value){
                                        $request_body = new Request_Body;
                                        $request_body->key = $key;
                                        if($value['required'] == true){
                                            $request_body->require = true;
                                        }        
                                        $request_body_list[] = $request_body;

                                    }     
                                }
                                $method->request_body = $request_body_list; 

                                if(!is_null($json_response)){
                                    foreach($json_response as $key => $value){
                                        $response_body = new Response_body;
                                        $response_body->key = $key;
                                        $response_body->type = 'Q';
                                        $response_list[] = $response_body;
                                    }
                                    $response = new Response;
                                    $response->response_body = $response_list;
                                    if(!is_null($json_status)){
                                        $response->status = $json_status['text'];
                                        $response ->code= $json_status['code'];
                                    }
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

    public function save_json_data(Request $request, $workspace) {
        $method_type = $request->input('method_type');
        $req_header_key = $request->input('request-header-key');
        $req_header_require = $request->input('request-header-required');
        $req_header_desc = $request->input('request-header-desc');
        $method_route = $request->input('method-route');
        $req_param_key = $request->input('request-param-key');
        $request_param_type = $request->input('request-param-type');
        $req_param_data_type  = $request->input('request-param-data-type');
        $req_param_require = $request->input('request-param-required');
        $req_param_desc = $request->input('request-param-desc');
        $req_body_key = $request->input('request-body-key');
        $req_body_data_type = $request->input('request-body-data-type');
        $req_body_require = $request->input('request-body-required');
        $req_body_desc = $request->input('request-body-desc');
        $res_body_code = $request->input('response-body-code');
        $res_body_status = $request->input('response-body-status');
        $res_body_key = $request->input('response-body-key');
        $res_body_data_type = $request->input('response-body-data-type');
        $res_body_desc = $request->input('response-body-desc');

        $method = [
            "type" => $method_type,
            "route" => $method_route,
            "request_header" => array(),
            "parameter" => array(),
            "request_body" => array(),
            "response" => [
                "code" =>  $res_body_code,
                "status" => $res_body_status,
                "response_body" => []
            ]
        ];

        foreach ($req_header_key as $index => $value) {
            $req_header = [
                "key" => $value,
                "require" => $req_header_require[$index],
                "description" => $req_header_desc[$index]
            ];

            array_push($method['request_header'], $req_header);
        }

        foreach ($req_param_key as $index => $value) {
            $req_param = [
                "key" => $value,
                "type" => $request_param_type[$index],
                "data_type" => $req_param_data_type[$index],
                "require" => $req_param_require[$index],
                "description" => $req_param_desc[$index]
            ];
            array_push($method['parameter'], $req_param);
        }

        foreach ($req_body_key as $index => $value) {
            $req_body = [
                "key" => $value,
                "data_type" => $req_body_data_type[$index],
                "require" => $req_body_require[$index],
                "description" => $req_body_desc[$index]
            ];
            array_push($method['request_body'], $req_body);
        }

        foreach ($res_body_key as $key => $value) {
            $res_body = [
                "key" => $value,
                "data_type" => $res_body_data_type,
                "description" => $res_body_desc,
            ];

            array_push($method['response']['response_body'], $res_body);
        }

        $json = json_encode($method);
        $col = new Collection;
        $col->name = 'untitle';
        $col->properties = $json;
        $col->user_create = Auth::user()->id;
        $col->workspace_id = $workspace;
        $col->status = '1';

        $col->save();

        return redirect()->back();
    }
}
