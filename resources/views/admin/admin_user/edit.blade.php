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
                        <label class="col-sm-2 control-label">头像</label>
                        <div class="layui-upload col-sm-10">
                          <button type="button" class="layui-btn" id="test1">上传图片</button>
                            <input type="text" class="hidden" value="11" name="avatar">
                          <div class="layui-upload-list col-sm-offset-2">
                            <img class="layui-upload-img" id="demo1" src="{{$data['data']->avatar}}">
                            <p id="demoText"></p>
                          </div>
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
    layui.use(['form', 'transfer', 'upload'], function () {
        var form = layui.form;
        var transfer = layui.transfer;
        var upload = layui.upload;

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
                avatar:$('input[name=avatar]').val(),
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

      //普通图片上传
      var uploadInst = upload.render({
        elem: '#test1'
        ,url: '{{route('upload')}}?_token={{csrf_token()}}' //改成您自己的上传接口
        ,before: function(obj){
          //预读本地文件示例，不支持ie8
          obj.preview(function(index, file, result){
            $('#demo1').attr('src', result); //图片链接（base64）
          });
        }
        ,done: function(res){
            $('input[name=avatar]').attr('value', res.data);
          //如果上传失败
          if(res.code > 0){
            return layer.msg('上传失败');
          }
          //上传成功
            return layer.msg(res.msg);
        }
        ,error: function(){
          //演示失败状态，并实现重传
          var demoText = $('#demoText');
          demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
          demoText.find('.demo-reload').on('click', function(){
            uploadInst.upload();
          });
        }
      });

    })
</script>
@endsection