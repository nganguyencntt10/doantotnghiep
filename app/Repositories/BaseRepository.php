<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Traits\ApiRequest;
use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

abstract class BaseRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function getAll()
    {
        return $this->model->all()->sortByDesc("id");
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id = null)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function updateOrCreate(array $data, $id)
    {
        return $this->model->updateOrCreate(['id' => $id], $data);
    }
    // trả về thông báo và mã
    public function sendResponse($message, $code, $status)
    {
        $res = [
            'code'      => $code,
            'message'   => $message,
            'status'    => $status,
        ];
        return response()->json($res);
    }

    // trả về thông báo và mã
    public function sendResponseWithData( $code, $message, $data, $status)
    {
        $res = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'status' => $status,
        ];
        return response()->json($res);
    }

    public function uploadImageList($images){
        try {
            DB::beginTransaction();
            $images_array = "";
            foreach ($images as $key => $value) {
                $imageitem = time() . static::to_reset($value->getClientOriginalName());

                $value->move(public_path('images'), $imageitem);
                $images_array .= 'images/'.$imageitem.' | ';
            }
            DB::commit();
            return $images_array;
        } catch (\Exception $exception) {
            dd($exception);
            Session::flash('error', 'Upload Error!!');
            DB::rollBack();
        }
        return true;
    }

    // tải lên 1 hình ảnh và trả về URL
    public function uploadImage($image){
        try {
            DB::beginTransaction();
            $imageitem = time() . static::to_reset($image->getClientOriginalName());
            $image->move(public_path('images'), $imageitem);
            DB::commit();
            return 'images/'.$imageitem;
        } catch (\Exception $exception) {
            dd($exception);
            Session::flash('error', 'Upload Error!!');
            DB::rollBack();
        }
        return true;
    }


    // kiểm tra token
    public function checkToken($token){
        list($user_id, $token) = explode('$', $token, 2);
        $secret_key     = Authen::findOrFail($user_id)->secret_key;
        return Hash::check($user_id . '$' . $secret_key, $token) ? true : false;  
    }
    public function to_slug($str) {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    public function to_reset($string){
        $str = trim(mb_strtolower($string));
        $str =  preg_replace('/\s+/', '', $str);
        return $str;
    }

}
