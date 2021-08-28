<?php
namespace App\Repository\Contract;

use Illuminate\Http\Request;

interface KidClassInterface{
    public function all(Request $data);
    public function kidsPerClass();
    public function findById($id);
    public function findLastId();
    public function delete($id);
    public function save(Request $data);
    public function update($id,Request $data);
    public function getMessage();
}
