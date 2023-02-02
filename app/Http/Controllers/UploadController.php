<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsvFileJob;
use App\Models\Prices;
use App\Services\Files\FileUploadService;
use App\Services\Files\ProcessCsvFileService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $files = $request->validate([
            'tables' => 'required'
        ]);

        $param = [];
        $route = '';
        try{
           foreach($files['tables'] as $file) {
                $fileName = (new FileUploadService($file))->store();
                ProcessCsvFileJob::dispatch($fileName);
                $param['success'] = true;
                $route = 'upload.prices';
            }
        }catch (\Exception $e) {
            $param['error'] = 'UP-10';
            $route = 'upload.index';
        }

        return redirect()->route($route, $param);
    }

    public function prices()
    {
        return view('prices', ['prices' => Prices::all()]);
    }
}
