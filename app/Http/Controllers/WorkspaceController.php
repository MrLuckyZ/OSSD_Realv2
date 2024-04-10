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
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Shared\ZipArchive;

use Illuminate\Support\Facades\File;


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

    public function setting(Request $request, $id)
    {
        $data['workspaces'] = Workspace::get()->all();
        $selectedWorkspace = Workspace::find($id);
        $data['selectedWorkspace'] = $selectedWorkspace;
        return view('setting_work', $data);
    }
    public function create()
    {
        $data['workspaces'] = Workspace::orderBy('id', 'desc')->paginate(5);
        return view('create', $data);
    }

    public function view_allworkspace(){
        $data['workspaces'] = Workspace::get()->all();
        return view('view_allworkspace', $data);
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

    public function setting_access(Request $request,$id){
        $selectedWorkspace = Workspace::find($id);
        $user = auth()->user();
        if($selectedWorkspace -> user_create == $user -> id){
            if($request->has('access')){
            $access = $request->input('access');
            if($access == "personal"){
                $selectedWorkspace -> access = "persoanal";
            }else if($access == "team"){
                $selectedWorkspace -> access = "team";
            }
        }
        
        $selectedWorkspace -> save();
        }else{
            return redirect()->back()->with('error', 'You not owner');
        }
        
        return redirect()->back()->with('success', 'You have change access');

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
    public function delete_collection(Request $request,$id){
        $selectedCollection = Collection::find($id);
        if (!$id) {
            return redirect()->route('home.index')->with('error', 'Collection not found');
        }
        $selectedCollection->status = "0";
        $selectedCollection->save();
        return redirect()->back();
    }
    public function deletereal_collection(Request $request,$id){
        $selectedCollection = Collection::find($id);
        if (!$id) {
            return redirect()->route('home.index')->with('error', 'Collection not found');
        }
        $selectedCollection->delete();
        return redirect()->back();    
    }

    public function recover_collection(Request $request,$id){
        $selectedCollection = Collection::find($id);

        if (!$id) {
            return redirect()->route('home.index')->with('error', 'Collection not found');
        }
        $selectedCollection->status = "1";
        $selectedCollection->save();
        return redirect()->back();
    }




    public function save_json_data(Request $request, $workspace) {
        $method_type = $request->input('method_type');
        $req_header_key = $request->input('request_header_key');
        $req_header_require = $request->input('request_header_required');
        $req_header_desc = $request->input('request_header_desc');
        $method_route = $request->input('method_route');
        $req_param_key = $request->input('request_param_key');
        $request_param_type = $request->input('request_param_type');
        $req_param_data_type  = $request->input('request_param_data_type');
        $req_param_require = $request->input('request_param_required');
        $req_param_desc = $request->input('request_param_desc');
        $req_body_key = $request->input('request_body_key');
        $req_body_data_type = $request->input('request_body_data_type');
        $req_body_require = $request->input('request_body_required');
        $req_body_desc = $request->input('request_body_desc');
        $res_body_code = $request->input('response_body_code');
        $res_body_status = $request->input('response_body_status');
        $res_body_key = $request->input('response_body_key');
        $res_body_data_type = $request->input('response_body_data_type');
        $res_body_desc = $request->input('response_body_desc');
        $method = [
            "request-header" => array(),
            "request-parameter" => array(),
            "request-body" => array(),
            "data" => array(),
            "status" => [
                "code" => $res_body_code,
                "text" => $res_body_status
            ]
        ];
        array_push($method['request-header'],['method'=>$method_type ,'route'=>$method_route]);
        foreach ($req_header_key as $index => $value) {
            $requir = true;
            if(empty($req_header_require[$index])){
                $requir = false;
            }
            if (isset($req_header_require[$index])) {
                if(is_null($req_header_desc)){
                    $req_header = [
                        "key" => $value,
                        "require" => $requir,
                        "description" => ""
                    ];
                }
                else{
                    $req_header = [
                        "key" => $value,
                        "require" => $requir,
                        "description" => $req_header_desc[$index]
                    ];
                }
                array_push($method['request-header'], $req_header);
            }
        }

        if (!empty($req_param_key) && !empty($value) && !empty($request_param_type) && !empty($req_param_data_type)) {
            foreach ($req_param_key as $index => $value) {
                $requir = true;
                if(empty($req_param_require[$index])){
                    $requir = false;
                }
                if(is_null($req_param_desc)){
                    $req_param = [
                        "key" => $value,
                        "type" => $request_param_type[$index],
                        "data_type" => $req_param_data_type[$index],
                        "require" => $requir,
                        "description" => ""
                    ];
                }
                else{
                    $req_param = [
                        "key" => $value,
                        "type" => $request_param_type[$index],
                        "data_type" => $req_param_data_type[$index],
                        "require" => $requir,
                        "description" => $req_param_desc[$index]
                    ];
                }
                array_push($method['request-parameter'], $req_param);

            }
        }
        
        if (!empty($req_body_key) && !empty($value) && !empty($req_body_data_type) && !empty($req_body_require)) {
            foreach ($req_body_key as $index => $value) {  
                $requir = true;
                if(empty($req_body_require[$index])){
                    $requir = false;
                } 
                if(is_null($req_body_desc)){
                    $req_body = [
                        "key" => $value,
                        "data_type" => $req_body_data_type[$index],
                        "require" => $requir,
                        "description" => ""
                    ];
                }
                else {
                    $req_body = [
                        "key" => $value,
                        "data_type" => $req_body_data_type[$index],
                        "require" => $requir,
                        "description" => $req_body_desc[$index]
                    ];
                }
                array_push($method['request-body'], $req_body);

            }
        }

        if (!empty($res_body_key) && !empty($value) && !empty($res_body_data_type) && !empty($res_body_desc)) {
            foreach ($res_body_key as $key => $value) {
                    if(is_null($res_body_desc)){
                        $res_body = [
                            "key" => $value,
                            "data-type" => $res_body_data_type[$key],
                            "description" => ""
                        ];
                    }
                    else{
                        $res_body = [
                            "key" => $value,
                            "data-type" => $res_body_data_type[$key],
                            "description" => $res_body_desc[$key]
                        ];
                    }
                }
                array_push($method['data'], $res_body);
            }



        $json = json_encode($method);
        $col = new Collection;
        $col->name = 'Untitle';
        $col->properties = $json;
        $col->user_create = auth()->user()->id;
        $col->workspace_id = $workspace;
        $col->status = '1';
        
        $col->save();

        return redirect()->back();
    }

    public function save_as_json(Request $request, $workspace){
        $method_type = $request->input('method_type');
        $req_header_key = $request->input('request_header_key');
        $req_header_require = $request->input('request_header_required');
        $req_header_desc = $request->input('request_header_desc');
        $method_route = $request->input('method_route');
        $req_param_key = $request->input('request_param_key');
        $request_param_type = $request->input('request_param_type');
        $req_param_data_type  = $request->input('request_param_data_type');
        $req_param_require = $request->input('request_param_required');
        $req_param_desc = $request->input('request_param_desc');
        $req_body_key = $request->input('request_body_key');
        $req_body_data_type = $request->input('request_body_data_type');
        $req_body_require = $request->input('request_body_required');
        $req_body_desc = $request->input('request_body_desc');
        $res_body_code = $request->input('response_body_code');
        $res_body_status = $request->input('response_body_status');
        $res_body_key = $request->input('response_body_key');
        $res_body_data_type = $request->input('response_body_data_type');
        $res_body_desc = $request->input('response_body_desc');
        $method = [
            "request-header" => array(),
            "request-parameter" => array(),
            "request-body" => array(),
            "data" => array(),
            "status" => [
                "code" => $res_body_code,
                "text" => $res_body_status
            ]
        ];
        array_push($method['request-header'],['method'=>$method_type ,'route'=>$method_route]);
        foreach ($req_header_key as $index => $value) {
            $requir = true;
            if(empty($req_header_require[$index])){
                $requir = false;
            }
            if (isset($req_header_require[$index])) {
                if(is_null($req_header_desc)){
                    $req_header = [
                        "key" => $value,
                        "require" => $requir,
                        "description" => ""
                    ];
                }
                else{
                    $req_header = [
                        "key" => $value,
                        "require" => $requir,
                        "description" => $req_header_desc[$index]
                    ];
                }
                array_push($method['request-header'], $req_header);
            }
        }

        if (!empty($req_param_key) && !empty($value) && !empty($request_param_type) && !empty($req_param_data_type)) {
            foreach ($req_param_key as $index => $value) {
                $requir = true;
                if(empty($req_param_require[$index])){
                    $requir = false;
                }
                if(is_null($req_param_desc)){
                    $req_param = [
                        "key" => $value,
                        "type" => $request_param_type[$index],
                        "data_type" => $req_param_data_type[$index],
                        "require" => $requir,
                        "description" => ""
                    ];
                }
                else{
                    $req_param = [
                        "key" => $value,
                        "type" => $request_param_type[$index],
                        "data_type" => $req_param_data_type[$index],
                        "require" => $requir,
                        "description" => $req_param_desc[$index]
                    ];
                }
                array_push($method['request-parameter'], $req_param);

            }
        }
        
        if (!empty($req_body_key) && !empty($value) && !empty($req_body_data_type) && !empty($req_body_require)) {
            foreach ($req_body_key as $index => $value) {  
                $requir = true;
                if(empty($req_body_require[$index])){
                    $requir = false;
                } 
                if(is_null($req_body_desc)){
                    $req_body = [
                        "key" => $value,
                        "data_type" => $req_body_data_type[$index],
                        "require" => $requir,
                        "description" => ""
                    ];
                }
                else {
                    $req_body = [
                        "key" => $value,
                        "data_type" => $req_body_data_type[$index],
                        "require" => $requir,
                        "description" => $req_body_desc[$index]
                    ];
                }
                array_push($method['request-body'], $req_body);

            }
        }

        if (!empty($res_body_key) && !empty($value) && !empty($res_body_data_type) && !empty($res_body_desc)) {
            foreach ($res_body_key as $key => $value) {
                    if(is_null($res_body_desc)){
                        $res_body = [
                            "key" => $value,
                            "data-type" => $res_body_data_type[$key],
                            "description" => ""
                        ];
                    }
                    else{
                        $res_body = [
                            "key" => $value,
                            "data-type" => $res_body_data_type[$key],
                            "description" => $res_body_desc[$key]
                        ];
                    }
                }
                array_push($method['data'], $res_body);
            }

        $json = json_encode($method,JSON_PRETTY_PRINT);
        $filename = time() .'_datafile.json';
        $filestorepath = public_path('/uploads/json/'.$filename);
        File::put($filestorepath, $json);
        return response()->download($filestorepath);
    }


    public function save_as_doc(Request $request)
    {
        $method_type = $request->input('method_type');
        $req_header_key = $request->input('request_header_key');
        $req_header_require = $request->input('request_header_required');
        $req_header_desc = $request->input('request_header_desc');
        $method_route = $request->input('method_route');
        $req_param_key = $request->input('request_param_key');
        $request_param_type = $request->input('request_param_type');
        $req_param_data_type  = $request->input('request_param_data_type');
        $req_param_require = $request->input('request_param_required');
        $req_param_desc = $request->input('request_param_desc');
        $req_body_key = $request->input('request_body_key');
        $req_body_data_type = $request->input('request_body_data_type');
        $req_body_require = $request->input('request_body_required');
        $req_body_desc = $request->input('request_body_desc');
        $res_body_code = $request->input('response_body_code');
        $res_body_status = $request->input('response_body_status');
        $res_body_key = $request->input('response_body_key');
        $res_body_data_type = $request->input('response_body_data_type');
        $res_body_desc = $request->input('response_body_desc');

        $templateProcessor = new TemplateProcessor('word-template/API_Spec-template.docx');
        $templateProcessor->setValue('method', $method_type);
        $templateProcessor->setValue('route', $method_route);
        $templateProcessor->setValue('required', $request->address);

        foreach ($req_header_key as $index => $value) {
            $requir = true;
            if(empty($req_header_require[$index])){
                $requir = false;
            }
            if (isset($req_header_require[$index])) {
                if(is_null($req_header_desc)){
                    $templateProcessor->setValue('no_header', $index);
                    $templateProcessor->setValue('key_header', $value);
                    $templateProcessor->setValue('require_header', $requir);
                    $templateProcessor->setValue('description_header', "");

                }
                else{
                    $templateProcessor->setValue('no_header', $index);
                    $templateProcessor->setValue('key_header', $value);
                    $templateProcessor->setValue('require_header', $requir);
                    $templateProcessor->setValue('description_header', $req_header_desc[$index]);
                }
            }
        }

        if (!empty($req_param_key) && !empty($value) && !empty($request_param_type) && !empty($req_param_data_type)) {
            foreach ($req_param_key as $index => $value) {
                $requir = true;
                if(empty($req_param_require[$index])){
                    $requir = false;
                }
                if(is_null($req_param_desc)){
                    $templateProcessor->setValue('no_param', $value);
                    $templateProcessor->setValue('key_param', $request_param_type[$index]);
                    $templateProcessor->setValue('paramtype_param', $req_param_data_type[$index]);
                    $templateProcessor->setValue('datatype_param', $req_param_data_type[$index]);
                    $templateProcessor->setValue('required_param', $requir);
                    $templateProcessor->setValue('desc_param', "");
                }
                else{
                    $templateProcessor->setValue('no_param', $value);
                    $templateProcessor->setValue('key_param', $request_param_type[$index]);
                    $templateProcessor->setValue('paramtype_param', $req_param_data_type[$index]);
                    $templateProcessor->setValue('datatype_param', $req_param_data_type[$index]);
                    $templateProcessor->setValue('required_param', $requir);
                    $templateProcessor->setValue('desc_param', "");
                }
            }
        }
        
        if (!empty($req_body_key) && !empty($value) && !empty($req_body_data_type) && !empty($req_body_require)) {
            foreach ($req_body_key as $index => $value) {  
                $requir = true;
                if(empty($req_body_require[$index])){
                    $requir = false;
                } 
                if(is_null($req_body_desc)){
                    $templateProcessor->setValue('no_response', $index);
                    $templateProcessor->setValue('key_response', $value);
                    $templateProcessor->setValue('datatype_response', $req_body_data_type[$index]);
                    $templateProcessor->setValue('desc_response', "");
                }
                else {
                    $templateProcessor->setValue('no_response', $index);
                    $templateProcessor->setValue('key_response', $value);
                    $templateProcessor->setValue('datatype_response', $req_body_data_type[$index]);
                    $templateProcessor->setValue('desc_response', $req_body_desc[$index]);
                }
        }

        if (!empty($res_body_key) && !empty($value) && !empty($res_body_data_type) && !empty($res_body_desc)) {
            foreach ($res_body_key as $key => $value) {
                if(is_null($res_body_desc)){
                    $templateProcessor->setValue('no_response', $index);
                    $templateProcessor->setValue('key_response', $value);
                    $templateProcessor->setValue('datatype_response', $res_body_data_type[$key]);
                    $templateProcessor->setValue('desc_response', "");
                }
                else{
                    $templateProcessor->setValue('no_response', $index);
                    $templateProcessor->setValue('key_response', $value);
                    $templateProcessor->setValue('datatype_response', $res_body_data_type[$key]);
                    $templateProcessor->setValue('desc_response', $res_body_desc[$key]);
                }
            }
        }

        $fileName = 'api-spec';
        $templateProcessor->saveAs($fileName . '.docx');
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
        }
    }
}
