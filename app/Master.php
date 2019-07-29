<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Master extends Model
{
    use SoftDeletes;

    public function insertGood(string $name): int
    {
        try {
            $this->fetchIdByName($name);
        } catch (Exception $e) {
            $this->goods = $name;
            $this->save();
            return $this->id;
        }
        throw new Exception('Good exists');
    }

    public function fetchIdByName(string $name): int
    {
        $result = $this->withTrashed()->where('goods', $name)->get();
        if (count($result) == 0) {
            throw new Exception('No good found');
        }
        return $result[0]->id;
    }

    public function deleteByName(string $name): int
    {
        $good = $this->where('goods', $name)->get();
        if (count($good) == 0) {
            throw new Exception('No good found');
        }
        $this->where('goods', $name)->delete();
        return $good[0]->id;
    }

    public function updateGoodByName(string $existingName, string $newName): int
    {
        $good = $this->where('goods', $existingName)->get();
        if (count($good) == 0) {
            throw new Exception('No good found');
        }
        $this->where('goods', $existingName)
            ->update(['goods' => $newName]);
        return $good[0]->id;
    }
}
