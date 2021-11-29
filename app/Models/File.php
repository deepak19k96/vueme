<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class File extends Model
{
    protected $fillable = [
        'name', 'ext', 'path', 'size'
    ];
    protected $hidden = ["created_at", "updated_at", "fileable_id", "fileable_id_type"];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function save(array $data = []){

        if(!empty($data)){

            $pathinfo = pathinfo($data['name']);
            $base64img = $data['image'];
            if ($pathinfo['extension'] == 'png' || $pathinfo['extension'] == 'gif') {
                $img = str_replace('data:image/png;base64,', '', $base64img);
            } else {
                $img = str_replace('data:image/jpeg;base64,', '', $base64img);
            }
            $base64_decode = base64_decode(str_replace(' ', '+', $img));
            $fileName = date_timestamp_get(new \DateTime()).'.'.$pathinfo['extension'];
            try {
                Storage::disk('files')->put($fileName, $base64_decode);
                $this->name = strtolower(preg_replace('/[^A-Za-z0-9]+/', "-", $pathinfo['filename']));
                $this->ext = $pathinfo['extension'];
                $this->path = $fileName;
            } catch (\Exception $exception) {

            }
        }
        return parent::save();
    }

    public function setData(UploadedFile $file)
    {

        $this->name = $file->sizgetClientOriginalName();
        $this->ext = $file->extension();
        $this->path = $file->store('/', ['disk' => 'files']);
        $this->size = $file->getSize();
        return $this;
    }

    public function delete(array $data = [])
    {

        if ($path = $this->path) {
            try {
                Storage::disk('files')->delete($path);
            } catch (\Exception $exception) {

            }
        }
        return parent::delete();
    }
}
