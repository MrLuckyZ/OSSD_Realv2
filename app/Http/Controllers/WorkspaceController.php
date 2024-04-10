<?php

namespace App\Http\Controllers;

use Session;
use App\Models\User;
use App\Models\Workspace;
use App\Models\recentlyLog;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Method;
use App\Models\Request_Header;
use App\Models\Parameter;
use App\Models\Response;
use App\Models\Response_Body;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RecentlyLogg;

class WorkspaceController extends Controller
{
    public function wordExport(Request $request)
    {
        $templateProcessor = new TemplateProcessor('word-template/user.docx');
        $templateProcessor->setValue('id', $request->id);
        $templateProcessor->setValue('name', $request->name);
        $templateProcessor->setValue('email', $request->email);
        $templateProcessor->setValue('address', $request->address);
        $fileName = 'api-apec';
        $templateProcessor->saveAs($fileName . '.docx');
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
    }

    public function index($id)
    {   
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = Workspace::find($id);

        if (!$data['selectedWorkspace']) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        $work = Workspace::find($id);
        $id_user = $work->userCreate->id;
        $access = $work->access;
        $workspace_name = $work->name;
        $user_name = $work->userCreate->name;
        $recentlylogs = [
            'id_user' => $id_user,
            'workspace_name' => $workspace_name,
            'id_workspace' => $id,
            'access' => $access,
            'user_name' => $user_name,
            'date_time' => $todayDate
        ];
        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }
        DB::table('recently_logs')->insert($recentlylogs);
        session(['selected_workspace_id' => $id]);

        return redirect()->route('workspace.collections', ['workspace' => $id])->with($data,$datarecently);
    }

    public function setting($id)
    {
        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }

        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = Workspace::find($id);
        return view('setting_work', $data,$datarecently);
    }
    public function create()
    {
        $data['workspaces'] = Workspace::orderBy('id', 'desc')->paginate(5);
        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }
        return view('create', $data,$datarecently);
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

        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        $work = Workspace::find($workspace->id);
        $id_user = $work->userCreate->id;
        $access = $work->access;
        $workspace_name = $work->name;
        $user_name = $work->userCreate->name;
        $recentlylogs = [
            'id_user' => $id_user,
            'workspace_name' => $workspace_name,
            'id_workspace' => $workspace->id,
            'access' => $access,
            'user_name' => $user_name,
            'date_time' => $todayDate
        ];
        DB::table('recently_logs')->insert($recentlylogs);
        return redirect()->route('home.index')->with('success', 'Workspace has been created succesfully');
    }

    public function collections(Request $request)
    {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }
        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;

        return view('collection', $data,$datarecently);
    }

    public function history(Request $request)
    {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }
        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;

        return view('history', $data,$datarecently);
    }

    public function trash(Request $request)
    {
        $selectedWorkspaceId = $request->session()->get('selected_workspace_id');
        $selectedWorkspace = Workspace::find($selectedWorkspaceId);

        if (!$selectedWorkspace) {
            return redirect()->route('home.index')->with('error', 'Workspace not found');
        }
        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $selectedWorkspace;

        $collection = $selectedWorkspace->collections();
        $data['collections'] = $collection;

        return view('trash', $data,$datarecently);
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

        $recentlyLog = recentlyLog::get();
        $arrRecently = collect($recentlyLog);
        $reverseLog = $arrRecently->reverse();
        $uniqueData = $reverseLog->unique('id_workspace');
        $datarecently['work_recently'] = $uniqueData->values()->all();

        $recentlyLogArray = $recentlyLog->toArray();

        $count = count($recentlyLogArray);
        if ($count > 50) {
        $oldest_records = array_slice($recentlyLogArray, 0, $count - 50);
        $oldest_ids = array_column($oldest_records, 'id');
        recentlyLog::whereIn('id', $oldest_ids)->delete();
        }

        $data = $request->session()->all();
        $data['workspaces'] = Workspace::get()->all();
        $data['selectedWorkspace'] = $workspace;
        $data['selectedCollection'] = $collection;
        $request->session()->put('collection_tabs', $collection_tabs);

        return view('collection_template', $data, $datarecently);
    }

    public function Collection(Request $request, $workSpaceid, $id)
    {
        $workspace = Workspace::find($workSpaceid);
        // โค้ดอื่น ๆ ที่เหลือของฟังก์ชั่น
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
        $request->session()->put('selectedCollection', $collection);
        dd($collection);

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

    public function delete_collection(Request $request,$id){
        $selectedCollection = Collection::find($id);

        if (!$id) {
            return redirect()->route('home.index')->with('error', 'Collection not found');
        }
        else{
            $selectedCollection->delete();
            return redirect()->back();
        }
    }

    public function moveToTrash(Request $request, $id) // Use PascalCase for function names
{
    // Validate input for safety (consider using validation rules)
    $validator = Validator::make(['id' => $id], [
        'id' => 'required|integer|exists:collections,id', // Ensure ID exists in 'collections' table
    ]);

    if ($validator->fails()) {
        return redirect()->back();
    }

    $selectedCollection = Collection::find($id);
    Carbon::setLocale('th'); 
    if ($selectedCollection) {
        $selectedCollection->deleted_at =Carbon::now('Asia/Bangkok');
        $selectedCollection->status = 'deleted'; // Update status to '0' to mark as trashed
        $selectedCollection->save(); // Persist changes to the database

        return redirect()->back()->with('success', 'Collection successfully moved to trash.'); // Display success message
    } else {
        return redirect()->back()->with('error', 'Collection not found.'); // Inform user if collection wasn't found
    }
}
public function recovery_trash(Request $request, $id){
    // Validate input for safety (consider using validation rules)
    $validator = Validator::make(['id' => $id], [
        'id' => 'required|integer|exists:collections,id', // Ensure ID exists in 'collections' table
    ]);

    if ($validator->fails()) {
        return redirect()->back();
    }

    $selectedCollection = Collection::find($id);
     
    if ($selectedCollection) {
        $selectedCollection->status = 'active'; 
        $selectedCollection->save(); // Persist changes to the database

        return redirect()->back()->with('success', 'Collection successfully recovered.'); // Display success message
    } else {
        return redirect()->back()->with('error', 'Collection not found.'); // Inform user if collection wasn't found
    }
    

}
    

}