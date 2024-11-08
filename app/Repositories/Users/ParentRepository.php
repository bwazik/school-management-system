<?php

namespace App\Repositories\Users;

use App\Interfaces\Users\ParentRepositoryInterface;
use App\Models\MyParent;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

class ParentRepository implements ParentRepositoryInterface
{
    public function deleteParent($request)
    {
        $parent = MyParent::findOrFail($request -> id);

        $attachments = Image::Where('imageable_type', 'App\Models\MyParent')->where('imageable_id', $request -> id)->get();

        if($attachments)
        {
            $file = new Filesystem;
            $file->deleteDirectory(Storage::disk('parents')->path($parent -> father_national_id));
            Image::where('imageable_type', 'App\Models\MyParent')->where('imageable_id', $request -> id)->delete();
        }

        $parent->delete();

        return redirect()->route('parents')->with('deleted', trans('users/parents.deleted'));
    }

    public function deleteSelectedParents($request)
    {
        $ids = explode("," , $request -> ids);

        $attachments = Image::Where('imageable_type', 'App\Models\MyParent')->whereIn('imageable_id', $ids)->get();

        $national_ids = MyParent::whereIn('id', $ids)->select('father_national_id')->get();

        if (!$attachments->isEmpty()) {
            $file = new Filesystem;
            foreach ($national_ids as $national_id) {
                $file->deleteDirectory(Storage::disk('parents')->path($national_id -> father_national_id));
            }
            Image::where('imageable_type', 'App\Models\MyParent')->whereIn('imageable_id', $ids)->delete();
        }

        MyParent::whereIn('id', $ids)->delete();

        return redirect()->route('parents')->with('deletedSelected', trans('users/parents.deletedSelected'));
    }

    public function parentDetails($id)
    {
        $attachments = Image::Where('imageable_type', 'App\Models\MyParent')->where('imageable_id', $id)->select('id', 'file_name', 'created_at')->get();
        $attachmentsCount = Image::Where('imageable_type', 'App\Models\MyParent')->where('imageable_id', $id)->count();
        $parent = MyParent::where('id', $id)
        ->select('id', 'email', 'password', 'father_name', 'father_national_id', 'father_passport_id',
                 'father_phone', 'father_job', 'father_nationality', 'father_blood_type', 'father_religion', 'father_address',
                 'mother_name', 'mother_national_id', 'mother_passport_id', 'mother_phone',
                 'mother_job', 'mother_nationality', 'mother_blood_type', 'mother_religion', 'mother_address')
        ->with('students')
        ->first();

        return view('users.parents.details.index', compact('attachments', 'attachmentsCount', 'parent'));
    }

    public function addAttachment($request, $parent_id)
    {
        if ($request -> hasFile('attachment')) {

            $parent = MyParent::findOrFail($parent_id);
            $father_national_id = $parent -> father_national_id;

            $count = Image::where('imageable_type', 'App\Models\MyParent')->where('imageable_id', $parent_id)->count();

            if($count < 3 )
            {
                $name = $request -> attachment -> getClientOriginalName();
                $request -> attachment -> storeAs($father_national_id, $request -> attachment -> getClientOriginalName(), 'parents');

                Image::create([
                    'file_name' => $name,
                    'imageable_id' => $parent -> id,
                    'imageable_type' => 'App\Models\MyParent',
                ]);

                return back()->with('added', trans('users/parents.AttachmentAdded'));
            }
            else
            {
                return back()->with('count', trans('users/parents.AttachmentsCount'));
            }

        }
        else
        {
            return back();
        }
    }

    public function showAttachment($father_national_id, $file)
    {
        return response()->file(storage_path('app/private/parents/'.$father_national_id.'/'.$file));
    }

    public function downloadAttachment($father_national_id, $file)
    {
        return response()->download(storage_path('app/private/parents/'.$father_national_id.'/'.$file));
    }

    public function deleteAttachment($id, $father_national_id, $file)
    {
        Storage::disk('parents')->delete($father_national_id.'/'.$file);

        Image::where('imageable_type', 'App\Models\MyParent')->where('id', $id)->where('file_name', $file)->delete();

        return back()->with('deleted', trans('users/parents.AttachmentDeleted'));
    }

    public function deleteAllParentAttachments($parent_id)
    {
        $attchments = Image::where('imageable_type', 'App\Models\MyParent')->select('id')->get();
        Image::whereIn('id', $attchments)->delete();

        $file = new Filesystem;
        $parent = MyParent::findOrFail($parent_id);
        $father_national_id = $parent -> father_national_id;
        $file->cleanDirectory(Storage::disk('parents')->path($father_national_id));

        return back()->with('deletedAll', trans('users/parents.AttachmentsDeletedAll'));
    }
}
