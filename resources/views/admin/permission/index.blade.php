@extends('admin/layout/iframe/main')

@section('script')
<script type="text/javascript">
layui.use('table', function(){
  var table = layui.table;
  var grid = {!! json_encode($data['grid']) !!};

  //console.log(grid);
  //第一个实例
  table.render({
    elem: '#data'
    ,url: '{{route('permission.index')}}' //数据接口
    ,page: true
    ,cols: [grid]
  });


});
</script>
@endsection
