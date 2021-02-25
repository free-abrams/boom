@extends('admin/layout/iframe/main')

@section('script')

<script type="text/html" id="toolbarDemo">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="create">新增</button>
  </div>
</script>

<script type="text/html" id="avatar">
  <img src=@{{ d.avatar }} alt="头像" width="50">
</script>

<script type="text/html" id="action">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>

<script type="text/javascript">
layui.use('table', function(){
  var token = '{{csrf_token()}}';
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
        url: '{{route('admin-user.index')}}', //数据接口
        page: true,
        cols: [grid]
      });
    }
    init();
  //头工具栏事件
  table.on('toolbar(data)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id); //获取选中行状态
    switch(obj.event){
      case 'create':
          var url = '{{route('admin-user.create')}}';
          create(url);
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
        var url = '{{route('admin-user.index')}}/'+ data.id;
        del(url);
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      var url = '{{route('admin-user.index')}}/' + data.id + '/edit';
      edit(url);
    } else if (obj.event === 'create') {
      var url = '{{route('admin-user.create')}}';
      create(url);
    }
  });
  // 新增事件
  function create(url)
  {
      // 新增 iframe 层显示
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

  // 编辑事件
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

  function del(url) {

    $.post(url, {
      _method:'delete',
        _token:token
    }, function (res) {
        init();
    })
  }
});
</script>
@endsection
