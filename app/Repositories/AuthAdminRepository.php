<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Consts;
use Session;
use Hash;
use DB;

class AuthAdminRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function getAll()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        try {
            $customer = $this->model->create($data);
            DB::commit();
            return $customer;
        } catch (\Exception $exception) {
            // return false;
            DB::rollBack();
            return $exception;
        }
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

    // Custom......................

    // # kiểm tra email đã tồn tại hay chưa ?
    public function checkEmail($email){
        return $this->model->where('email', '=', $email)->first() ? true : false;
    }
    // # tạo random secret key
    public function generateSecretKey(){
        return mt_rand(1000000, 9999999);
    }
    // # Tạo token server
    public function createTokenServer($id){
        return Hash::make($id . '$' . $this->model->findOrFail($id)->secret_key);
    }
    // # Tạo token client
    public function createTokenClient($id){
        return $id . '$' . Hash::make($id . '$' . $this->model->findOrFail($id)->secret_key);
    }

    // # Tìm kiếm tài khoản customer
    public function findCustomer($id){
        return $this->model->where('id', '=', $id)->first();
    }

    
    // # kiểm tra đăng nhập
    public function checkAccount($email, $password){
        $user = $this->model->where('email', '=', $email)->first();
        if ($user) {
            return Hash::check($password, $user->password) ? $user->id : false;
        }else{
            return false;
        }
    }


    
}
