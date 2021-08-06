<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Items extends Model
{
    protected $fillable = ['title', 'body', 'media', 'done', 'due_date'];


    //One To Many relationship
    //note: we can make it ManyToMany also

    /**
     * Get all reminders for each item.
     */
    public function reminders()
    {
        return $this->hasMany(Reminders::class);
    }

    /**
     *my method to help me to manage items
     */
    public static function getAll()
    {
        return Items::all();
    }

    /**
     * we want sort by due date asc and put null values(without date) in the last
     *
     */
    public static function getAllOrder()
    {
        //first get all record and add column for null dates (0 if not null , 1 if null)
        return Items::select(['*', DB::raw('due_date IS NULL AS due_date_null')])
            //order by new column first, so records with not null due date (with date) will show first
            //records with null values (1 for new column) will be last
            ->orderBy('due_date_null')
            //second, order by due date (records with due date will be sorted according to due date)
            ->orderBy('due_date')
            ->get();
    }

    public static function getAllNotDoneOrder()
    {
        return self::getAllOrder()->where('done', false);
    }

    public static function getAllDoneOrder()
    {
        return self::getAllOrder()->where('done', true);
    }

    //return the item
    public static function getInstance($id)
    {
        return Items::find($id);
    }

    /**
     * create a new item
     *
     * @param [type] $data
     * @return void
     */
    public static function addNewInstance($data, $reminders)
    {
        //create a new item in DB
        $res = Items::create($data);
        //if created successfully then attach the reminders
        if ($res) {
                //pass each reminder
                foreach ($reminders as $reminder) {
                    $data = [];
                    $data['reminder'] = $reminder;
                    $data['item_id'] = $res->id;
                    //add each reminders
                    $val = Reminders::addNewInstance($data);
                    if (!$val) return false;
            }
            return true;
        }
        return false;
    }

    /**
     * delete a item
     *
     * @param [type] $id
     * @return void
     */
    public static function deleteInstance($id)
    {
        //find this item firstly
        $row = self::getInstance($id);
        if ($row) {
            //if this item is exist then delete it
            return $row->delete();
        }
        //item is not exist
        return false;
    }

    /**
     * update a item
     *
     * @param [type] $request
     * @return void
     */
    public static function updateInstance($request)
    {
        //check from updated item
        $row = self::getInstance($request->id);
        if ($row) {
            //item exist
            return $row->update($request->all());
        }
        //false bc item is not exist
        return  false;
    }

    /**
     * change status of a item to done (completed)
     *
     * @param [type] $id
     * @return void
     */
    public static function makeDone($id)
    {
        //check from the item
        $record = self::getInstance($id);
        if ($record != null) {
            //change done status to true
            $record->done = true;
            //save changes
            return $record->save();
        }
        return false;
    }
}
