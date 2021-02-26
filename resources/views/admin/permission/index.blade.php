@extends('admin/layout/iframe/main')

@section('content')
<div class="col-sm-12">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>权限列表</h5>
        </div>
        <div class="ibox-content">
            <div class="dd" id="nestable2">
                <ol class="dd-list">
                    @if(!empty($res))
                        @foreach($res as $k => $v)
                            <li class="dd-item" data-id="{{$v['id']}}">
                                <div class="dd-handle">
                                    <span class="label label-info"><i class="fa fa-users"></i></span> {{$v['title']}}
                                </div>
                                @if(isset($v['children']))
                                    <ol class="dd-list">
                                    @foreach($v['children'] as $key => $value)
                                            <li class="dd-item" data-id="{{$value['id']}}">
                                                <div class="dd-handle">
                                                    <span class="pull-right">  </span>
                                                    <span class="label label-info"><i class="fa fa-cog"></i></span> {{$value['title']}}
                                                </div>
                                            </li>
                                    @endforeach
                                    </ol>
                                @endif

                            </li>
                        @endforeach

                        @else

                    @endif
                </ol>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
{{--    <script src="{{asset('admin/js/plugins/nestable/jquery.nestable.js')}}"></script>--}}
    <script>
        $(document).ready(function () {

            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    //output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                } else {
                    output.val('浏览器不支持');
                }
            };
            // activate Nestable for list 1
            // $('#nestable').nestable({
            //     group: 1
            // }).on('change', updateOutput);

            // activate Nestable for list 2
            // $('#nestable2').nestable({
            //     group: 1,
            //     scroll:false,
            //     onDragStart: function(l,e){
            //         return false;
            //     }
            // }).on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));

            $('#nestable-menu').on('click', function (e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });
    </script>
@endsection
