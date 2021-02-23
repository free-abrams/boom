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
                    {{method_field('put')}}
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$role->name}}" name="name">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">guard_name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$role->guard_name}}" name="guard_name"> <span class="help-block m-b-none">帮助文本，可能会超过一行，以块级元素显示</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">title</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$role->title}}" name="title">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit" lay-filter="submit">保存内容</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="javascript">
    layui.use('form', function () {
        var form = layui.form;

        form.on('submit(submit)', function(data){
          console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
          console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
          console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            $.post('{{route('role.update', ['role' => $id])}}', {
                data:data.field
            }, function (res) {
                layer.open({
                    title:'提示',
                    msg:res.msg
                });
            });
          return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    })
</script>
@endsection