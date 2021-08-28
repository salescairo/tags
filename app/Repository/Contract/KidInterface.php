<?php
namespace App\Repository\Contract;

use Illuminate\Http\Request;

interface KidInterface{
    public function all(Request $data);
    public function findById($id);
    public function findLastId();
    public function delete($id);
    public function total();
    public function save(Request $data);
    public function update($id,Request $data);
    public function getMessage();
}
