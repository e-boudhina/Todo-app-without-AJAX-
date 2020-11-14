@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{  session()->get('success')  }}
    </div>

@elseif(session()->has('error'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{session()->get('error')}}
    </div>
@endif
