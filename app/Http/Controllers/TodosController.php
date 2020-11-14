<?php


namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('todos')->with('todos',$todos);
    }

    public function create(Request $request)
    {
//        dd($request->all());
        Todo::create([
            'todo' => $request->taskName
        ]);
        session()->flash('success','Todo added Successfully');
        return redirect()->back();
    }

    public function update(Request $request, Todo $todo)
    {
        // You can add exception handling but there is no need for it here
//        dd($request->all());
        // Method 1 to update:
//    $todo->update([
//        'todo' => $request->taskName
//    ]);
    // Method 2 to update:
        $todo->todo = $request->taskName;
        $todo->save();
    session()->flash('success','Todo Updated Successfully');
    return redirect()->back();
    }
    public function updateStatus(Todo $todo)
    {
//        dd($todo->completed ==0);
        if ($todo->completed)
        {
            $todo->completed = 0;
        }else {
            $todo->completed = 1;
        }
        $todo->save();
        session()->flash('success','Todo Status Updated Successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        //there are multiple way to delete
        // 1- either you send a post request  containing a field id that you will use to delete
        // 2- yo use a resource or add the model as parameter then using the model to grab if for you and deleted it ( shorter way, best practise)
        // 3- you send only the parameter id which is lighter and faster than sending the entire object
        //              - to extract the parameter there is a complex way to do it using : $request->route()->parameter('user')
        // It's up to you to Choose which one, they all lead to the same result
        // You can use Request $request then extract the parameter from route like this:     public function destroy(Request $request)
        //   or use     public function destroy($id) public function destroy
        // or use find by id method $todo = Todo::find($id);
        // or use model name     public function destroy(Todo $todo) which will grab it for you
//        dd($request->route()->parameters());
//           dd($todo);
        $todo = Todo::find($id);
        if ($todo)
        {
            $status = $todo->delete();
//            dd($status);
            if ($status)
            {
                session()->flash("success", "Todo Deleted Successfully");
            }else
            {
                session()->flash("error", "Deleting Todo Failed");
            }
        }else
            //you might ask why did I add this message, well if the user clicks 2 time on delete button the first request will delete the item while the second request will try to delete as well
            // so since we just deleted that item, the id is already gone => better than 404 page, it's not pretty
        {
            session()->flash("error", "This item does not exist");
        }

            return redirect()->back();
    }
}






/*
This destroy method shows all the possible ways you can use to delete and item with a bit of exception handling, you don't need to implement them since for example laravel provide you with simple and effective ways like 404 not found exception
which is automatically get raised if the item is not found ( only if you use method => public function destroy(Todo $todo) and in routes you send the Todo as parameter, make sure the model is written using underscore characters only):
  public function destroy($id)
    {
        //there are multiple way to delete
        // 1- either you send a post request  containing a field id that you will use to delete
        // 2- you use a resource or add the model as parameter then using the model to grab if for you and deleted it ( shorter way, best practise)
        // 3- you send only the parameter id which is lighter and faster than sending the entire object
        //              - to extract the parameter there is a complex way to do it using : $request->route()->parameter('user')
        // It's up to you to Choose which one, they all lead to the same result
        // You can use Request $request then extract the parameter from route like this:     public function destroy(Request $request)
        //   or use     public function destroy($id) public function destroy
        // or use find by id method
        // or use model name     public function destroy(Todo $todo) which will grab it for you
//        dd($request->route()->parameters());
//           dd($todo);
        $todo = Todo::find($id);
        // if todo is found then $todo will contain true
        if ($todo)
        {
        // status contains the exit code or rather the result of executing the delete operation same principal of $todo | true or false result
            $status = $todo->delete();
//            dd($status);
            if ($status)
            {
                session()->flash("success", "Todo Deleted Successfully");
            }else
            {
                session()->flash("error", "Deleting Todo Failed");
            }
        // to do not found => $todo contains false
        }else
        {
            session()->flash("error", "This item does not exist");
        }

            return redirect()->back();
    }
*/
