<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminders extends Model
{
    protected $fillable = ['reminder', 'item_id'];

    //One To Many relationship
    //note: we can make it ManyToMany also

    /**
     * Get related item.
     */
    public function item()
    {
        return $this->belongsTo(Items::class);
    }

    /**
     *my method to help me to manage items
     */
    public static function getAll()
    {
        return Reminders::all();
    }

    public static function getInstance($id)
    {
        return Reminders::find($id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public static function addNewInstance($data)
    {
        return Reminders::create($data) != null;
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public static function deleteInstance($id)
    {
        //check from exist of the element first
        $row = self::getInstance($id);
        if ($row) {
            return $row->delete();
        }
        return  false;
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @param [type] $data
     * @return void
     */
    public static function updateInstance($id, $data)
    {
        //check from exist of the element first
        $row = self::getInstance($id);
        if ($row) {
            return $row->update($data);
        }
        return  false;
    }
}
