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
                <div class="form-horizontal" class="layui-form" lay-filter="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="" name="name" required>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色权限</label>
                        <div class="col-sm-10">
                            <div id="transfer" class="demo-transfer"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-primary" id="submit">保存内容</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    layui.use(['form', 'transfer', 'layer'], function () {
        var form = layui.form;
        var transfer = layui.transfer;
        var layer = layui.layer;

    //模拟数据
    var data1 = [
        {"value": "4", "title": "李清照"},
        {"value": "5", "title": "鲁迅", "disabled": true}
    ];
    //显示搜索框
    transfer.render({
        elem: '#transfer',
        data: {!! json_encode($data['permissions']) !!},
        title: ['已选择', '未选择'],
        showSearch: true,
        width:400,
        id:'demo1'
    });

    $('#submit').on('click', function () {
        var name = $('input[name=name]').val();
        var getData = transfer.getData('demo1');
        var per = [];

        getData.forEach(function(item) {
            per.push(item.value);
        });

        $.post('{{route('role.store')}}', {
            _token: '{{csrf_token()}}',
            name:name,
            permissions:per
        }, function (res) {
            layer.open({
                title:'提示',
                content:res.msg
            });
        });

        return false;
    });


    })
</script>
@endsection