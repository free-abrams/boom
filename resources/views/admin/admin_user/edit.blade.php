@extends('admin/layout/iframe/edit')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>所有表单元素 <small>包括自定义样式的复选和单选按钮</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" class="layui-form" lay-filter="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">昵称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$data['data']->name}}" name="title" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$data['data']->username}}" name="username" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" value="{{$data['data']->password}}" name="password" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" value="{{$data['data']->password}}" name="password_confirmed" required >
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">赋予角色</label>
                        <div class="col-sm-10">
                            <div id="transfer" class="demo-transfer"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-primary" id="submit" lay-submit lay-filter="submit">保存内容</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    layui.use(['form', 'transfer'], function () {
        var form = layui.form;
        var transfer = layui.transfer;

        //显示搜索框
        transfer.render({
            elem: '#transfer',
            data: {!! json_encode($data['role']) !!},
            value:{!! json_encode($data['value']) !!},
            title: ['已选择', '未选择'],
            showSearch: true,
            width:400,
            id:'demo1'
        });

        form.on('submit(submit)', function(data){
            var getData = transfer.getData('demo1');
            var roles = [];
            getData.forEach(function (item) {
                roles.push(item.value);
            });

            $.post('{{route('admin-user.update', ['admin_user' => $id])}}', {
                _method:'PUT',
                _token:'{{csrf_token()}}',
                avatar:'',
                name:$('input[name=title]').val(),
                username:$('input[name=username]').val(),
                password:$('input[name=password]').val(),
                password_confirmed:$('input[name=password_confirmed]').val(),
                roles:roles
            }, function (res) {
                layer.open({
                    title:'提示',
                    content:res.msg
                });
            });
          return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

    })
</script>
@endsection