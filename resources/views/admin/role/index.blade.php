@extends('admin/layout/iframe/main')

@section('script')
<script type="text/html" id="action">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>

<script type="text/javascript">
layui.use('table', function(){
  var table = layui.table;
  var grid = {!! json_encode($data['grid']) !!};

    function init()
    {
      //第一个实例
      table.render({
        elem: '#data',
        toolbar: '#toolbarDemo',
        defaultToolbar: ['filter', 'exports', 'print', { //自定义头部工具栏右侧图标。如无需自定义，去除该参数即可
          title: '提示'
          ,layEvent: 'LAYTABLE_TIPS'
          ,icon: 'layui-icon-tips'
        }],
        url: '{{route('role.index')}}', //数据接口
        page: true,
        cols: [grid]
      });
    }
    init();

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
      var url = '{{route('role.index')}}/' + data.id + '/edit';
      edit(url);
    }
  });

  function edit(url)
  {
      // 编辑 iframe 层显示
      var index = layer.open({
                    type:2,
                    content:url,
                    area: 'auto',
                    maxmin: true,
                    title:' ',
                    cancel: function(index, layero){
                        init();
                        layer.close(index);
                        return false;
                    }
                  });

      layer.full(index);
  }
});
</script>
@endsection
