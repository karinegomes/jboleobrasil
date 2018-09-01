<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;

use App\Models\Company;
use Auth;
use App\Models\Document;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentRequest $request, $entity)
    {
        try {
            $docArr = $request->except('file', '_token');
            $path = storage_path('docs/'.$entity->entityType.'_'.$entity->id.'/');

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $docArr['filename'] = $file->getClientOriginalName();
                $docArr['mimetype'] = $file->getMimeType();

                $file->move($path, $docArr['filename']);
            }

            $document = $entity->documents()->create($docArr);

            return redirect(route($entity->showRoute, $entity));
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::findOrFail($id);
        $entity = $document->entity;
        $path = storage_path("docs/".$entity->entityType."_{$entity->id}/{$document->filename}");

        return response()->file($path, [
            'Content-Type' => $document->mimetype,
            'Content-Disposition' => 'inline; filename="' . $document->filename . '"'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $entity = $document->entity;
        $path = storage_path("docs/".$entity->entityType."_{$entity->id}/{$document->filename}");

        if ($document->delete() && unlink($path)) {
            return 'Ok';
        } else {
            return abort(500);
        }
    }
}
