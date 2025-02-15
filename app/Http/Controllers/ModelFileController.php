<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Models\ModelFile;
class ModelFileController extends Controller
{
    public function upload(Request $request){
        try {
            $request->validate([
                'file' => 'required|mimes:usdz,glb|max:50000',
                'caption'=>'required|string|max:255' 
            ]); 
            $file = $request->file('file'); 

            $filename = 'f'.time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('3d_models', $filename, 's3');
    
            $fileUrl = Storage::disk('s3')->url($path);

            $modelFile = ModelFile::create([
                'file_url'=>$fileUrl,
                'caption'=>$request->caption
            ]);

            return response()->json(['message'=>'File uploaded successfully','data'=>$modelFile],201);
            
        } catch (\Throwable $th) {
            
            return response()->json(['message'=>$th->getMessage()],500); 
        }
    }

    public function list(){
        try {
            $modelFiles = ModelFile::all();
            return response()->json(['data'=>$modelFiles],200);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],500); 
        }
    }

    public function delete($id){

        try {
        
            $modelFile = ModelFile::find($id);
            if($modelFile){
                $filePath = parse_url($modelFile->file_url, PHP_URL_PATH);
                $filePath = ltrim($filePath, '/'); 
            
                if (Storage::disk('s3')->exists($filePath)) {
                    Storage::disk('s3')->delete($filePath);
                }
                $modelFile->delete();
                return response()->json(['message'=>'File deleted successfully'],200);
            }
    
            return response()->json(['message'=>'File not found'],404);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],500); 
        }
        

    }

    public function update(Request $request, $id){
        try {
            $modelFile = ModelFile::find($id);
            if($modelFile){
                $request->validate([
                    'caption'=>'required|string|max:255',
                    'file' => 'nullable|mimes:usdz,glb|max:50000'
                ]); 
    
                if ($request->hasFile('file')) {
                    $filePath = parse_url($modelFile->file_url, PHP_URL_PATH);
                    $filePath = ltrim($filePath, '/'); 
                    if (Storage::disk('s3')->exists($filePath)) {
                        Storage::disk('s3')->delete($filePath);
                    }
    
                    $file = $request->file('file');
                    $filename = 'f'.time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('3d_models', $filename, 's3');
                    $fileUrl = Storage::disk('s3')->url($path);
                    $modelFile->file_url = $fileUrl;
                    $modelFile->file_url = $request->file;
                }
                $modelFile->file_url = $request->file;
                $modelFile->caption = $request->caption;
                $modelFile->save();
                return response()->json(['message'=>'File updated successfully','data'=>$modelFile],200);
            }
            return response()->json(['message'=>'File not found'],404);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],500); 
        }
    }   



}
