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
                <form method="post" class="form-horizontal" action="{{route('role.update', ['role' => $id])}}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$role->name}}" name="name">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色权限</label>
                        <div class="col-sm-10">
                            <div id="transfer" class="demo-transfer"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit" lay-submit lay-filter="submit">保存内容</button>
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
            data: {!! json_encode($data['permissions']) !!},
            value:{!! json_encode($value) !!},
            title: ['已选择', '未选择'],
            showSearch: true,
            width:400,
            id:'demo1'
        });

        form.on('submit(submit)', function(data){

            var name = $('input[name=name]').val();
            var getData = transfer.getData('demo1');
            var per = [];
            getData.forEach(function (item) {
                per.push(item.value);
            });

            $.post('{{route('role.update', ['role' => $id])}}', {
                _method:'put',
                _token:'{{csrf_token()}}',
                name:name,
                permissions:per
            }, function (res) {
                console.log(res.msg);
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