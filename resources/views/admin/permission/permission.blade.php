@extends('admin/layout/iframe/main')

@section('script')
<script type="text/javascript">
        layui.use('table', function(){
          var table = layui.table;

          //第一个实例
          table.render({
            elem: '#data'
            ,url: '{{route('permission.index')}}' //数据接口
            ,page: true
            ,cols: [[ //表头
              {field: 'id', title: 'ID', sort: true, fixed: 'left'}
              ,{field: 'name', title: 'name', }
              ,{field: 'guard_name', title: 'guard_name', sort: true}
              ,{field: 'title', title: 'title'}
            ]]
          });

            //头工具栏事件
  table.on('toolbar(data)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id);
    switch(obj.event){
      case 'getCheckData':
        var data = checkStatus.data;
        layer.alert(JSON.stringify(data));
      break;
      case 'getCheckLength':
        var data = checkStatus.data;
        layer.msg('选中了：'+ data.length + ' 个');
      break;
      case 'isAll':
        layer.msg(checkStatus.isAll ? '全选': '未全选');
      break;

      //自定义头工具栏右侧图标 - 提示
      case 'LAYTABLE_TIPS':
        layer.alert('这是工具栏右侧自定义的一个图标按钮');
      break;
    };
  });

  //监听行工具事件
  table.on('tool(data)', function(obj){
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){
      layer.confirm('真的删除行么', function(index){
        obj.del();
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      layer.prompt({
        formType: 2
        ,value: data.email
      }, function(value, index){
        obj.update({
          email: value
        });
        layer.close(index);
      });
    }
  });

        });
</script>
@endsection
