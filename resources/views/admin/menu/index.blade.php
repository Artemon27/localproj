@extends('adminlte::page')

@section('title', 'Главное меню')

@section('content_header')
    <h1>Главное меню</h1>
@endsection

@section('content')
<form action="{{ route('admin.main.store') }}" method="post">
<div id="fordelete" class="row">
    <div class="col">        
        <div class="card">
            @include ('modules.messages')
            <div class="card-header">
                 <div class="row">     
                    <div class="col">
                        @csrf    
                        <button class="btn btn-primary" type="submit">Сохранить</button>
                    </div>  
                    <div class="col col col text-right">
                        <div class="input-group">              
                            <div class="col text-right">
                              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Добавить пункт меню
                              </a>
                            </div>                            
                          </div>
                          <img id="holder" style="margin-top:15px;max-height:100px;">
                    </div>
                </div>
            </div>
            <div class="card-body overflow-auto">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">Картинка</th>
                            <th width="30%">Название</th>
                            <th width="30%">Ссылка</th>
                            <th width="5%">Статус</th>
                            <th width="5%">Удалить</th>
                        </tr>
                    </thead>
                    <tbody id="gallery">
                    @forelse($menus as $menu)
                        <tr id="elem{{$menu->id}}">
                            <input type="hidden" name="menu[{{$menu->id}}][id]" value="{{$menu->id}}">
                            <td class="text-center"><a class="fm-edit"><input type="hidden" name="menu[{{$menu->id}}][src]" value="{{ $menu->src }}"><img src="{{ getThumbs($menu->src) }}" height="100px"></a></td>
                            <td>
                                <div class="row">
                                    <input class="col-11 image-title ignore-elements" type="hidden" name="menu[{{$menu->id}}][title]" value="{{$menu->title}} ">      
                                    <div class="col-11" onclick="editOne(this)">
                                        {{ $menu->title }}
                                    </div>                                    
                                    <a class="edit col-1 text-right" onclick="editOne(this)">                          
                                        <i class="far fa-edit"></i>
                                    </a>
                                </div>
                            </td>        
                            <td>
                                <div class="row">
                                    <input class="col-11 image-title ignore-elements" type="hidden" name="menu[{{$menu->id}}][url]" value="{{$menu->url}} ">      
                                    <div class="col-11" onclick="editOne(this)">
                                        {{ $menu->url }}
                                    </div>                                    
                                    <a class="edit col-1 text-right" onclick="editOne(this)">                          
                                        <i class="far fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                            <td><input type="hidden" name="menu[{{$menu->id}}][status]" value="{{$menu->status}}">
                                @if ($menu->status)
                                <div class="oea-status bg-success text-white p-1 text-center" onclick="statuschange(this)">Готово</div>
                                @else
                                <div class="oea-status bg-danger p-1 text-center text-nowrap" onclick="statuschange(this)">В разработке</div>
                                @endif
                            </td>
                            <td class="text-center">                                
                                <a class="delete text-red"
                                   data-id="{{ $menu->id }}"
                                   type="button"
                                   data-bs-toggle="modal"
                                   delete-id="{{$menu->id}}"
                                   data-bs-target="#delete_modal"
                                   onclick="deleteButton(this)"
                                   >
                                    <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                    @empty
                    </tbody>
                    <tbody id="emptylist">
                        <tr>
                            <td colspan="8" class="text-center">Список пуст</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Подтвердите удаление пункта меню</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#delete_modal').modal('hide')">Отмена</button>
                    <button id="delete_entry" type="button" class="btn btn-danger" onclick="deleteOne(this)">Удалить</button>
                </div>
            </div>
        </div>
    </div>  
    </div>
</div>
</form>
@endsection

@push('js')
<script src="{{ asset('js/sortable.js') }}"></script>

<script>
      
    
var maxId = {{$maxid}};

    
(function( $ ){
$.fn.filemanager = function(type, options) {
    type = type || 'file';

    this.on('click', function(e) {
      var num_images = 0;
      var i=0;
      var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
      var target_input = $('#gallery');
      var target_preview = $('#' + $(this).data('preview'));
      window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
      
      window.SetUrl = function (items) {
          console.log(items);
        num_images = items.length;
        for (i=0;i<num_images;i++)
        {
            maxId ++;
            // set the value of the desired input to image url                                                
            var elem = target_input.append('\
            <tr id="elem'+maxId+'">\
                <td class="text-center"><a class="fm-edit"><input type="hidden" name="menu['+maxId+'][src]" value="'+items[i].url+'"><img src="'+items[i].thumb_url+'" height="100px"></a></td>\
                <td>\
                    <div class="row">\
                        <input class="col-11 image-title ignore-elements" type="hidden" name="menu['+maxId+'][title]" value="Введите название">\
                        <div class="col-11" onclick="editOne(this)">Введите название</div>\
                        <a class="edit col-1 text-right" onclick="editOne(this)">\
                            <i class="far fa-edit"></i>\
                        </a>\
                    </div>\
                </td>\\n\
                <td>\
                    <div class="row">\
                        <input class="col-11 image-title ignore-elements" type="hidden" name="menu['+maxId+'][url]" value="Введите ссылку">\
                        <div class="col-11" onclick="editOne(this)">Введите ссылку</div>\
                        <a class="edit col-1 text-right" onclick="editOne(this)">\
                            <i class="far fa-edit"></i>\
                        </a>\
                    </div>\
                </td>\
                <td><input type="hidden" name="menu['+maxId+'][status]" value="1">\
                <div class="oea-status bg-success text-white p-1 text-center" onclick="statuschange(this)">Готово</div>\
                </td>\
                <td class="text-center">\
                <a class="delete text-red" data-id="'+maxId+'" type="button" data-bs-toggle="modal" data-bs-target="#delete_modal" onclick="deleteButton(this)">\
                <i class="far fa-trash-alt"></i></a>\
            </td>\
                                    ').trigger('change');    
            $('#elem'+maxId+' .image-title').keydown(function(event){
                if(event.keyCode == 13) {
                  editOk(this);
                }
            }) 
            $('#elem'+maxId+' .fm-edit').filemanagerIm('image');
        }
        
                                    
        $('#emptylist').detach();

        // clear previous preview
        target_preview.html('');

        // set or change the preview image src
        items.forEach(function (item) {
          target_preview.append(
            $('<img>').css('height', '5rem').attr('src', item.thumb_url)
          );
        });

        // trigger change event
        target_preview.trigger('change');
      };
      return false;
    });
  }

})(jQuery);

(function( $ ){
$.fn.filemanagerIm = function(type, options) {
    type = type || 'file';

    this.on('click', function(e) {
      var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
      var target_input = $(this);
      var target_preview = $('#' + $(this).data('preview'));
      window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
      window.SetUrl = function (items) {
        var file_path = items.map(function (item) {
          return item.url;
        }).join(',');
        var file_thuml_path = items.map(function (item) {
          return item.thumb_url;
        }).join(',');
        // set the value of the desired input to image url                  

        target_input.children('img').attr("src", file_thuml_path);
        target_input.children('input').attr("value", file_path);
        
        // clear previous preview
        target_preview.html('');

        // set or change the preview image src
        items.forEach(function (item) {
          target_preview.append(
            $('<img>').css('height', '5rem').attr('src', item.thumb_url)
          );
        });
        // trigger change event
        target_preview.trigger('change');
      };
      return false;
    });
  }

})(jQuery);
   
$('#lfm').filemanager('image');
$('.fm-edit').filemanagerIm('image');


$(document).ready(function() {
    $('form').keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
      }
   });
   $('.image-title').keydown(function(event){
        if(event.keyCode == 13) {
          editOk(this);
      }
   });
  })

function deleteButton(elem){
    if ($(elem).attr('delete-id')){
        $('#delete_entry').attr('delete-id',$(elem).attr('delete-id'));
    }
    $('#delete_entry').attr('delete_entry_id',$(elem).attr('data-id'));
    $('#deleteModalLabel').html("Подтвердите удаление записи "+ $(elem).attr('data-id'));
    $('#delete_modal').modal('show');
}
   
function deleteOne(elem){
    if ($(elem).attr('delete-id')){
        $('#fordelete').append('<input type="hidden" name="image_delete[]" value="'+$(elem).attr('delete-id')+'">');
    }
    $('#elem'+$(elem).attr('delete_entry_id')).detach();
    $('#delete_modal').modal('hide');     
}
    
function editOne(elem){
    $(elem).parent().children('div').hide();
    $(elem).parent().children('input').attr('type','text');
    $(elem).parent().children('a').attr('onclick','editOk(this)')
    $(elem).parent().children('div').attr('onclick','editOk(this)')
}
    
function editOk(elem){
    $(elem).parent().children('input').attr('type','hidden');
    $(elem).parent().children('div').text($(elem).parent().children('input').attr('value'));
    $(elem).parent().children('div').show();        
    $(elem).parent().children('a').attr('onclick','editOne(this)')
    $(elem).parent().children('div').attr('onclick','editOne(this)')
}

function statuschange (elem){
    var value = +$(elem).parent().children('input').attr('value');
    if (value){
        $(elem).parent().children('input').attr('value',0);
        $(elem).addClass('bg-danger text-nowrap');
        $(elem).removeClass('bg-success text-white');
        $(elem).text('В разработке');
    }  
    else {
        $(elem).parent().children('input').attr('value',1);
        $(elem).addClass('bg-success text-white');
        $(elem).removeClass('bg-danger text-nowrap');
        $(elem).text('Готово');
    }
  }
</script>
@endpush