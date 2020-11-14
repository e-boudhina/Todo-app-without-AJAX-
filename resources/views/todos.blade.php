@extends('layouts.app')

@section('content')
    <div class="container">
        @include('inc.feedback')
        <div class="card">
            <div class="card-header">
                Todos:    <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addTodoModal" >Add</button>

            </div>
            <div class="card-body">

                <table class="table">
                    @if(count($todos) > 0)

                    <thead class="table-dark">
                    <tr>
                        <td>id</td>
                        <td>Task</td>
                        <td>Status</td>
                        <td>Created</td>
                        <td>Action</td>
                    </tr>

                    </thead>
                    <tbody>

                    @foreach($todos as $todo)
                        <tr>
                            <td>{{$todo ->id}}</td>
                            <td>{{$todo ->todo}}</td>
                            {{--                    This could be done either in the model or here it depends on you | But to follow conventions logic and processing  should be done in the model or controller--}}
                            <td>
                                <div class="form-group float-left" style="width: 80%">
                                    {{  $todo ->completed ?'Completed':'Not Completed'}}
                                </div>
                                <div class="form-group float-right" style="width: 20%">
                                    <form id="status" method="post" action="{{route('updateTodoStatus',$todo)}}">
                                        @csrf
                                        @method('put')
                                        <div class="input-group-text" >
                                            <input  id="box" type="checkbox"  name="answered"  {{$todo->completed==true ? 'checked' :'' }}   onchange="this.form.submit()" >
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td>{{$todo ->created_at->diffForHumans()}}</td>
                            {{--                    <td><button class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteTodoModal" >Delete</button>&nbsp;--}}
                            <td>
                                <div class="row">

                                    <div class="col">
                                <button class="btn btn-info" data-toggle="modal" data-target="#updateTodoModal" onclick="updateTodo('{{$todo->todo}}')">Update</button>
                                    </div>
                                    <div class="col">

                                <form action="{{route('deleteTodo',$todo->id)}}" method="post" id="addForm">
                                    @csrf
                                    @method('delete')
                                    <button  type="submit" class="btn btn-danger" >Delete</button>
                                </form>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @else
                        <h1 class="text-center">You haven't Created Any Todos Yet</h1>
                    @endif
                </table>



            </div>
        </div>
    </div>

{{--    AddModal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="addTodoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add toDo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('addTodo')}}" method="post" id="addForm">
                    @csrf
                <div class="modal-body">
{{--                    remember if you change the field name from the model name attribute, when you try to add it it later you'll have to manuelly say : Todo::create([ 'todo' = $request-> name]);--}}
{{--                    meanwhile if you keep the model name the same as field name defined here all you ahve to do is Todo::create($request->all)--}}
{{--                    so imagine if you have 10 or more fields  you'll have to manually do that which is quiet a tedious job so as measure of convention it is reccemended that you keep the field name the same as that in your model--}}
                    <input type="text" class="form-control" placeholder="Task name" name="taskName">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{--    UpdateModal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="updateTodoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update toDo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('updateTodo',isset($todo->id)?$todo->id:'')}}" method="post" id="updateForm">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <input type="text" class="form-control" placeholder="Task name" name="taskName" id="taskName">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--    DeleteModal--}}
{{--    <div class="modal fade" tabindex="-1" role="dialog" id="deleteTodoModal">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title">Delete toDo</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <form action="{{route('deleteTodo',$todo->id)}}" method="post" id="deleteForm">--}}
{{--                    @csrf--}}
{{--                    @method('delete')--}}
{{--                    <div class="modal-body">--}}
{{--                        Are You Sure you want to delete this Todo. Once deleted this item can not be retrieve!--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="submit" class="btn btn-primary">Yes I am Sure</button>--}}
{{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
@section('scripts')
<script type="text/javascript">
    function updateTodo(taskName) {
    // alert("taskName : "+taskName);
      document.getElementById("taskName").value=taskName;

        // $('taskName').value =taskName;
    }

{{--    $('#addForm').on('submit',function (e) {--}}
{{--        e.preventDefault();--}}
{{--        --}}{{--onclick=" updateModule('{{$module->id}}','{{$module->title}}','{{$module->description}}')"--}}

{{--        $.ajax({--}}
{{--            type:"POST",--}}
{{--            url: "{{route('modules.store')}}",--}}
{{--            data: $('#addForm').serialize(),--}}
{{--            dataType :   "json",--}}

{{--            success: function(res) {--}}
{{--                if(res.status == "success") {--}}
{{--                    console.log(res);--}}
{{--                    $("#result").html("<div class='alert alert-success'>" + res.message+ "</div>");--}}

{{--                    // $("#addForm")[0].reset();--}}
{{--                    $("#addForm").trigger("reset");--}}
{{--                    setTimeout(function () {--}}
{{--                        $("#result").fadeOut("slow");--}}
{{--                    },2000);--}}
{{--                    setTimeout(function(){--}}
{{--                        $("#result").html("");--}}
{{--                        $("#result").attr('style','');--}}

{{--                    }, 3000);--}}
{{--                    $("#content").load(" #content");--}}

{{--                }else--}}
{{--                {--}}
{{--                    console.log(res);--}}
{{--                }--}}
{{--                //there is so many ways on how to resolve this, I lost count--}}

{{--            },--}}
{{--            error: function(res) {--}}

{{--                var errors = res.responseJSON;--}}
{{--                console.log(errors);--}}
{{--                var error_html = '';--}}
{{--                for(var count = 0; count < errors.errors.length; count++)--}}
{{--                {--}}
{{--                    error_html += '<p>'+errors.errors[count]+'</p>';--}}
{{--                }--}}
{{--                $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');--}}

{{--            }--}}
{{--        });--}}
{{--    });--}}
</script>
@endsection
