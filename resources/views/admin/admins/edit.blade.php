@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
@endsection
@section('pagename')
Admin Manager
@endsection
@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning">{{ $error }}</div>
            @endforeach
        @endif
        <form method="post" action="{{route('admin.admin-manager.update', ['id' => $admin->id])}}">
          <legend>Edit Admin/Staff</legend>
          {{ csrf_field()}}
          {{ method_field('PUT') }}
          <div class="form-group">
            <label for="inputUsername">Username</label>
            <input readonly="" id="inputUsername" value="{{old('username')?old('username'):$admin->username}}" type="text" class="form-control" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="inputFullName">Full Name</label>
            <input id="inputFullName" value="{{old('name')?old('name'):$admin->name}}" type="text" class="form-control" name="name" placeholder="Ha Ja U">
          </div>
          <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="text" class="form-control" value="{{old('password')}}" id="inputPassword" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label>Level</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="level" id="radio1" @if(old('level') != '2' or $admin->level != '2') checked="" @endif value="1" >
              <label class="form-check-label" for="radio1">Admin</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="level" id="radio2" @if(old('level') == '2' or $admin->level == '2') checked="" @endif  value="2">
              <label class="form-check-label" for="radio2">Staff</label>
            </div>
          </div>
          <div class="form-group" id="permissions" @if(old('level') == '1' or $admin->level == '1') style="display: none;" @endif>
            <label>Permissions</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_delete') or $adminPermission->can_delete) checked="" @endif name="can_delete" id="can_delete">
              <label class="form-check-label" for="can_delete">
                Can Delete
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_add') or $adminPermission->can_add) checked="" @endif name="can_add" id="can_add">
              <label class="form-check-label" for="can_add">
                Can Add
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_update') or $adminPermission->can_update) checked="" @endif name="can_update" id="can_update">
              <label class="form-check-label" for="can_update">
                Can Update
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_read') or $adminPermission->can_read) checked="" @endif name="can_read" id="can_read">
              <label class="form-check-label" for="can_read">
                Can Read
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_accept_order') or $adminPermission->can_accept_order) checked="" @endif name="can_accept_order" id="can_accept_order">
              <label class="form-check-label" for="can_accept_order">
                Can Accept Order
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_reject_order') or $adminPermission->can_reject_order) checked="" @endif  name="can_reject_order" id="can_reject_order">
              <label class="form-check-label" for="can_reject_order">
                Can Reject Order
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_view_order_history') or $adminPermission->can_view_order_history) checked="" @endif name="can_view_order_history" id="can_view_order_history">
              <label class="form-check-label" for="can_view_order_history">
                Can View Order History
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_view_user') or $adminPermission->can_view_user) checked="" @endif name="can_view_user" id="can_view_user">
              <label class="form-check-label" for="can_view_user">
                Can View User
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_block_user') or $adminPermission->can_block_user) checked="" @endif name="can_block_user" id="can_block_user">
              <label class="form-check-label" for="can_block_user">
                Can Block User
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" @if(old('can_change_policies') or $adminPermission->can_change_policies) checked="" @endif name="can_change_policies" id="can_change_policies">
              <label class="form-check-label" for="can_change_policies">
                Can Change Policies
              </label>
            </div>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" value="1" @if(old('status') or $admin->status=='1') checked="" @endif id="active" name="status" >
            <label class="form-check-label" for="active">Active this account</label>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
@section('customscript')
<script type="text/javascript">
$(document).ready(function () {
    $('input[type=radio][name=level]').change(function() {
        if (this.value === '1') {
            $("#permissions").hide();
        }
        else if (this.value === '2') {
            $("#permissions").show();
        }
    });
});
</script>
@endsection